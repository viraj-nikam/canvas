<?php

namespace Canvas\Http\Controllers;

use Canvas\Post;
use Canvas\View;
use Canvas\Trends;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class StatsController extends Controller
{
    use Trends;

    /**
     * Number of days in the past to generate stats for.
     *
     * @const int
     */
    const DAYS_PRIOR = 30;

    /**
     * Get all the stats.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $published = Post::published()
            ->orderByDesc('created_at')
            ->withCount('views')
            ->get();

        // Append the estimated reading time
        $published->each->append('read_time');

        // Get views for the last [X] days
        $views = View::select('created_at')
            ->whereBetween('created_at', [
                now()->subDays(self::DAYS_PRIOR)->toDateTimeString(),
                now()->toDateTimeString(),
            ])->get();

        return response()->json([
            'posts' => [
                'all'             => $published,
                'published_count' => $published->count(),
                'drafts_count'    => Post::draft()->count(),
            ],
            'views' => [
                'count' => $views->count(),
                'trend' => json_encode($this->getViewTrends($views, self::DAYS_PRIOR)),
            ],
        ]);
    }

    /**
     * Get stats for a single post.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $post = Post::findOrFail($id);

        if ($post->published) {
            return response()->json([
                'post'                  => $post,
                'traffic'               => $post->top_referers,
                'popular_reading_times' => $post->popular_reading_times,
                'views'                 => json_encode($this->getViewTrends($post->views, self::DAYS_PRIOR)),
            ]);
        }
    }
}
