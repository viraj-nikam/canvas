<?php

namespace Canvas\Helpers;

use Illuminate\Support\Str;

class URL
{
    /**
     * Check if a given URL is valid.
     *
     * @param string|null $url
     * @return bool
     */
    public static function isValid(?string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }

    /**
     * Trim a given URL and return the base.
     *
     * @param string|null $url
     * @return mixed
     */
    public static function trim(?string $url)
    {
        return parse_url($url)['host'] ?? null;
    }

    /**
     * Generate a Gravatar for a given email.
     *
     * @param string $email
     * @param int $size
     * @param string $default
     * @param string $rating
     * @return string
     */
    public static function gravatar(string $email, int $size = 200, string $default = 'retro', string $rating = 'g'): string
    {
        $hash = md5(trim(Str::lower($email)));

        return "https://secure.gravatar.com/avatar/{$hash}?s={$size}&d={$default}&r={$rating}";
    }
}
