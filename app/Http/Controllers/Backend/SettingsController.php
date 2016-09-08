<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.settings.index');
    }
}
