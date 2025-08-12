<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        Currency::updateOrCreate(['code' => 'USD'], [
            'name' => 'US Dollar',
            'symbol' => '$',
            'active' => true
        ]);
        Currency::updateOrCreate(['code' => 'EUR'], [
            'name' => 'Euro',
            'symbol' => '€',
            'active' => true
        ]);
        Currency::updateOrCreate(['code' => 'KHR'], [
            'name' => 'Cambodian Riel',
            'symbol' => '៛',
            'active' => true
        ]);
    }
}
