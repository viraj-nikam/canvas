<?php

namespace Canvas\Http\Controllers;

use Canvas\Post;
use Canvas\Trends;
use Canvas\View;
use Canvas\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class StatsController extends Controller
{
    use Trends;

    /**
     * Number of days to compile stats.
     *
     * @const int
     */
    private const DAYS_PRIOR = 30;

    /**
     * Get all the stats.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $published = Post::forCurrentUser()
                         ->published()
                         ->latest()
                         ->get();

        // Get views for the last [X] days
        $views = View::select('created_at')
                     ->whereIn('post_id', $published->pluck('id'))
                     ->whereBetween('created_at', [
                         today()->subDays(self::DAYS_PRIOR)->startOfDay()->toDateTimeString(),
                         today()->endOfDay()->toDateTimeString(),
                     ])->get();

        // Get visits for the last [X] days
        $visits = Visit::select('created_at')
                       ->whereIn('post_id', $published->pluck('id'))
                       ->whereBetween('created_at', [
                           today()->subDays(self::DAYS_PRIOR)->startOfDay()->toDateTimeString(),
                           today()->endOfDay()->toDateTimeString(),
                       ])->get();

        return response()->json([
            'view_count'      => $views->count(),
            'view_trend'      => json_encode($this->getDataPoints($views, self::DAYS_PRIOR)),
            'visit_count'     => $visits->count(),
            'visit_trend'     => json_encode($this->getDataPoints($visits, self::DAYS_PRIOR)),
            'published_count' => $published->count(),
            'draft_count'     => Post::forCurrentUser()->draft()->count(),
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
        $post = Post::forCurrentUser()->find($id);

        if ($post && $post->published) {
            // Get views for the last [X] days
            $views = View::select('created_at')
                         ->where('post_id', $post->id)
                         ->whereBetween('created_at', [
                             today()->subDays(self::DAYS_PRIOR)->startOfDay()->toDateTimeString(),
                             today()->endOfDay()->toDateTimeString(),
                         ])->get();

            // Get visits for the last [X] days
            $visits = Visit::select('created_at')
                           ->where('post_id', $post->id)
                           ->whereBetween('created_at', [
                               today()->subDays(self::DAYS_PRIOR)->startOfDay()->toDateTimeString(),
                               today()->endOfDay()->toDateTimeString(),
                           ])->get();

            return response()->json([
                'post'                   => $post,
                'read_time'              => $post->read_time,
                'popular_reading_times'  => $post->popular_reading_times,
                'traffic'                => $post->top_referers,
                'view_count'             => $views->count(),
                'view_trend'             => json_encode($this->getDataPoints($views, self::DAYS_PRIOR)),
                'view_month_over_month'  => $this->compareMonthToMonth($post->views),
                'visit_count'            => $visits->count(),
                'visit_trend'            => json_encode($this->getDataPoints($visits, self::DAYS_PRIOR)),
                'visit_month_over_month' => $this->compareMonthToMonth($post->visits),
            ]);
        } else {
            return response()->json(null, 301);
        }
    }
}
