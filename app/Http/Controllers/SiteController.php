<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Display the application landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.landing.index');
    }
}
