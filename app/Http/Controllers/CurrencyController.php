<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function switch($currency)
    {
        $available = config('currencies');
        if (isset($available[$currency])) {
            session(['currency' => $currency]);
        }
        return back();
    }
}
