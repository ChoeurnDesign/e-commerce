<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function format($amount, $currencyCode = null)
    {
        // Always treat $amount as USD (base currency)
        // Get user currency from session, or fallback to 'usd'
        $currencyCode = $currencyCode
            ?? session('currency')
            ?? 'usd';

        $currencies = config('currencies');
        $rate = $currencies[$currencyCode]['rate'] ?? 1;
        $symbol = $currencies[$currencyCode]['symbol'] ?? '$';

        $converted = $amount * $rate;

        if ($currencyCode === 'khr') {
            $converted = number_format(round($converted, -2), 0);
        } else {
            $converted = number_format($converted, 2);
        }

        return "{$symbol}{$converted}";
    }
}
