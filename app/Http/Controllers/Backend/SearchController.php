<?php

namespace App\Http\Controllers\Backend;

use App\Models\Post;
use App\Models\Tag;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Display search result.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $params = request('search');
        $posts = Post::search($params)->get();
        $tags = Tag::search($params)->get();

        return view('backend.search.index', compact('posts', 'tags'));
    }
}
