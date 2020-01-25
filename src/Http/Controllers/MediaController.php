<?php

namespace Canvas\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Store a file upload and return the path.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $path = request()->file('upload')->store(sprintf('%s/%s', config('canvas.storage_path'), 'images'), [
            'disk'       => config('canvas.storage_disk'),
            'visibility' => 'public',
        ]);

        return response()->json(Storage::disk(config('canvas.storage_disk'))->url($path), 200);
    }

    /**
     * Delete a file from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        // todo: find a way to parse the request payload into a real path, then the DELETE endpoint will work properly
        Storage::disk(config('canvas.storage_disk'))->delete(request()->getContent());

        return response()->json([], 204);
    }
}
