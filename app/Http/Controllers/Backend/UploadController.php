<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
