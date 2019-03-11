<?php

namespace Canvas\Http\Controllers;

use Illuminate\Routing\Controller;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     *
     * @return string
     */
    public function index()
    {
        return view('canvas::settings.index');
    }
}
