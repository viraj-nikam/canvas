<?php

namespace Canvas\Http\Controllers;

use Canvas\Models\UserMeta;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json(resolve(config('canvas.user', User::class))->latest()->paginate(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse
    {
        return response()->json([
            'user' => resolve(config('canvas.user', User::class))->find($id),
            'meta' => UserMeta::firstWhere('user_id', $id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $meta = UserMeta::firstWhere('user_id', $id) ?? new UserMeta();

        $data = [
            'avatar' => $request->input('avatar', $meta->avatar),
            'dark_mode' => $request->input('darkMode', $meta->dark_mode),
            'digest' => $request->input('digest', $meta->digest),
            'locale' => $request->input('locale', $meta->locale),
            'user_id' => $request->user()->id,
            'username' => $request->input('username', $meta->username),
            'summary' => $request->input('summary', $meta->summary),
        ];

        $rules = [
            'user_id' => 'required',
            'username' => [
                'nullable',
                'alpha_dash',
                Rule::unique('canvas_user_meta')->ignore($request->user()->id, 'user_id'),
            ],
        ];

        $messages = [
            'required' => trans('canvas::app.validation_required', [], $meta->locale),
            'unique' => trans('canvas::app.validation_unique', [], $meta->locale),
        ];

        validator($data, $rules, $messages)->validate();

        $meta->fill($data);

        $meta->save();

        return response()->json([
            'user' => $meta->user,
            'meta' => $meta->refresh(),
        ], 201);
    }
}
