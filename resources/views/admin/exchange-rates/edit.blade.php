@extends('admin.layouts.app')
@section('panel')


<form method="POST" action="{{ route('exchange-rates.update', ['id' => $exchangeRate->id]) }}">
    @csrf
    @method('PUT')
    <div class="mt-5">
        <div class="row m-3">
            <div class="col-md-6">
                <label for="selectGateFrom">Gateway From</label><br>
                <select class="w-100 custom-select" name="selectGateFrom" id="selectGateFrom">
                    <option value="">Select One</option>
                    @foreach($gateways as $gateway)
                    <option value="{{ $gateway->name }}" {{ old('selectGateFrom', $exchangeRate->gateway_from) == $gateway->name ? 'selected' : '' }}>{{ $gateway->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="selectGateTo">Gateway To</label><br>
                <select class="w-100" name="selectGateTo" id="selectGateTo">
                    <option value="">Select One</option>
                    @foreach($gateways as $gateway)
                    <option value="{{ $gateway->name }}" {{ old('selectGateTo', $exchangeRate->gateway_to) == $gateway->name ? 'selected' : '' }}>{{ $gateway->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="mt-3" for="rateTo">Rate From</label><br>
                <input class="w-100 form-control" name="rateTo" id="rateTo" type="number" value="{{ old('rateTo', $exchangeRate->rate_to*1) }}"  step="any">
            </div>
            <div class="col-md-6">
                <label class="mt-3" for="rateFrom">Rate To</label><br>
                <input class="w-100 form-control" name="rateFrom" id="rateFrom" type="number" value="{{ old('rateFrom', $exchangeRate->rate_from*1) }}"  step="any">
            </div>

            <div class="col-md-6">


                <label class="mt-3" for="fixedCharge">Exchange Fee</label><br>
                <input class="w-100 form-control" name="fixedCharge" id="fixedCharge" type="number" step="any" value="{{ old('fixedCharge', $exchangeRate->fixed_charge) }}">
            </div>
            <div class="col-md-6" style="display:none;">
                <label class="mt-3" for="percentCharge">Percent Charge</label><br>
                <input class="w-100 form-control" name="percentCharge" id="percentCharge" type="number" value="{{ old('percentCharge', $exchangeRate->percent_charge*1) }}">
            </div>
            <div>
                <button  class="btn btn--primary text-white mt-3 w-100">Submit</button>
            </div>
        </div>
    </div>
</form>

@endsection
@push('breadcrumb-plugins')
<div class="d-flex justify-content-end">
    <a class="btn btn-sm btn--primary box--shadow1 text--small" href="{{ route('exchange-rates.index') }}"><i class="la la-list"></i> Manage Exchange Rates </a>
  </div>
    {{-- <a class="btn btn-outline--primary" href="{{ route('admin.$exchange_rate.create') }}" /><i class="las la-plus"></i>@lang('Add New')</a> --}}
@endpush
