<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ProfileUpdateRequest;
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
        !empty($data['phone']) ? $data['phone'] = User::formatPhone($data['phone']) : '';

        return view('backend.profile.index', compact('data'));
    }

    /**
     * Display the user profile edit page
     *
     * @param $id
     */
    public function edit($id)
    {
        $userData = User::where('id', $id)->firstOrFail()->toArray();
        $blogData = config('blog');
        $data = array_merge($userData, $blogData);
        isset($data['phone']) ? $data['phone'] = User::formatPhone($data['phone']) : '';

        return view('backend.profile.edit', compact('data'));
    }

    /**
     * Update the user profile information.
     *
     * @param $id
     */
    public function update(ProfileUpdateRequest $request, $id)
    {
        if(isset($request->phone)) {
            $phone = $request->phone;
            $request['phone'] = preg_replace('/\D+/', '', $phone);
        }
        $user = User::findOrFail($id);
        $user->fill($request->toArray())->save();
        $user->save();

        return redirect()->route('admin.profile.edit', $id)->withSuccess('Profile has been updated.');
    }
}
