<?php

namespace Canvas\Http\Controllers;

use Canvas\Post;
use Illuminate\View\View;
use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    /**
     * Show the public-facing blog homepage.
     *
     * @return View
     */
    public function index(): View
    {
        $data = [
            'posts' => Post::published()->orderByDesc('published_at')->with('tags')->paginate(15),
        ];

        return view('canvas::blog.index', compact('data'));
    }
}
