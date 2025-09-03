<?php

namespace Canvas\Http\Controllers;

use Canvas\Models\Post;
use Canvas\Models\Note;
use Canvas\Models\Tag;
use Canvas\Models\Topic;
use Canvas\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class SearchController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function posts(): JsonResponse
    {
        $posts = Post::query()
                     ->select('id', 'title')
                     ->when(request()->user('canvas')->isContributor, function (Builder $query) {
                         return $query->where('user_id', request()->user('canvas')->id);
                     }, function (Builder $query) {
                         return $query;
                     })
                     ->latest()
                     ->get();

        // TODO: Can ->map() drop into the above query?

        $posts->map(function ($post) {
            $post['name'] = $post->title;
            $post['type'] = 'Post';
            $post['route'] = 'edit-post';

            return $post;
        });

        return response()->json(collect($posts)->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function notes(): JsonResponse
    {
        $notes = Note::query()
            ->select('id', 'body')
            ->when(request()->user('canvas')->isContributor, function (Builder $query) {
                return $query->where('user_id', request()->user('canvas')->id);
            }, function (Builder $query) {
                return $query;
            })
            ->latest()
            ->get();

        $notes->map(function ($note) {
            // Use a plain-text snippet for searching and display
            $text = trim(strip_tags((string) $note->body));
            $note['name'] = mb_strimwidth($text, 0, 140, '…');
            $note['type'] = 'Note';
            $note['route'] = 'edit-note';

            return $note;
        });

        return response()->json(collect($notes)->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function tags(): JsonResponse
    {
        $tags = Tag::query()
                   ->select('id', 'name')
                   ->latest()
                   ->get();

        $tags->map(function ($tag) {
            $tag['type'] = 'Tag';
            $tag['route'] = 'edit-tag';

            return $tag;
        });

        return response()->json(collect($tags)->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function topics(): JsonResponse
    {
        $topics = Topic::query()
                       ->select('id', 'name')
                       ->latest()
                       ->get();

        $topics->map(function ($topic) {
            $topic['type'] = 'Topic';
            $topic['route'] = 'edit-topic';

            return $topic;
        });

        return response()->json(collect($topics)->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function users(): JsonResponse
    {
        $users = User::query()
                     ->select('id', 'name', 'email')
                     ->latest()
                     ->get();

        $users->map(function ($user) {
            $user['type'] = 'User';
            $user['route'] = 'edit-user';

            return $user;
        });

        return response()->json(collect($users)->toArray(), 200);
    }
}
