<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayPalController extends Controller
{
    public function capture(Request $request)
    {
        $orderID = $request->input('orderID');
        $accessToken = $this->getAccessToken();

        // Capture the order via PayPal API
        $response = Http::withToken($accessToken)
            ->post("https://api-m.sandbox.paypal.com/v2/checkout/orders/{$orderID}/capture");

        if ($response->successful()) {
            // Mark order as paid in your DB, etc.
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => $response->body()], 400);
    }

    private function getAccessToken()
    {
        $clientId = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');

        $response = Http::withBasicAuth($clientId, $secret)
            ->asForm()
            ->post('https://api-m.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials',
            ]);

        return $response->json()['access_token'];
    }
}
