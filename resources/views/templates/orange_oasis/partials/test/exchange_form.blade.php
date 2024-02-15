<!DOCTYPE html>
<html>
<head>
    <!-- Other head elements -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>
<div class="custom-widget mb-0 pt-5 ps-5 pe-5">
    <div class="custom-widget mb-4">
    <h4 class="text-center" style="display: flex; align-items: center; justify-content: center;">
    <img src="https://i.imgur.com/6X9WgHX.gif" alt="Latest Exchanges" style="max-width: 5%; max-height: 5%; margin-top: -10px; margin-right: 0px;">
    <span style="font-weight: bold; font-size: 1.5em;">@lang('EXCHANGE')</span>
    <img src="https://i.imgur.com/6X9WgHX.gif" alt="Latest Exchanges" style="max-width: 5%; max-height: 5%; margin-top: -10px; margin-left: 0px;">
  </h4>
    <form action="{{ route('user.exchange.start') }}" method="POST" id="exchange-form">
      @csrf
      <input type="hidden" name="sending_currency" id="sending_currency_name">
      <input type="hidden" name="receiving_currency" id="receiving_currency_name">
      
      <div class="row">
        <div class="col-md-12">
          <div class="">
            <label for="" class="form-label">@lang('You Send')</label>
            <div class="input-group">
                <input type="text" name="sending_amount" value="" id="you_send" class="form-control" aria-label="Text input with dropdown button" placeholder="@lang('You Send')" onkeyup="youSend(event)">


                <button style="width: 200px" class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="send_gateway">Select Currency</button>
                <ul class="dropdown-menu dropdown-menu-end" name="sending_currency" style="max-height: 200px; overflow-y: auto; width: 200px;" >
                  @foreach ($sellCurrencies as $sellCurrency)

                  <li>
                    <a class="dropdown-item" href="#" onclick="selectSendGateway('{{ $sellCurrency->name }}', '{{ getImage(getFilePath('currency') . '/' . @$sellCurrency->image, getFileSize('currency')) }}', {{ $sellCurrency->id }})">
                      <img src="{{ getImage(getFilePath('currency') . '/' . @$sellCurrency->image, getFileSize('currency')) }}" class="rounded-circle" style="width: 30px; height: 30px;" alt="Image">
                      {{$sellCurrency->name}}
                    </a>
                  </li>
                  @endforeach
                </ul>
              </div>
          </div>
        </div>
        <div class="col-md-12 mb-2 d-flex justify-content-between justify-content-md-start justify-content-lg-between">
  
         
         
              <div style="order: 1"><small><b>@lang('Min'): <span class="text--primary" id="min-value"></span></b></small></div>
            
            
              <div style="order: 2"><span id="limitError" class="text--primary"></span></div>
       
          
              <div style="order: 3"><small><b>@lang('Max'): <span class="text--primary" id="max-value"></span></b></small></div>
           
  

          
          
       
       </div>
          
        <div class="col-md-12">
            <div class="">
              <label for="you_get" class="form-label">@lang('You Get')</label>
              <div class="input-group">
                <input type="text" name="reciving_amount" id="you_get" value="" class="form-control" aria-label="Text input with dropdown button" onkeyup="youGet(event)" placeholder="@lang('You Get')">
                <button style="width: 200px" class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="recive_gateway">Select Currency</button>
                <ul class="dropdown-menu dropdown-menu-end" style="max-height: 200px; overflow-y: auto; width: 200px;" onchange="youSend()">
                  @foreach ($buyCurrencies as $buyCurrency)
                  <li>
                    <a class="dropdown-item" href="#" onclick="selectReciveGateway('{{ $buyCurrency->name }}', '{{ getImage(getFilePath('currency') . '/' . @$buyCurrency->image, getFileSize('currency')) }}', '{{ $buyCurrency->id }}')">
                      <img src="{{ getImage(getFilePath('currency') . '/' . @$buyCurrency->image, getFileSize('currency')) }}" class="rounded-circle" style="width: 30px; height: 30px;" alt="Image">
                      {{$buyCurrency->name}}
                    </a>
                  </li>
                  @endforeach
                </ul>
              </div>
                
            </div>
        </div>
        <div class="col-md-12 mb-2 d-flex justify-content-between justify-content-md-start justify-content-lg-between">
            <div style="order: 1;">  <small> <b>@lang('Average Percent'): <span id="rate-percent" class="text--primary"></span> </b></small></div>
            <div style="order: 2;"><small> <b>@lang('Rate'): <span class="text--primary"> <span id="rate-from"></span> <span id="rate-from-cur"> </span> <span id="equal"></span> <span id="rate-to"></span> <span id="rate-to-cur"></span></b></small></div>
        </div>
          
        <div class="col-md-12 text-center">
          <button class="btn btn-primary" type="submit" onclick="submitForm()">
            <span class="me-2"><i class="las la-exchange-alt"></i></span>@lang('Exchange Now')
          </button>
        </div>
      </div>
    </form>
  </div>
  <script>
    var sendCurrencyName = '';
    var reciveCurrencyName = '';
    var sendCurrencyId='';
    var reciveCurrencyId='';
    var inputValue='';

