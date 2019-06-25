<?php

namespace Canvas\Http\Controllers;

use Canvas\Canvas;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('canvas::layout', [
            'canvasScriptVariables' => Canvas::scriptVariables(),
            'canvasCssFile'         => Canvas::$useDarkMode ? 'app-dark.css' : 'app.css',
        ]);
    }
}
