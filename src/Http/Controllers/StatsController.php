<?php

namespace Canvas\Http\Controllers;

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
        return view('canvas::canvas.stats.index');
    }
}
