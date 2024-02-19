@extends('admin.layouts.app')
@section('panel')



<form method="POST" action="{{ route('exchange-rates.store') }}">
    @csrf
   <div class="mt-5">
    <div class="row m-3">
        <div class="col-md-6">
            <label for="gatewayFrom">Gateway From</label><br>
            <select class="w-100 custom-select" name="selectGateFrom" id="gatewayFrom" onchange="updateHiddenInput()">
              <option value="">Select One</option>
              @foreach($gateways as $gateway)
                <option value="{{ $gateway->name }}" data-related="{{ $gateway->cur_sym }}">{{ $gateway->name }}-{{ $gateway->cur_sym }}</option>
              @endforeach
            </select>
            <input style="display: none" type="text" name="related_column" id="relatedColumn" value="">
     </div>
     <div class="col-md-6">
        <label for="gatewayTo">Gateway To</label><br>
        <select class="w-100" name="selectGateTo" id="gatewayTo" onchange="updateHiddenGatewayToInput()">
          <option value="">Select One</option>
          @foreach($gateways as $gateway)
            <option value="{{ $gateway->name }}" data-related="{{ $gateway->cur_sym }}">{{ $gateway->name }}-{{ $gateway->cur_sym }}</option>
          @endforeach
        </select>
        <input style="display: none" type="text" name="related_column_gateway_to" id="related_column_gateway_to" value="">
      </div>
      <div class="col-md-6">
        <label class="mt-3" for="rate-to">Rate From</label><br>
       <input class="w-100 form-control" name="rateTo" id="rate-to" type="number" step="any">
    </div>

        <div class="col-md-6">
            <label class="mt-3" for="rate-from">Rate To</label><br>
           <input class="w-100 form-control" name="rateFrom" id="rate-from" type="number" step="any">
        </div>

        <div class="col-md-6">
            <label class="mt-3" for="rate-from">Fixed Charge</label><br>
           <input class="w-100 form-control" name="fixedCharge" id="rate-from" type="number" >
        </div>
        <div class="col-md-6" style="display:none;">
            <label class="mt-3" for="rate-to">Percent Charge</label><br>
           <input value="0" class="w-100 form-control" name="percentCharge" id="rate-to" type="number" >
        </div>
        <div>
            <button class="btn btn--primary text-white mt-3 w-100">Submit</button>
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
<script>
    function updateHiddenInput() {
      var selectElement = document.getElementById("gatewayFrom");
      var selectedOption = selectElement.options[selectElement.selectedIndex];
      var relatedValue = selectedOption.getAttribute("data-related");
      document.getElementById("relatedColumn").value = relatedValue;
    }
    function updateHiddenGatewayToInput() {
    var selectElement = document.getElementById("gatewayTo");
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var relatedValue = selectedOption.getAttribute("data-related");
    document.getElementById("related_column_gateway_to").value = relatedValue;
  }
  </script>
