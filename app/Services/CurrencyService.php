<?php

namespace App\Services;

class CurrencyService
{
    protected $exchangeRates = [
        'USD' => 1.0,
        'EUR' => 0.85,
        'CNY' => 7.2,
        'GBP' => 0.76,
    ];

    protected $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'CNY' => '¥',
        'GBP' => '£',
    ];

    /**
     * Convert price from USD to target currency.
     *
     * @param float|int $price
     * @param string $toCurrency
     * @return float
     */
    public function convert($price, $toCurrency = 'USD')
    {
        if (!isset($this->exchangeRates[$toCurrency])) {
            return $price;
        }

        return $price * $this->exchangeRates[$toCurrency];
    }

    /**
     * Format price with currency symbol.
     *
     * @param float|int $price
     * @param string $currency
     * @param int $decimals
     * @return string
     */
    public function format($price, $currency = 'USD', $decimals = 2)
    {
        $convertedPrice = $this->convert($price, $currency);
        $symbol = $this->getSymbol($currency);

        return $symbol . number_format($convertedPrice, $decimals);
    }

    /**
     * Get available currencies.
     *
     * @return array
     */
    public function getAvailableCurrencies()
    {
        return [
            'USD' => 'US Dollar',
            'EUR' => 'Euro',
            'CNY' => 'Chinese Yuan',
            'GBP' => 'Pound Sterling',
        ];
    }

    /**
     * Get currency symbol.
     *
     * @param string $currency
     * @return string
     */
    public function getSymbol($currency)
    {
        return $this->currencySymbols[$currency] ?? '$';
    }

    /**
     * Get all currency symbols.
     *
     * @return array
     */
    public function getAllSymbols()
    {
        return $this->currencySymbols;
    }
}
