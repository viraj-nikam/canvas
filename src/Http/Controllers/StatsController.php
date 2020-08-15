<?php

namespace Canvas\Http\Controllers;

use Canvas\Helpers\Traffic;
use Canvas\Models\Post;
use Canvas\Models\View;
use Canvas\Models\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        if (request()->query('scope') === 'all') {
            $posts = Post::published()->latest()->get();
        } else {
            $posts = Post::forUser(request()->user())->published()->latest()->get();
        }

        $views = View::select('created_at')
                     ->whereIn('post_id', $posts->pluck('id'))
                     ->whereBetween('created_at', [
                         today()->subDays(30)->startOfDay()->toDateTimeString(),
                         today()->endOfDay()->toDateTimeString(),
                     ])->get();

        $visits = Visit::select('created_at')
                       ->whereIn('post_id', $posts->pluck('id'))
                       ->whereBetween('created_at', [
                           today()->subDays(30)->startOfDay()->toDateTimeString(),
                           today()->endOfDay()->toDateTimeString(),
                       ])->get();

        return response()->json([
            'posts' => $posts,
            'totalViews' => $views->count(),
            'totalVisits' => $visits->count(),
            'traffic' => [
                'views' => json_encode(Traffic::calculateTotalForDays($views, 30)),
                'visits' => json_encode(Traffic::calculateTotalForDays($visits, 30)),
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $post = Post::forUser(request()->user())->find($id);

        if (! $post || ! $post->published) {
            return response()->json(null, 404);
        }

        $views = View::where('post_id', $post->id)->get();
        $previousMonthlyViews = $views->whereBetween('created_at', [
            today()->subMonth()->startOfMonth()->startOfDay()->toDateTimeString(),
            today()->subMonth()->endOfMonth()->endOfDay()->toDateTimeString(),
        ]);
        $currentMonthlyViews = $views->whereBetween('created_at', [
            today()->startOfMonth()->startOfDay()->toDateTimeString(),
            today()->endOfMonth()->endOfDay()->toDateTimeString(),
        ]);
        $lastThirtyDays = $views->whereBetween('created_at', [
            today()->subDays(30)->startOfDay()->toDateTimeString(),
            today()->endOfDay()->toDateTimeString(),
        ]);

        $visits = Visit::where('post_id', $post->id)->get();
        $previousMonthlyVisits = $visits->whereBetween('created_at', [
            today()->subMonth()->startOfMonth()->startOfDay()->toDateTimeString(),
            today()->subMonth()->endOfMonth()->endOfDay()->toDateTimeString(),
        ]);
        $currentMonthlyVisits = $visits->whereBetween('created_at', [
            today()->startOfMonth()->startOfDay()->toDateTimeString(),
            today()->endOfMonth()->endOfDay()->toDateTimeString(),
        ]);

        return response()->json([
            'post' => $post,
            'readTime' => $post->read_time,
            'popularReadingTimes' => $post->popular_reading_times,
            'topReferers' => $post->top_referers,
            'monthlyViews' => $currentMonthlyViews->count(),
            'totalViews' => $views->count(),
            'monthlyVisits' => $currentMonthlyVisits->count(),
            'monthOverMonthViews' => Traffic::compareMonthOverMonth($currentMonthlyViews, $previousMonthlyViews),
            'monthOverMonthVisits' => Traffic::compareMonthOverMonth($currentMonthlyVisits, $previousMonthlyVisits),
            'traffic' => [
                'views' => json_encode(Traffic::calculateTotalForDays($lastThirtyDays, 30)),
                'visits' => json_encode(Traffic::calculateTotalForDays($visits, 30)),
            ],
        ]);
    }
}
