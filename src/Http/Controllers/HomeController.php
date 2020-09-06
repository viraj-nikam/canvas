<?php

namespace Canvas\Http\Controllers;

use Canvas\Canvas;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        return view('canvas::layout')->with([
            'config' => [
                'languageCodes' => Canvas::availableLanguageCodes(),
                'maxUpload' => config('canvas.upload_filesize'),
                'path' => config('canvas.path'),
                'roles' => Canvas::availableRoles(),
                'timezone' => config('app.timezone'),
                'translations' => Canvas::availableTranslations($request->user()->locale),
                'unsplash' => config('canvas.unsplash.access_key'),
                'user' => $request->user(),
                'version' => Canvas::installedVersion(),
            ],
        ]);
    }
}
