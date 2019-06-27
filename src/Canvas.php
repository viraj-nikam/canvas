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
     * Get the default JavaScript variables for Canvas.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path'     => config('canvas.path'),
            'lang'     => self::collectLanguageFiles(),
            'timezone' => config('app.timezone'),
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
