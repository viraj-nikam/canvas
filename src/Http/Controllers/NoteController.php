<?php

namespace Canvas\Http\Controllers;

use Canvas\Http\Requests\NoteRequest;
use Canvas\Models\Note;
use Canvas\Models\Tag;
use Canvas\Models\Topic;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tag = request()->query('tag', 'all');
        $scopedToUser = request()->user('canvas')->isContributor || request()->query('scope', 'user') != 'all';

        $notes = Note::query()
            ->select('id', 'title', 'body', 'created_at', 'updated_at')
            ->when($scopedToUser, function (Builder $query) {
                return $query->where('user_id', request()->user('canvas')->id);
            }, function (Builder $query) {
                return $query;
            })
            // In the default "all" state, show only untagged notes
            ->when($tag === 'all', function (Builder $query) {
                return $query->doesntHave('tags');
            })
            ->when($tag && $tag !== 'all', function (Builder $query) use ($tag) {
                return $query->whereHas('tags', function (Builder $q) use ($tag) {
                    $q->where('slug', $tag);
                });
            })
            ->latest()
            ->paginate();

        $tags = Tag::query()
            ->select('name', 'slug')
            ->whereHas('notes', function (Builder $q) use ($scopedToUser) {
                if ($scopedToUser) {
                    $q->where('user_id', request()->user('canvas')->id);
                }
            })
            ->orderBy('name')
            ->get();

        return response()->json([
            'notes' => $notes,
            'tags' => $tags,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $uuid = Uuid::uuid4();

        return response()->json([
            'note' => Note::query()->make([
                'id' => $uuid->toString(),
                'title' => null,
                'body' => null,
            ]),
            'tags' => Tag::query()->get(['name', 'slug']),
            'topics' => Topic::query()->get(['name', 'slug']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NoteRequest  $request
     * @param  string  $id
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function store(NoteRequest $request, string $id): JsonResponse
    {
        $data = $request->validated();

        $note = Note::query()
            ->when($request->user('canvas')->isContributor, function (Builder $query) {
                return $query->where('user_id', request()->user('canvas')->id);
            }, function (Builder $query) {
                return $query;
            })
            ->with('tags', 'topic')
            ->find($id);

        if (! $note) {
            $note = new Note(['id' => $id]);
        }

        // Only update permitted attributes since the table is body-only
        $note->title = $data['title'] ?? $note->title;
        $note->body = $data['body'] ?? $note->body;
        $note->user_id = $note->user_id ?? request()->user('canvas')->id;
        $note->save();

        $tags = Tag::query()->get(['id', 'name', 'slug']);
        $topics = Topic::query()->get(['id', 'name', 'slug']);

        $tagsToSync = collect($request->input('tags', []))->map(function ($item) use ($tags) {
            $tag = $tags->firstWhere('slug', $item['slug']);

            if (! $tag) {
                $tag = Tag::create([
                    'id' => Uuid::uuid4()->toString(),
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'user_id' => request()->user('canvas')->id,
                ]);
            }

            return (string) $tag->id;
        })->toArray();

        $topicToSync = collect($request->input('topic', []))->map(function ($item) use ($topics) {
            $topic = $topics->firstWhere('slug', $item['slug']);

            if (! $topic) {
                $topic = Topic::create([
                    'id' => Uuid::uuid4()->toString(),
                    'name' => $item['name'],
                    'slug' => $item['slug'],
                    'user_id' => request()->user('canvas')->id,
                ]);
            }

            return (string) $topic->id;
        })->toArray();

        $note->tags()->sync($tagsToSync);
        $note->topic()->sync($topicToSync);

        return response()->json($note->refresh(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $note = Note::query()
            ->when(request()->user('canvas')->isContributor, function (Builder $query) {
                return $query->where('user_id', request()->user('canvas')->id);
            }, function (Builder $query) {
                return $query;
            })
            ->with('tags:name,slug', 'topic:name,slug')
            ->findOrFail($id);

        $user = request()->user('canvas');
        $isFavorite = $note->favorites()->where('canvas_notes_favorites.user_id', $user->id)->exists();

        // Attach is_favorite attribute without mutating the model's table
        $note->setAttribute('is_favorite', $isFavorite);

        return response()->json([
            'note' => $note,
            'tags' => Tag::query()->get(['name', 'slug']),
            'topics' => Topic::query()->get(['name', 'slug']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return mixed
     *
     * @throws Exception
     */
    public function destroy(string $id)
    {
        $note = Note::query()
            ->when(request()->user('canvas')->isContributor, function (Builder $query) {
                return $query->where('user_id', request()->user('canvas')->id);
            }, function (Builder $query) {
                return $query;
            })
            ->findOrFail($id);

        $note->delete();

        return response()->json(null, 204);
    }

    /**
     * Duplicate the specified resource and return the new note.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function duplicate(string $id): JsonResponse
    {
        $original = Note::query()
            ->when(request()->user('canvas')->isContributor, function (Builder $query) {
                return $query->where('user_id', request()->user('canvas')->id);
            }, function (Builder $query) {
                return $query;
            })
            ->with('tags:id', 'topic:id')
            ->findOrFail($id);

        $newId = Uuid::uuid4()->toString();

        $duplicate = new Note([
            'id' => $newId,
        ]);

        $duplicate->title = 'Copy of ' . $original->title;
        $duplicate->body = $original->body;
        $duplicate->user_id = request()->user('canvas')->id;
        $duplicate->save();

        // Sync relationships
        $duplicate->tags()->sync($original->tags->pluck('id')->toArray());
        $duplicate->topic()->sync($original->topic->pluck('id')->toArray());

        return response()->json($duplicate->fresh(['tags:name,slug', 'topic:name,slug']), 201);
    }

    /**
     * Return the current user's starred notes filtered by tag/scope.
     */
    public function starred(): JsonResponse
    {
        $user = request()->user('canvas');
        $tag = request()->query('tag', 'all');
        $scopedToUser = $user->isContributor || request()->query('scope', 'user') != 'all';

        $query = Note::query()
            ->select('canvas_notes.id', 'title', 'body', 'canvas_notes.created_at', 'canvas_notes.updated_at')
            ->join('canvas_notes_favorites as fav', 'fav.note_id', '=', 'canvas_notes.id')
            ->where('fav.user_id', $user->id)
            ->when($scopedToUser, function (Builder $q) use ($user) {
                return $q->where('canvas_notes.user_id', $user->id);
            }, function (Builder $q) {
                return $q;
            })
            ->when($tag === 'all', function (Builder $q) {
                return $q->doesntHave('tags');
            })
            ->when($tag && $tag !== 'all', function (Builder $q) use ($tag) {
                return $q->whereHas('tags', function (Builder $qq) use ($tag) {
                    $qq->where('slug', $tag);
                });
            })
            ->latest();

        $notes = $query->get();

        return response()->json([
            'notes' => $notes,
        ], 200);
    }

    /**
     * Mark a note as favorite for the current user.
     */
    public function favorite(string $id): JsonResponse
    {
        $user = request()->user('canvas');
        $note = Note::query()->findOrFail($id);
        $note->favorites()->syncWithoutDetaching([$user->id]);

        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Remove a note from favorites for the current user.
     */
    public function unfavorite(string $id): JsonResponse
    {
        $user = request()->user('canvas');
        $note = Note::query()->findOrFail($id);
        $note->favorites()->detach([$user->id]);

        return response()->json(['status' => 'ok'], 200);
    }
}
