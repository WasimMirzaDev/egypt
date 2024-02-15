<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\ExchangeRate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminExchangeRateController extends Controller
{
    public function index()
    {
        $pageTitle  = "All Exchange Rate";
        $exchange_rates = ExchangeRate::all();
        $currencies = Currency::all();

        return view('admin.exchange-rates.index', compact('exchange_rates', 'pageTitle'));
    }

    /**
     * Show the form for creating a new exchange rate.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $gateways = Currency::all();
        $pageTitle  = "New Exchange Rate";
        return view('admin.exchange-rates.create', compact("pageTitle", "gateways"));
    }

    /**
     * Store a newly created exchange rate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'selectGateFrom' => 'required',
            'selectGateTo' => 'required',
            'rateFrom' => 'required|numeric',
            'rateTo' => 'required|numeric',
            'fixedCharge' => 'nullable|numeric',
            'percentCharge' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('fixedCharge')) {
                $notify[] = ['error', $errors->first('fixedCharge')];
            }

            if ($errors->has('percentCharge')) {
                $notify[] = ['error', $errors->first('percentCharge')];
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Store the exchange rate
        $exchangeRate = new ExchangeRate;
        $exchangeRate->gateway_from = $request->input('selectGateFrom');
        $exchangeRate->gateway_to = $request->input('selectGateTo');
        $exchangeRate->rate_from = $request->input('rateFrom');
        $exchangeRate->rate_to = $request->input('rateTo');
        $exchangeRate->gateway_from_cur_sym = $request->input('related_column');
        $exchangeRate->gateway_to_cur_sym = $request->input('related_column_gateway_to');
        $exchangeRate->fixed_charge = $request->input('fixedCharge') ?? 0;
        $exchangeRate->percent_charge = $request->input('percentCharge') ?? 0;
        $exchangeRate->save();


        $notify[] = ['success', 'Exhange Rate Created'];

        return redirect()->route('exchange-rates.index')
            ->withNotify($notify);
    }

    /**
     * Show the form for editing the specified exchange rate.
     *
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exchangeRate = ExchangeRate::find($id);

        if ($exchangeRate) {
            // ExchangeRate exists, proceed with the edit operation
            $gateways = Currency::all();
            $pageTitle = "Edit Exchange Rate";

            return view('admin.exchange-rates.edit', compact('exchangeRate', 'pageTitle', 'gateways'));
        } else {
            // ExchangeRate does not exist, handle the error
            $notify = ['error', 'Exchange Rate not found'];

            return redirect()->route('exchange-rates.index')->withNotify($notify);
        }
    }

    /**
     * Update the specified exchange rate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'selectGateFrom' => 'required',
            'selectGateTo' => 'required',
            'rateFrom' => 'required|numeric',
            'rateTo' => 'required|numeric',
            'fixedCharge' => 'nullable|numeric',
            'percentCharge' => 'nullable|numeric',
        ]);

        // Redirect back with validation errors if it fails
        if ($validator->fails()) {
            $notify = ['error', 'Exchange Rate not found'];

            return redirect()->route('exchange-rates.index')->withInput()->withNotify($notify);
        }

        // Find the exchange rate record
        $exchangeRate = ExchangeRate::findOrFail($id);

        // Update the exchange rate record with the new values
        $exchangeRate->gateway_from = $request->input('selectGateFrom');
        $exchangeRate->gateway_to = $request->input('selectGateTo');
        $exchangeRate->rate_from = $request->input('rateFrom');
        $exchangeRate->rate_to = $request->input('rateTo');
        $exchangeRate->fixed_charge = $request->input('fixedCharge');
        $exchangeRate->percent_charge = $request->input('percentCharge');
        $exchangeRate->save();

        // Redirect back with success messa
        $notify[] = ['success', 'Exchange Rate Updated'];

        return redirect()->route('exchange-rates.index')
            ->withNotify($notify);
    }

    /**
     * Remove the specified exchange rate from storage.
     *
     * @param  \App\ExchangeRate  $exchangeRate
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $exchange_rate = ExchangeRate::find($id);

        if (!$exchange_rate) {
            return redirect()->route('exchange-rates.index')->withNotify([
                ['error', 'Exchange rate not found.']
            ]);
        }

        if ($exchange_rate->delete()) {
            // Notify user about the review deletion


            return redirect()->route('exchange-rates.index')->withNotify([
                ['success', 'Exchange-rate deleted successfully.']
            ]);
        } else {
            return redirect()->route('exchange-rates.index')->withNotify([
                ['error', 'Failed to delete exchange_rate.']
        ]);
        }
    }
}
