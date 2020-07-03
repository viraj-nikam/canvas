<?php

namespace Canvas\Http\Controllers;

use Canvas\Helpers\URL;
use Canvas\Models\UserMeta;
use Illuminate\Routing\Controller;

class ViewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $metaData = UserMeta::forUser(request()->user())->first();

        return view('canvas::layout')->with([
            'config' => [
                'languageCodes' => $this->getAvailableLanguageCodes(),
                'maxUpload' => config('canvas.upload_filesize'),
                'path' => config('canvas.path'),
                'timezone' => config('app.timezone'),
                'translations' => $this->getAvailableTranslations(optional($metaData)->locale),
                'unsplash' => config('canvas.unsplash.access_key'),
                'user' => $this->getUserData(),
                'version' => $this->getInstalledVersion(),
            ],
        ]);
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
            $translations->push($locale);
        }

        return $translations->toArray();
    }

    /**
     * Return an encoded string of app translations.
     *
     * @param $locale
     * @return string
     */
    private function getAvailableTranslations($locale): string
    {
        return collect(['app' => trans('canvas::app', [], $locale)])->toJson();
    }

    /**
     * Return an array of user data.
     *
     * @return array
     */
    private function getUserData(): array
    {
        $metaData = UserMeta::forUser(request()->user())->first();

        return [
            'id' => request()->user()->id,
            'name' => request()->user()->name,
            'email' => request()->user()->email,
            'avatar' => optional($metaData)->avatar ?? URL::gravatar(request()->user()->email),
            'darkMode' => optional($metaData)->dark_mode,
            'locale' => optional($metaData)->locale ?? config('app.locale'),
            'username' => optional($metaData)->username,
            'summary' => optional($metaData)->summary,
            'digest' => optional($metaData)->digest,
        ];
    }

    /**
     * Return the installed version.
     *
     * @return string
     */
    private function getInstalledVersion(): string
    {
        $dependencies = json_decode(file_get_contents(base_path('composer.lock')), true)['packages'];

        return collect($dependencies)->firstWhere('name', 'cnvs/canvas')['version'];
    }
}
