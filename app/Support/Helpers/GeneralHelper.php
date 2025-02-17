<?php

namespace App\Support\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
        if (empty($string)) {
            return '';
        }

        return Str::of($string)
            // Add a space after each closing tag to prevent text from joining
            ->replaceMatches('/>(?!\s)/', '> ')
            // Strip HTML tags
            ->stripTags()
            // Decode HTML entities using PHP's htmlspecialchars_decode()
            ->pipe(fn($str) => htmlspecialchars_decode($str))
            // Replace multiple spaces with a single space
            ->replaceMatches('/\s+/', ' ')
            // Remove spaces before commas and dots
            ->replaceMatches('/\s+([,.])/', '$1')
            // Trim the result
            ->trim();
    }

    /**
     * Generate share text from string for meta-tags etc.
     */
    public static function generateShareTextFromStr($string)
    {
        $plainText = self::getPlainTextFromStr($string);
        $truncedText = self::truncateString($plainText, 140);

        return $truncedText;
    }

    /**
     * Validate Google reCAPTCHA v3 response for the request on form submit.
     */
    public static function validateRecaptchaForRequest($request)
    {
        // Make a POST request to Google's reCAPTCHA siteverify endpoint
        $recaptchaResponse = Http::timeout(120)->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('recaptcha_token'), // The reCAPTCHA token sent by the client
            'remoteip' => $request->ip(), // IP address of the user (optional but recommended)
        ]);

        $responseData = $recaptchaResponse->json();

        // Check if reCAPTCHA was successful and the score is greater than or equal to 0.5 (indicating a human)
        $isValid = isset($responseData['success']) && $responseData['success'] && $responseData['score'] >= 0.5;

        if (!$isValid) {
            throw ValidationException::withMessages([
                'email' => trans('auth.invalid_recaptcha'),
            ]);
        }
    }
}
