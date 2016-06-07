<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    /**
     * Display the application landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.landing.index');
    }
}
