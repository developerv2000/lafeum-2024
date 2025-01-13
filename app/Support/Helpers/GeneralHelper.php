<?php

namespace App\Support\Helpers;

use Illuminate\Support\Str;

class GeneralHelper
{
    /**
     * Removes a key from an array if it exists.
     *
     * @param array $array
     * @param string $key
     * @return void
     */
    public static function removeArrayKey(array &$array, string $key): void
    {
        if (array_key_exists($key, $array)) {
            unset($array[$key]);
        }
    }

    /**
     * Get an array of boolean options represented by StdClass objects.
     *
     * Mainly used by radio groups.
     *
     * @return array
     */
    public static function getBooleanOptionsArray()
    {
        return [
            (object) ['caption' => trans('Да'), 'value' => 1],
            (object) ['caption' => trans('Нет'), 'value' => 0],
        ];
    }

    /**
     * Truncate a string to the specified length and append '...' if necessary.
     *
     * @param string $value The string to be truncated.
     * @param int $length The desired length of the truncated string.
     * @return string The truncated string with '...' appended if it exceeds the length.
     */
    public static function truncateString(string $value, int $length): string
    {
        if (mb_strlen($value) <= $length) {
            return $value;
        }

        return mb_substr($value, 0, $length) . '...';
    }

    /**
     * Get plain text from string without HTML tags.
     */
    public static function getPlainTextFromStr($string)
    {
        // Add a space after each closing tag to prevent text from joining
        $withSpaces = preg_replace('/>(?!\s)/', '> ', $string);

        // Strip HTML tags
        $plainText = strip_tags($withSpaces);

        // Normalize by decoding HTML entities
        $decodedText = htmlspecialchars_decode($plainText);

        // Replace multiple spaces with a single space
        $normalizedText = preg_replace('/\s+/', ' ', $decodedText);

        // Remove spaces before commas
        $noSpacesBeforeCommas = preg_replace('/\s+,/', ',', $normalizedText);

        // Trim the result
        return Str::of($noSpacesBeforeCommas)->trim();
    }

    /**
     * Generate share text from string for meta-tages etc.
     */
    public static function generateShareTextFromStr($string)
    {
        $plainText = self::getPlainTextFromStr($string);
        $truncedText = self::truncateString($plainText, 140);

        return $truncedText;
    }
}
