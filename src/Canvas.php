<?php

namespace Canvas;

class Canvas
{
    /**
     * Indicates if Canvas should utilize the dark mode.
     *
     * @var bool
     */
    public static $useDarkMode = false;

    /**
     * Build a global JavaScript object for the Vue app.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'lang'     => self::collectLanguageFiles(),
            'path'     => config('canvas.path'),
            'timezone' => config('app.timezone'),
            'unsplash' => config('canvas.unsplash.access_key'),
            'user'     => auth()->user()->only(['name', 'email']),
        ];
    }

    /**
     * Specifies that Canvas should apply the dark mode.
     *
     * @return static
     */
    public static function night()
    {
        static::$useDarkMode = true;

        return new static;
    }

    /**
     * Gather all the language files and rebuild them into into a single
     * consumable JSON object that can be used in the Vue components.
     *
     * @return string
     */
    private static function collectLanguageFiles(): string
    {
        $files = glob(sprintf('%s/resources/lang/%s/*.php', dirname(__DIR__, 1), config('app.locale')));
        $lines = collect();

        foreach ($files as $file) {
            $filename = basename($file, '.php');
            $lines->put($filename, require $file);
        }

        return json_encode($lines->toArray());
    }
}
