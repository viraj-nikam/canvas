<?php

namespace Canvas\Http\Controllers;

use Canvas\UserMeta;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    /**
     * Get user settings.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $metaData = UserMeta::where('user_id', request()->user()->id)->first();

        return response()->json([
            'username'   => $metaData->username ?? null,
            'summary'    => $metaData->summary ?? null,
            'avatar'     => $metaData->avatar ?? sprintf('https://secure.gravatar.com/avatar/%s?s=500', md5(trim(Str::lower(request()->user()->email)))),
            'digest'     => $metaData->digest ?? 0,
            'appearance' => $metaData->appearance ?? 0,
        ]);
    }

    /**
     * Save user settings.
     *
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        $metaData = UserMeta::where('user_id', request()->user()->id)->first() ?? new UserMeta();

        $metaData->fill([
            'user_id' => request()->user()->id,
            'username' => request('username'),
            'summary' => request('summary'),
            'avatar' => request('avatar'),
            'digest' => request('digest'),
            'appearance' => request('appearance'),
        ]);

        $metaData->save();

        return response()->json($metaData->refresh());
    }
}
