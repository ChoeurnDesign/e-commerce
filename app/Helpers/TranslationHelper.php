<?php

use Stichoza\GoogleTranslate\GoogleTranslate;

if (!function_exists('auto_translate')) {
    function auto_translate($text, $lang = null) {
        // Get language from session or default to English
        $lang = $lang ?: session('lang', 'en');

        // Don't translate if language is English (or your main language)
        if ($lang === 'en') {
            return $text;
        }

        // Optionally, cache translations to reduce API calls
        $cacheKey = 'translation_' . md5($text . $lang);
        return cache()->rememberForever($cacheKey, function () use ($text, $lang) {
            try {
                return GoogleTranslate::trans($text, $lang);
            } catch (\Exception $e) {
                // Fallback to original text if translation fails
                return $text;
            }
        });
    }
}
