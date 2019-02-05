<?php

namespace Canvas\Http\Controllers;

use Canvas\Post;
use Illuminate\View\View;
use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    /**
     * Show the blog homepage with a paginated list of posts.
     *
     * @return View
     */
    public function index(): View
    {
        $data = [
            'posts' => Post::published()->orderByDesc('published_at')->simplePaginate(10),
        ];

        return view('canvas::blog.index', compact('data'));
    }
}
