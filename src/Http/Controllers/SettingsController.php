<?php

namespace Canvas\Http\Controllers;

use Canvas\Http\Requests\SettingsRequest;
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
     * @param SettingsRequest $request
     * @return JsonResponse
     */
    public function update(SettingsRequest $request): JsonResponse
    {
        $metaData = UserMeta::forCurrentUser()->first() ?? new UserMeta();

        $data = $request->validated();

        $metaData->fill([
            'avatar' => $data['avatar'] ?? $metaData->avatar,
            'dark_mode' => $data['dark_mode'] ?? $metaData->dark_mode,
            'digest' => $data['digest'] ?? $metaData->digest,
            'locale' => $data['locale'] ?? $metaData->locale,
            'user_id' => request()->user()->id,
            'username' => $data['username'] ?? $metaData->username,
            'summary' => $data['summary'] ?? $metaData->summary,
        ]);

        $metaData->save();

        return response()->json($metaData->refresh(), 201);
    }
}
