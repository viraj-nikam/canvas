<?php

namespace Canvas\Http\Controllers;

use Canvas\Paginate;
use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Canvas\Interfaces\TagInterface;

class TagController extends Controller
{
    use Paginate;

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return View
     */
    public function show($slug): View
    {
        $tag = app(TagInterface::class)->findBySlug($slug);

        $posts = $tag->posts->filter(function ($post) {
            return $post->published;
        });

        $data = [
            'posts' => $this->paginate($posts->sortByDesc('created_at'), 5),
        ];

        return view('canvas::blog.index', compact('data'));
    }
}
