<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display the users management page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.users.index');
    }
}
