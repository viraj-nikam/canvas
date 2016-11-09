<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserCreateRequest;

class UserController extends Controller
{
    /**
     * Display the users index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = User::all();

        return view('backend.user.index', compact('data'));
    }

    /**
     * Display the add a new user page.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.user.create');
    }

    /**
     * Store a new user in the database.
     *
     * @param UserCreateRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function store(UserCreateRequest $request)
    {
        $user = new User();
        $user->fill($request->toArray())->save();
        $user->password = bcrypt($request->password);
        $user->save();

        Session::set('_new-user', trans('messages.create_success', ['entity' => 'user']));

        return redirect('/admin/user');
    }

    /**
     * Display the edit user page.
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('backend.user.edit', compact('data'));
    }

    /**
     * Update the user information.
     *
     * @param UserUpdateRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $data = User::findOrFail($id);
        $data->fill($request->toArray())->save();
        $data->save();

        Session::set('_updateUser', trans('messages.update_success', ['entity' => 'User']));

        return redirect()->route('admin.user.edit', compact('data'));
    }

    /**
     * Display the user password privacy page.
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function privacy($id)
    {
        $data = User::findOrFail($id);
        return view('backend.user.privacy', compact('data'));
    }
}
