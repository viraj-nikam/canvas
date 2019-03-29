<?php

namespace Canvas\Http\Controllers;

use Canvas\Post;
use Canvas\View;
use Illuminate\Routing\Controller;

class StatsController extends Controller
{
    /**
     * The number of days to generate statistics for.
     *
     * @const int
     */
    const DAYS_PRIOR = 30;

    /**
     * Show the overall statistics for all posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::withCount('views')->orderByDesc('created_at')->paginate();
        $views = View::whereBetween('created_at', [
            now()->subDays(self::DAYS_PRIOR)->toDateTimeString(),
            now()->toDateTimeString(),
        ])->select('created_at')->get();

        $data = [
            'posts' => [
                'all'       => $posts,
                'published' => $posts->where('published_at', '<=', now()->toDateTimeString()),
                'drafts'    => $posts->where('published_at', '>', now()->toDateTimeString()),
            ],
            'views' => [
                'count' => $views->count(),
                'trend' => json_encode(View::viewTrend($views, self::DAYS_PRIOR)),
            ],
        ];

        return view('canvas::stats.index', compact('data'));
    }

    /**
     * Show data analytics for a single post.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->published) {
            $data = [
                'post'                  => $post,
                'traffic'               => $post->top_referers,
                'popular_reading_times' => $post->popular_reading_times,
                'views'                 => json_encode($post->view_trend),
            ];

            return view('canvas::stats.show', compact('data'));
        } else {
            abort(404);
        }
    }
}
