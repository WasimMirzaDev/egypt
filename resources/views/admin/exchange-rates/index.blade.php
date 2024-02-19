@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Gateway From')</th>
                                    <th>@lang('Gateway To')</th>
                                    <th>@lang('Exchange Rate')</th>
                                    <!-- <th>@lang('Percent Charge')</th> -->
                                    <th>@lang('Fixed Charge')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exchange_rates as $exchange_rate)
                                    <tr>
                                        <td>
                                           {{ $exchange_rate->id }}
                                        </td>
                                        <td>
                                            {{ ($exchange_rate->gateway_from) }}
                                        </td>
                                        <td>
                                            {{ ($exchange_rate->gateway_to) }}
                                        </td>
                                        <td>{{ showAmount($exchange_rate->rate_from) * 1 }} {{ $exchange_rate->gateway_to_cur_sym }}  = {{ showAmount($exchange_rate->rate_to)* 1  }} {{ $exchange_rate->gateway_from_cur_sym }}  </td>
                                        <!-- <td>{{ showAmount($exchange_rate->percent_charge)* 1  }}</td> -->
                                        <td>{{ showAmount($exchange_rate->fixed_charge)  }}</td>

                                        <td>
                                           <button class="btn btn--primary btn-sm text-white">


                                             <a href="{{ route('exchange-rates.edit', $exchange_rate->id) }}" class="text-white">

                                                <i class="la la-pencil text-white"></i>@lang('Edit')
                                            </a>
                                           </button>
                                            <form method="POST" action="{{ route('exchange-rates.delete', $exchange_rate->id) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm text-white">
                                                    @lang('Delete')
                                                </button>
                                            </form>


                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- @if ($currencies->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($currencies) }}
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection
