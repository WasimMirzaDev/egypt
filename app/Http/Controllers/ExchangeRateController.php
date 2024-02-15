<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $exchangeRate = $this->getExchangeRate(); // Get the exchange rate from a source (e.g., database)

        return view('exchange-rate', compact('exchangeRate'));
    }

    private function getExchangeRate()
    {
        // Fetch the exchange rate from a source (e.g., database)
        // You can replace this with your own logic to retrieve the exchange rate
        // For example, you can store the exchange rate in a settings table or fetch it from an API

        // For now, let's assume a static exchange rate
        return 15.5; // You can replace this with your own exchange rate
    }
}
