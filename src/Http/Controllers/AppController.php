<?php

namespace Canvas\Http\Controllers;

use Canvas\UserMeta;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class AppController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return array
     */
    public function __invoke(): array
    {
        $metaData = UserMeta::forUser(request()->user())->first();

        return [
            'locale' => [
                'codes' => $this->getAvailableLanguageCodes(),
                'current' => optional($metaData)->locale ?? config('app.locale'),
                'translations' => collect(['app' => trans('canvas::app', [], optional($metaData)->locale)])->toJson(),
            ],
            'maxUpload' => config('canvas.upload_filesize'),
            'path' => config('canvas.path'),
            'timezone' => config('app.timezone'),
            'unsplash' => config('canvas.unsplash.access_key'),
        ];
    }

    /**
     * Return a list of available language codes.
     *
     * @return array
     */
    private function getAvailableLanguageCodes(): array
    {
        $locales = preg_grep('/^([^.])/', scandir(dirname(__DIR__, 3).'/resources/lang'));
        $translations = collect();

        foreach ($locales as $locale) {
            $translations->put($locale, Str::upper($locale));
        }

        return $translations->toArray();
    }
}
