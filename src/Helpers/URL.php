<?php

namespace Canvas\Helpers;

class URL
{
    /**
     * Check if a given URL is valid.
     *
     * @param string $url
     * @return bool
     */
    public static function isValid(?string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }

    /**
     * Trim a given URL.
     *
     * @param string $url
     * @return string
     */
    public static function trim(string $url)
    {
        return parse_url($url)['host'];
    }
}
