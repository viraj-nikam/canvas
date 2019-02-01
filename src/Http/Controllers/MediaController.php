<?php

namespace Canvas\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Process an image upload.
     *
     * @return string
     */
    public function store(): string
    {
        $path = request()->image->store(config('canvas.storage_path'), [
            'disk'       => config('canvas.storage_disk'),
            'visibility' => 'public',
        ]);

        return Storage::disk(config('canvas.storage_disk'))->url($path);
    }
}