// Get all the <a> tags inside the first dropdown menu
        
        function selectSendGateway(sendGateway, imageSrc, currencyId) {
        var sendGatewayButton = document.getElementById("send_gateway");
        sendGatewayButton.innerHTML = `
            <img src="${imageSrc}" class="rounded-circle" style="width: 30px; height: 30px;" alt="Image">
            ${sendGateway}
        `;
        sendGatewayButton.setAttribute("data-currency-id", currencyId);
        sendCurrencyName = sendGateway; // Set the sendCurrencyName variable
        document.getElementById('sending_currency_name').value = currencyId ;
        sendCurrencyId=currencyId

        // Perform AJAX request for limits
        $.ajax({
            url: '{{ route('user.exchange.limits') }}',
            type: 'post',
            data: {
            _token: '{{ csrf_token() }}',
            currency_id: currencyId
            },
            success: function(response) {
                if(response.success){
                    var min = Math.floor(response.data.min);
                    var max = Math.floor(response.data.max);

                    // Update the Min and Max values
                    $('#min-value').text(min);
                    $('#max-value').text(max);
                    $('#limitError').text("ㅤ");
                }
                }
            
        
        
        });
        var inputValue = document.getElementById("you_send").value;
        performKeywordCalculation(sendCurrencyName,reciveCurrencyName,reciveCurrencyId,sendCurrencyId,inputValue);
        

        }


        
        function selectReciveGateway(reciveGateway, imageSrc, currencyId) {
            var reciveGatewayButton = document.getElementById("recive_gateway");
            reciveGatewayButton.innerHTML = `
            <img src="${imageSrc}" class="rounded-circle" style="width: 30px; height: 30px;" alt="Image">
            ${reciveGateway}
            `;
            reciveGatewayButton.setAttribute("data-currency-id", currencyId);
            reciveCurrencyName = reciveGateway;
            document.getElementById('receiving_currency_name').value = currencyId ;
            reciveCurrencyId=currencyId;
            var inputValue = document.getElementById("you_send").value;


            performKeywordCalculation(sendCurrencyName,reciveCurrencyName,reciveCurrencyId,sendCurrencyId,inputValue);
        
        }
        
        
        function youSend(event){
            var inputValue = event.target.value;

        performKeywordCalculation(sendCurrencyName,reciveCurrencyName,reciveCurrencyId,sendCurrencyId,inputValue);
        
        }

        function performKeywordCalculation(sendCurrencyName,reciveCurrencyName,reciveCurrencyId,sendCurrencyId,inputValue){

            $.ajax({
                url: '{{ route('user.exchange.rates.you.send') }}',
                type: 'POST',
                data: {
                _token: '{{ csrf_token() }}',
                send_currency_id: sendCurrencyId,
                recive_currency_id: reciveCurrencyId,
                send_currency_name: sendCurrencyName,
                recive_currency_name: reciveCurrencyName,
                you_send: inputValue
                },
                
                success: function(response) {
                if(response.success){
                    var you_get =parseFloat(response.data.you_get).toFixed(2);
                var you_get_input =parseFloat(response.data.you_get_input).toFixed(2);
        var percent_charge = parseFloat(response.data.percent_charge).toFixed(2);
        var you_send = parseFloat(response.data.you_send).toFixed(2);
            var gateway_from_cur_sym=response.data.gateway_from_cur_sym;
            var gateway_to_cur_sym=response.data.gateway_to_cur_sym;
            console.log(you_get_input,you_get);
            $('#rate-percent').text(percent_charge);
            $('#rate-from').text(you_get);
                $('#rate-to').text(you_send);
                $('#you_get').val(you_get_input);
                $('#rate-to-cur').text(gateway_to_cur_sym);
                $('#rate-from-cur').text(gateway_from_cur_sym);
                $('#equal').text('=');
                $('#limitError').text("ㅤ");
                

                }else{
                    var error =response.message;
                    $('#limitError').text(error);
                }

                },
            

            });
        }
        function youGet(event){
            var getInputValue = event.target.value;
            inputValue=getInputValue;
            
        performYouGetCalculation(sendCurrencyName,reciveCurrencyId,sendCurrencyId,reciveCurrencyName,getInputValue);
       
        }
        function performYouGetCalculation(sendCurrencyName,sendCurrencyId,reciveCurrencyId,reciveCurrencyName,getInputValue){

        $.ajax({
            url: '{{ route('user.getInput.rates') }}',
            type: 'POST',
            data: {
            _token: '{{ csrf_token() }}',
            send_currency_id: sendCurrencyId,
                recive_currency_id: reciveCurrencyId,
            send_currency_name: sendCurrencyName,
            recive_currency_name: reciveCurrencyName,
            you_get: getInputValue
            },
            success: function(response) {

                if(response.success){
                    var you_get = parseFloat(response.data.you_get).toFixed(2);
                    var percent_charge =parseFloat(response.data.percent_charge).toFixed(2);
                    var you_send =parseFloat(response.data.you_send).toFixed(2);
                    var gateway_from_cur_sym=response.data.gateway_to_cur_sym;
            var gateway_to_cur_sym=response.data.gateway_from_cur_sym;
          
            $('#rate-percent').text(percent_charge);
            $('#rate-from').text(you_get);
                $('#rate-to').text(you_send);
                $('#you_send').val(you_send);
                
                $('#rate-from-cur').text(gateway_to_cur_sym);
                $('#rate-to-cur').text(gateway_from_cur_sym);
                $('#limitError').text("ㅤ");

                }
                else{
                    var error =response.message;
                    $('#limitError').text(error);
                }
                }
            
        });
        }
        function formSubmit(sendCurrencyName,sendCurrencyId,reciveCurrencyId,reciveCurrencyName,getInputValue){
        console.log(sendCurrencyName,sendCurrencyId,reciveCurrencyId,reciveCurrencyName,getInputValue);
        var receiving_amount = document.getElementById("you_get").value;
       
        var sending_amount = document.getElementById("you_send").value;
        var sending_amount_int = parseInt(sending_amount);
        alert(receiving_amount);
       
        }



