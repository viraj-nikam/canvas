<?php

namespace Canvas\Http\Controllers;

use Illuminate\Routing\Controller;

class ViewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('canvas::layout');
    }
}
