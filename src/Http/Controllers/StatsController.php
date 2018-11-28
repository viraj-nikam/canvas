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
        $data = [
            'posts' => Post::published()->get(),
        ];

        return view('canvas::canvas.stats.index', compact('data'));
    }
}
