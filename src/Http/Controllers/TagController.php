<?php

namespace Canvas\Http\Controllers;

use Canvas\Tag;
use Illuminate\View\View;
use Illuminate\Routing\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $data = [
            'tags' => Tag::orderByDesc('created_at')->with('posts')->paginate(15),
        ];

        return view('canvas::canvas.tags.index', compact('data'));
    }
}
