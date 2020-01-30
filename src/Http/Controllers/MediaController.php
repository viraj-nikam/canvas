<?php

namespace Canvas\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Stores a given file and returns the path.
     *
     * @return mixed
     */
    public function store()
    {
        // TODO: refactor this on the client side to avoid chaining requests
        $file = request()->file('editorImagePond') ?? request()->file('featuredImagePond') ?? request()->file('profileImagePond');
        $path = $file->storePublicly($this->baseStoragePath(), [
            'disk' => config('canvas.storage_disk'),
        ]);

        return Storage::disk(config('canvas.storage_disk'))->url($path);
    }

    /**
     * Deletes a given file from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $file = pathinfo(request()->getContent());
        $storagePath = $this->baseStoragePath();
        $path = "{$storagePath}/{$file['basename']}";

        $fileDeleted = Storage::disk(config('canvas.storage_disk'))->delete($path);

        if ($fileDeleted) {
            return response()->json([], 204);
        }
    }

    /**
     * Return the storage path url.
     *
     * @return string
     */
    private function baseStoragePath(): string
    {
        return sprintf('%s/%s', config('canvas.storage_path'), 'images');
    }
}
