<?php

namespace Canvas\Http\Controllers;

class BlogController extends Controller
{
    /**
     * Show the public-facing blog homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('canvas::blog.index');
    }
}
