<?php

namespace Canvas\Http\Controllers;

use Illuminate\View\View;
use Canvas\Traits\Paginator;
use Illuminate\Routing\Controller;

class CanvasController extends Controller
{
    use Paginator;

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        return view('canvas::canvas.dashboard.index');
    }
}
