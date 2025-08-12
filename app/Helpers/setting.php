<?php

if (!function_exists('setting')) {
    /**
     * Get or set application settings.
     *
     * Usage:
     *  setting('key', 'default') - get a setting
     *  setting(['key' => 'value']) - set one or more settings
     *
     * @param string|array $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        // Example using the Setting model (you must create this or use a package)
        // GET
        if (is_string($key)) {
            $setting = \App\Models\Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        }

        // SET (array of key => value)
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                \App\Models\Setting::updateOrCreate(
                    ['key' => $k],
                    ['value' => $v]
                );
            }
            return true;
        }

        return $default;
    }
}
