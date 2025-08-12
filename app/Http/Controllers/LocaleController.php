<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function switch($locale)
    {
        $availableLocales = ['en', 'km'];
        if (in_array($locale, $availableLocales)) {
            session(['lang' => $locale]);
        }
        return redirect()->back();
    }
}
