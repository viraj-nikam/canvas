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
        $notes = Note::query()
            ->select('id', 'body', 'created_at', 'updated_at')
            ->when(request()->user('canvas')->isContributor || request()->query('scope', 'user') != 'all', function (Builder $query) {
                return $query->where('user_id', request()->user('canvas')->id);
            }, function (Builder $query) {
                return $query;
            })
            ->latest()
            ->paginate();

        return response()->json([
            'notes' => $notes,
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
}

