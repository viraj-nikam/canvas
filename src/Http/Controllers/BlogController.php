<?php

namespace Canvas\Http\Controllers;

use Illuminate\View\View;
use Canvas\Interfaces\PostInterface;

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
            'posts' => app(PostInterface::class)->getPublished()
        ];

        return view('canvas::blog.index', compact('data'));
    }
}
