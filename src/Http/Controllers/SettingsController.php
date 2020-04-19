<?php

namespace Canvas\Http\Controllers;

use Canvas\Http\Requests\StoreSettings;
use Canvas\UserMeta;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $metaData = UserMeta::forCurrentUser()->first();
        $emailHash = md5(trim(Str::lower(request()->user()->email)));

        return response()->json([
            'avatar' => optional($metaData)->avatar ?? "https://secure.gravatar.com/avatar/{$emailHash}?s=500",
            'dark_mode' => optional($metaData)->dark_mode ?? false,
            'digest' => optional($metaData)->digest ?? false,
            'summary' => optional($metaData)->summary ?? null,
            'locale' => optional($metaData)->locale ?? null,
            'username' => optional($metaData)->username ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreSettings $request
     * @return JsonResponse
     */
    public function update(StoreSettings $request): JsonResponse
    {
        $metaData = UserMeta::forCurrentUser()->first() ?? new UserMeta();

        $metaData->fill([
            'avatar' => request('avatar', $metaData->avatar),
            'dark_mode' => request('dark_mode', $metaData->dark_mode),
            'digest' => request('digest', $metaData->digest),
            'locale' => request('locale', $metaData->locale),
            'user_id' => request()->user()->id,
            'username' => request('username', $metaData->username),
            'summary' => request('summary', $metaData->summary),
        ]);

        $metaData->save();

        return response()->json($metaData->refresh(), 201);
    }
}
