<?php

namespace Canvas\Http\Controllers;

use Canvas\Helpers\Traffic;
use Canvas\Models\Post;
use Canvas\Models\User;
use Canvas\Models\View;
use Canvas\Models\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $scope = $request->query('scope', 'published');

        $posts = Post::when($scope, function ($query, $scope) use ($request) {
            if ($scope === 'all') {
                return $query;
            }

            return $query->where('user_id', $request->user('canvas')->id);
        })->published()->latest()->get();

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
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function show(Request $request, string $id): JsonResponse
    {
        $user = User::firstWhere('id', $request->user('canvas')->id);

        if ($user->isAdmin || $user->isEditor) {
            $post = Post::find($id);
        } else {
            $post = Post::where('user_id', $request->user('canvas')->id)->find($id);
        }

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
