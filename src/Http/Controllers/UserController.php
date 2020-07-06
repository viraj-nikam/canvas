<?php

namespace Canvas\Http\Controllers;

use Canvas\Helpers\URL;
use Canvas\Models\UserMeta;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(resolve(config('canvas.user', User::class))::latest()->paginate(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $meta = UserMeta::where('user_id', $id)->first();

        return response()->json([
            'avatar' => optional($meta)->avatar ?? URL::gravatar(request()->user()->email),
            'darkMode' => optional($meta)->dark_mode ?? false,
            'digest' => optional($meta)->digest ?? false,
            'summary' => optional($meta)->summary ?? null,
            'locale' => optional($meta)->locale ?? null,
            'username' => optional($meta)->username ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function update($id): JsonResponse
    {
        $meta = UserMeta::where('user_id', $id)->first() ?? new UserMeta();

        $data = [
            'avatar' => request('avatar', $meta->avatar),
            'dark_mode' => request('darkMode', $meta->dark_mode),
            'digest' => request('digest', $meta->digest),
            'locale' => request('locale', $meta->locale),
            'user_id' => request()->user()->id,
            'username' => request('username', $meta->username),
            'summary' => request('summary', $meta->summary),
        ];

        $rules = [
            'user_id' => 'required',
            'username' => [
                'nullable',
                'alpha_dash',
                Rule::unique('canvas_user_meta')->ignore(request()->user()->id, 'user_id'),
            ],
        ];

        $messages = [
            'required' => __('canvas::app.validation_required', [], $meta->locale),
            'unique' => __('canvas::app.validation_unique', [], $meta->locale),
        ];

        validator($data, $rules, $messages)->validate();

        $meta->fill($data);

        $meta->save();

        return response()->json($meta->refresh(), 201);
    }
}
