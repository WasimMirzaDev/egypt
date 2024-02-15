<?xml version="1.0" encoding="UTF-8"?>
<rates>
    @foreach ($rates as $rate)
        <rate>
            <send>{{ $rate['send'] }}</send>
            <receive>{{ $rate['receive'] }}</receive>
            <currency_from>{{ $rate['currency_from'] }}</currency_from>
            <currency_to>{{ $rate['currency_to'] }}</currency_to>
            <rate_from>{{ $rate['rate_from'] }}</rate_from>
            <rate_to>{{ $rate['rate_to'] }}</rate_to>
        </rate>
    @endforeach
</rates>