<?php

namespace Canvas\Http\Controllers;

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
        dd('tag.index');

        $data = [
            //
        ];

        return view('canvas::blog.index', compact('data'));
    }
}
