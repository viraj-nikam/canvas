<?php

namespace Canvas\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Routing\Controller;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('canvas::canvas.settings.index');
    }
}
