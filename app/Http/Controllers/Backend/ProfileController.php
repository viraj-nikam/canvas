<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display the user profile page
     */
    public function index()
    {
        $userData = Auth::user()->toArray();
        $blogData = config('blog');

        $data = array_merge($userData, $blogData);
        $data['phone'] = User::formatPhone($data['phone']);

        return view('backend.profile.index', compact('data'));
    }

    /**
     * Display the user profile edit page
     *
     * @param $id
     */
    public function edit($id)
    {
        return view('backend.profile.edit');
    }
}
