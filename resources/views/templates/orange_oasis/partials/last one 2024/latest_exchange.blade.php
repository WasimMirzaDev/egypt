@php
    $latestExchange = App\Models\Exchange::desc()
        ->with('sendCurrency', 'receivedCurrency', 'user')
        ->approved()
        ->limit(12)
        ->get();
@endphp
<div class="custom-widget" style="text-align: center; background-image: url('background-image.jpg');">
    <h4 class="title mb-1" style="display: flex; align-items: center; justify-content: center;">
        <img src="https://i.imgur.com/6X9WgHX.gif" alt="Latest Exchanges" style="max-width: 2em; max-height: 2em; margin-top: -10px; margin-right: 5px;">
        <span style="font-weight: bold; font-size: 1.5em; white-space: nowrap;">@lang('Latest Exchanges')</span>
        <img src="https://i.imgur.com/6X9WgHX.gif" alt="Latest Exchanges" style="max-width: 2em; max-height: 2em; margin-top: -10px; margin-left: 5px;">
    </h4>
</div>

    <table class="table table--responsive--lg mb-0 table--md fs--16px">
        <thead>
            <tr>
                <th>@lang('User')</th>
                <th>@lang('Sent')</th>
                <th>@lang('Received')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Date')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($latestExchange as $exchange)
                <tr>
                    <td> {{ @$exchange->user->fullname }}</td>

                    <td>
                        <div class="table-content text-start">
                            <div class="thumb ms-10">
                                <img src="{{ getImage(getFilePath('currency') . '/' . @$exchange->sendCurrency->image, getFileSize('currency')) }}" class="thumb">
                            </div>
                            <span class="table-content text-center">{{ __(@$exchange->sendCurrency->name) }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="table-content text-center">
                            <div class="thumb">
                                <img src="{{ getImage(getFilePath('currency') . '/' . @$exchange->receivedCurrency->image, getFileSize('currency')) }}">
                            </div>
                            <span class="mt-2">{{ __(@$exchange->receivedCurrency->name) }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="amount">
                            {{ showAmount($exchange->sending_amount) }} {{ __(@$exchange->sendCurrency->cur_sym) }}
                            <i class="las la-arrow-right text--base"></i>
                            {{ showAmount($exchange->receiving_amount) }} {{ __(@$exchange->receivedCurrency->cur_sym) }}
                        </div>
                    </td>
                    <td>
                        <div>
                            <span class="d-block">{{ showDateTime(@$exchange->created_at) }}</span>
                            <span class="text--base">{{ diffForHumans(@$exchange->created_at) }}</span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