</script>

  
  
@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
<script>
    $(document).ready(function() {
        // Change select2 structure
        $('.currency-picker').select2({
            templateResult: formatState
        });

        function formatState(state) {
            if (!state.id) return state.text;
            return $('<img class="ms-1" src="' + $(state.element).data('image') + '"/> <span class="ms-3">' +
                state.text + '</span>');
        }

        let sendId, sendMinAmount, sendMaxAmount, sendAmount, sendCurrency, sendCurrencyBuyRate;
        let receivedId, receivedAmount, receivedCurrency, receiveCurrencySellRate;

        @if (old('sending_currency'))
        sendAmount = "{{ old('sending_amount') }}";
        sendAmount = parseFloat(sendAmount);
        setTimeout(() => {
            $('#send').trigger('change');
        });
        @endif

        @if (old('receiving_currency'))
        setTimeout(() => {
            $('#receive').trigger('change');
        });
        @endif

        $('#exchange-form').on('change', '#send', function(e) {

            sendId = parseInt($(this).val());
            sendMinAmount = parseFloat($(this).find(':selected').data('min'));
            sendMaxAmount = parseFloat($(this).find(':selected').data('max'));
            sendCurrency = $(this).find(':selected').data('currency');
            sendCurrencyBuyRate = parseFloat($(this).find(':selected').data('buy'));

            validation();

            $('.limit-exchange').find('.text--base').text(`${sendMinAmount.toFixed(2)}- ${sendMaxAmount.toFixed(2)}`);
            $('.limit-exchange').find('.currency_name').text(sendCurrency);
            $('.rate--txt').removeClass('d-none');

            $("#sending_amount").siblings('.input-group-text').removeClass('d-none');
            $("#sending_amount").removeClass('rounded');
            $("#sending_amount").siblings('.input-group-text').text(sendCurrency);

            $(this).closest('.form-group').find('.select2-selection__rendered').html(`
                <img src="${$(this).find(':selected').data('image')}" class="currency-image"/> ${$(this).find(':selected').text()}`
            );

            calculationReceivedAmount();
        });

        $('#exchange-form').on('change', '#receive', function(e) {

            receivedId = parseInt($(this).val());
            receiveCurrencySellRate = parseFloat($(this).find(':selected').data('sell'));
            receivedCurrency = $(this).find(':selected').data('currency');

            let minAmount = parseFloat($(this).find(':selected').data('min'));
            let maxAmount = parseFloat($(this).find(':selected').data('max'));
            let reserveAmount = parseFloat($(this).find(':selected').data('reserve'));

            $('.limit-received-exchange').find('.text--base').text(`${minAmount.toFixed(2)}- ${maxAmount.toFixed(2)}`);
            $('.reserve-amount').find('.text--base').text(`${reserveAmount.toFixed(2)}`);
            $('.limit-received-exchange').find('.currency_name').text(receivedCurrency);
            $('.reserve-amount').find('.currency_name').text(receivedCurrency);
            $('.rate--txt-received').removeClass('d-none');

            validation();

            $("#receiving_amount").siblings('.input-group-text').removeClass('d-none');
            $("#receiving_amount").removeClass('rounded');
            $("#receiving_amount").siblings('.input-group-text').text(receivedCurrency);

            $(this).closest('.form-group').find('.select2-selection__rendered').html(`
                <img src="${$(this).find(':selected').data('image')}" class="currency-image"/> ${$(this).find(':selected').text()}`
            );

            calculationReceivedAmount();
        });

        $('#exchange-form').on('input', '#sending_amount', function(e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');
            sendAmount = parseFloat(this.value);

            validation();
            calculationReceivedAmount();
        });

        $('#exchange-form').on('input', '#receiving_amount', function(e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');
            receivedAmount = parseFloat(this.value);

            validation();
            calculationSendAmount();
        });

        const validation = () => {
            let error = true;

            if (sendId && receivedId && sendId == receivedId) {
                error = true;
                notify('error', 'Send & received currency can not be the same.');
            } else {
                error = false;
            }

            if (error) {
                $('#exchange-form').find("button[type=submit]").addClass('disabled');
                $('#exchange-form').find("button[type=submit]").attr('disabled', true);
            } else {
                $('#exchange-form').find("button[type=submit]").removeClass('disabled');
                $('#exchange-form').find("button[type=submit]").attr('disabled', false);
            }
        };

        const calculationReceivedAmount = () => {

            if (!sendId && !receivedId && !sendCurrencyBuyRate && !receiveCurrencySellRate) {
                return false;
            }
            let amountReceived = (sendCurrencyBuyRate / receiveCurrencySellRate) * sendAmount;
            $("#receiving_amount").val(amountReceived.toFixed(2));
        };

        const calculationSendAmount = () => {
            if (!sendId && !receivedId && !sendCurrencyBuyRate && !receiveCurrencySellRate) {
                return false;
            }
            let amountReceived = (receiveCurrencySellRate / sendCurrencyBuyRate) * receivedAmount;
            $("#sending_amount").val(amountReceived.toFixed(2));
        };
    });
</script>

@endpush

@push('style')
    <style>
        .select2-container .select2-selection--single {
            height: 46px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
        }

        .select2-container--default img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .select2-results__option--selectable {
            display: flex;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            top: 80%;
        }

        img.currency-image {
            width: 25px;
            height: 25px;
            margin-right: 8px;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid hsl(var(--border));
        }
    </style>
@endpush
