<?php

namespace Canvas\Http\Controllers;

class PostController extends Controller
{
    /**
     * Show all the posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('canvas::canvas.posts.index');
    }

    /**
     * Show the new post creation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('canvas::canvas.posts.create');
    }
}
