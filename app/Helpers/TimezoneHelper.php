<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimezoneHelper
{
    /**
     * Get user's timezone
     */
    public static function getUserTimezone()
    {
        if (Auth::check()) {
            return Auth::user()->timezone ?? session('timezone', 'UTC');
        }
        
        return session('timezone', 'UTC');
    }

    /**
     * Convert UTC time to user's timezone
     */
    public static function convertToUserTimezone($utcTime, $format = 'H:i')
    {
        if (!$utcTime) return '';
        
        return Carbon::parse($utcTime)
            ->setTimezone(self::getUserTimezone())
            ->format($format);
    }

    /**
     * Get current time in user's timezone
     */
    public static function getCurrentTime($format = 'H:i')
    {
        return Carbon::now(self::getUserTimezone())->format($format);
    }

    /**
     * Get all available timezones grouped by region
     */
    public static function getTimezonesByRegion()
    {
        $timezones = [];
        
        foreach (timezone_identifiers_list() as $timezone) {
            $parts = explode('/', $timezone);
            $region = $parts[0];
            $city = isset($parts[1]) ? str_replace('_', ' ', $parts[1]) : $timezone;
            
            $timezones[$region][$timezone] = $city;
        }
        
        return $timezones;
    }
}