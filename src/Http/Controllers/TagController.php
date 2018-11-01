<?php

namespace Canvas\Http\Controllers;

use Illuminate\View\View;
use Canvas\Traits\Paginate;
use Illuminate\Routing\Controller;
use Canvas\Interfaces\TagInterface;

class TagController extends Controller
{
    use Paginate;

    const ITEMS_PER_PAGE = 5;

    /**
     * Display a listing of the resource.
     *
     * @param TagInterface $tagRepository Tag Repository
     * @param string $slug Slug
     *
     * @return View
     */
    public function index(TagInterface $tagRepository, $slug): View
    {
        $tag = $tagRepository->findBySlug($slug);
        $posts = $tag->posts->filter(function ($post) {
            return $post->published;
        });

        $data = [
            'tag'   => $tag->name,
            'posts' => $this->paginate(
                $posts->sortByDesc('created_at'),
                self::ITEMS_PER_PAGE
            ),
        ];

        return view('canvas::blog.index', compact('data'));
    }
}
