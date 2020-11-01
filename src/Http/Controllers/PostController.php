<?php

namespace Canvas\Http\Controllers;

use Canvas\Http\Requests\PostRequest;
use Canvas\Models\Post;
use Canvas\Models\Tag;
use Canvas\Models\Topic;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $type = request()->query('type', 'published');
        $scope = request()->query('scope', 'user');

        $posts = Post::when(request()->user('canvas')->isContributor || $scope != 'all', function ($query) {
            return $query->where('user_id', request()->user('canvas')->id);
        }, function ($query) {
            return $query;
        })->when($type != 'draft', function ($query) {
            return $query->published();
        }, function ($query) {
            return $query->draft();
        })->latest()->withCount('views')->paginate();

        $draftCount = Post::when(request()->user('canvas')->isContributor || $scope != 'all', function ($query) {
            return $query->where('user_id', request()->user('canvas')->id);
        }, function ($query) {
            return $query;
        })->draft()->count();

        $publishedCount = Post::when(request()->user('canvas')->isContributor || $scope != 'all', function ($query) {
            return $query->where('user_id', request()->user('canvas')->id);
        }, function ($query) {
            return $query;
        })->published()->count();

        return response()->json([
            'posts' => $posts,
            'draftCount' => $draftCount,
            'publishedCount' => $publishedCount,
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
            'post' => Post::make([
                'id' => $uuid->toString(),
                'slug' => "post-{$uuid->toString()}",
            ]),
            'tags' => Tag::get(['name', 'slug']),
            'topics' => Topic::get(['name', 'slug']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function store(PostRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $post = Post::when($request->user('canvas')->isContributor, function ($query) {
            return $query->where('user_id', request()->user('canvas')->id);
        }, function ($query) {
            return $query;
        })->with('tags', 'topic')->find($id);

        if (! $post) {
            $post = new Post(['id' => $id]);
        }

        $post->fill($data);

        $post->user_id = $post->user_id ?? request()->user('canvas')->id;

        $post->save();

        $post->tags()->sync($this->relatedTaxonomy('tags', $request->input('tags', [])));

        $post->topic()->sync($this->relatedTaxonomy('topic', $request->input('topic', [])));

        return response()->json($post->refresh(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $post = Post::when(request()->user('canvas')->isContributor, function ($query) {
            return $query->where('user_id', request()->user('canvas')->id);
        }, function ($query) {
            return $query;
        })->with('tags:name,slug', 'topic:name,slug')->find($id);

        if ($post) {
            return response()->json([
                'post' => $post,
                'tags' => Tag::get(['name', 'slug']),
                'topics' => Topic::get(['name', 'slug']),
            ]);
        } else {
            return response()->json(null, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $post = Post::when(request()->user('canvas')->isContributor, function ($query) {
            return $query->where('user_id', request()->user('canvas')->id);
        }, function ($query) {
            return $query;
        })->findOrFail($id);

        $post->delete();

        return response()->json(null, 204);
    }

    /**
     * Return an array of tag or topic IDs to sync related taxonomy with a post.
     *
     * @param string $type
     * @param array $items
     * @return array|string[]
     */
    protected function relatedTaxonomy(string $type, array $items = []): array
    {
        if (collect($items)->isEmpty()) {
            return [];
        }

        switch ($type) {
            case 'tags':
                $tags = Tag::get(['id', 'name', 'slug']);

                return collect($items)->map(function ($item) use ($tags) {
                    $tag = $tags->firstWhere('slug', $item['slug']);

                    if (! $tag) {
                        $tag = Tag::create([
                            'id' => $id = Uuid::uuid4()->toString(),
                            'name' => $item['name'],
                            'slug' => $item['slug'],
                            'user_id' => request()->user('canvas')->id,
                        ]);
                    }

                    return (string) $tag->id;
                })->toArray();

            case 'topic':
                // Since the multiselect component handles single selects differently, when we try and
                // attach an existing topic it will enter as an object in an array. A newly created
                // topic will come in strictly as an array with only a name and a slug.
                $topicToAssign = empty($incomingTopic[0]) ? $items : $incomingTopic[0];

                $topic = Topic::firstWhere('slug', $topicToAssign['slug']);

                if (! $topic) {
                    $topic = Topic::create([
                        'id' => $id = Uuid::uuid4()->toString(),
                        'name' => $topicToAssign['name'],
                        'slug' => $topicToAssign['slug'],
                        'user_id' => request()->user('canvas')->id,
                    ]);
                }

                return [(string) $topic->id];

            default:
                break;
        }
    }
}
