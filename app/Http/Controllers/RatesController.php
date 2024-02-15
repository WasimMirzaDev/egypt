<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $settings = DB::table('bit_settings')->orderBy('id', 'desc')->first();
    $gateways = DB::table('bit_gateways')->orderBy('id')->get();
    $rates = [];

    foreach ($gateways as $send) {
        foreach ($gateways as $receive) {
            $currency_from = gatewayinfo($send->id, 'currency');
            $currency_to = gatewayinfo($receive->id, 'currency');
            $fee = gatewayinfo($receive->id, 'fee');

            if ($currency_from === $currency_to) {
                $fee = str_ireplace('-', '', $fee);
                $calculate1 = (1 * $fee) / 100;
                $calculate2 = 1 - $calculate1;
                $rate_from = 1;
                $rate_to = $calculate2;
            } elseif ($currency_to === 'BTC') {
                if (checkCryptoExchange($send->name, $receive->name)) {
                    $rate = DB::table('bit_rates')->where([
                        'gateway_from' => $send->id,
                        'gateway_to' => $receive->id,
                    ])->first();

                    if ($rate) {
                        $rate_from = $rate->rate_from;
                        $rate_to = $rate->rate_to;
                    } else {
                        $rate_from = '-';
                        $rate_to = '-';
                    }
                } else {
                    $url = "https://www.changer.com/api/v2/rates/bitcoin_BTC/payeer_USD";
                    $result = file_get_contents($url);
                    $json = json_decode($result, true);
                    $price = $json['rate'];
                    $price = currencyConvertor($price, 'USD', $currency_from);
                    $calculate1 = ($price * $fee) / 100;
                    $calculate2 = $price - $calculate1;
                    $rate_from = $calculate2;
                    $rate_to = 1 / $calculate2;
                }
            } else {
                $rate = DB::table('bit_rates')->where([
                    'gateway_from' => $send->id,
                    'gateway_to' => $receive->id,
                ])->first();

                if ($rate) {
                    $rate_from = $rate->rate_from;
                    $rate_to = $rate->rate_to;
                } else {
                    $rate_from = '-';
                    $rate_to = '-';
                }
            }

            $rates[] = [
                'send' => $send->name,
                'receive' => $receive->name,
                'currency_from' => $currency_from,
                'currency_to' => $currency_to,
                'rate_from' => $rate_from,
                'rate_to' => $rate_to,
            ];
        }
    }

    return response()->view('rates', compact('rates'))->header('Content-Type', 'text/xml');   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}