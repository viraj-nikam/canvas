<?php

namespace Canvas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LocaleController extends Controller
{
    /**
     * Return the app translations for a given locale code.
     *
     * @param Request $request
     * @param string $code
     * @return string
     */
    public function __invoke(Request $request, string $code): string
    {
        return collect(['app' => trans('canvas::app', [], $code)])->toJson();
    }
}
