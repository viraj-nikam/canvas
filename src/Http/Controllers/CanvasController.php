<?php

namespace Canvas\Http\Controllers;

class CanvasController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('canvas::canvas.dashboard.index');
    }
}
