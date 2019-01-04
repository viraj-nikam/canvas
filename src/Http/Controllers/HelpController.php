<?php

namespace Canvas\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Controller;

class HelpController extends Controller
{
    /**
     * Show the help page.
     *
     * @return View
     */
    public function __invoke(): View
    {
        return view('canvas::canvas.help.index');
    }
}
