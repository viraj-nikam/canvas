<?php

namespace App\Http\Controllers\Backend;

use Session;
use Illuminate\Http\Request;
use App\Services\UploadsManager;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;

class UploadController extends Controller
{

    /**
     * Show page of files / subfolders.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.upload.index');
    }
}
