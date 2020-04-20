<?php

namespace Canvas\Http\Controllers;

use Illuminate\Routing\Controller;

class LocaleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $code
     * @return string
     */
    public function __invoke(string $code)
    {
        return collect(['app' => trans('canvas::app', [], $code)])->toJson();
    }
}
