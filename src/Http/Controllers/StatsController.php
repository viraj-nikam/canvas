<?php

namespace Canvas\Http\Controllers;

use Canvas\Post;
use Illuminate\View\View;
use Illuminate\Routing\Controller;

class StatsController extends Controller
{
    /**
     * Show the overall stats dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        $posts = Post::with('views')->paginate(10);
        $views = \Canvas\View::all();

        $data = [
            'posts' => [
                'all'       => $posts,
                'published' => $posts->where('published_at', '<=', now()->toDateTimeString()),
                'drafts'    => $posts->where('published_at', '>', now()->toDateTimeString()),
            ],
            'views' => [
                'all' => $views->count(),
                'trend' => json_encode(\Canvas\View::viewTrend($views)),
            ],
        ];

        return view('canvas::canvas.stats.index', compact('data'));
    }

    /**
     * Display stats for a single post.
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $post = Post::with('views')->findOrFail($id);

        if ($post->published) {
            $data = [
                'post'                  => $post,
                'traffic'               => $post->topReferers,
                'popular_reading_times' => $post->popularReadingTimes,
                'views'                 => json_encode($post->viewTrend),
            ];

            return view('canvas::canvas.stats.show', compact('data'));
        } else {
            abort(404);
        }
    }
}
