<?php

namespace App\Http\Controllers\Backend;

use App\Services\Search;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Display search result.
     *
     * @return \Illuminate\View\View
     */
    public function index(Search $search)
    {
        $posts = $search->posts();
        $tags = $search->tags();

        return view('backend.search.index', compact('posts', 'tags'));
    }
}
