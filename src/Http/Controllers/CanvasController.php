<?php

namespace Canvas\Http\Controllers;

use Illuminate\View\View;
use Canvas\Traits\Paginate;
use Illuminate\Routing\Controller;

class CanvasController extends Controller
{
    use Paginate;

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
