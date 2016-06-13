<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

class ProfileController extends Controller
{
    /**
     * Display the user profile page
     */
    public function index()
    {
        return view('backend.profile.index');
    }

    /**
     * Display the user profile edit page
     */
    public function edit($id)
    {
        return view('backend.profile.edit');
    }
}
