<?php

namespace Canvas\Http\Controllers;

use Canvas\UserMeta;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        if (request()->user()->id == $id) {
            $metaData = UserMeta::where('user_id', $id)->first();
            $emailHash = md5(trim(Str::lower(request()->user()->email)));

            return response()->json([
                'avatar' => optional($metaData)->avatar ?? "https://secure.gravatar.com/avatar/{$emailHash}?s=500",
                'darkMode' => optional($metaData)->dark_mode ?? false,
                'digest' => optional($metaData)->digest ?? false,
                'summary' => optional($metaData)->summary ?? null,
                'locale' => optional($metaData)->locale ?? null,
                'username' => optional($metaData)->username ?? null,
            ]);
        } else {
            return response()->json(null, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function update($id): JsonResponse
    {
        if (request()->user()->id == $id) {
            $metaData = UserMeta::where('user_id', $id)->first() ?? new UserMeta();

            $data = [
                'avatar' => request('avatar', $metaData->avatar),
                'dark_mode' => request('darkMode', $metaData->dark_mode),
                'digest' => request('digest', $metaData->digest),
                'locale' => request('locale', $metaData->locale),
                'user_id' => request()->user()->id,
                'username' => request('username', $metaData->username),
                'summary' => request('summary', $metaData->summary),
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
                'required' => __('canvas::app.validation_required', [], $metaData->locale),
                'unique' => __('canvas::app.validation_unique', [], $metaData->locale),
            ];

            validator($data, $rules, $messages)->validate();

            $metaData->fill($data);

            $metaData->save();

            return response()->json($metaData->refresh(), 201);
        } else {
            return response()->json(null, 404);
        }
    }
}
