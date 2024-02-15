<div class="custom-widget mb-0">
    <h4 class="text-center" style="display: flex; align-items: center; justify-content: center;">
    <img src="https://i.imgur.com/6X9WgHX.gif" alt="Latest Exchanges" style="max-width: 5%; max-height: 5%; margin-top: -10px; margin-right: 0px;">
    <span style="font-weight: bold; font-size: 1.5em;">@lang('Track Your Exchange')</span>
    <img src="https://i.imgur.com/6X9WgHX.gif" alt="Latest Exchanges" style="max-width: 5%; max-height: 5%; margin-top: -10px; margin-left: 0px;">
  </h4>
  
    <form id="tracking-form" action="{{ route('exchange.tracking') }}" method="GET">
        @csrf
        <div class=" form-group mb-3">
            <input type="text" placeholder="@lang('Your exchange ID')" name="exchange_id" class="form-control form--control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn--base btn w-100">@lang('Track Now')</button>
        </div>
    </form>
</div>

<div class="modal trackModal" tabindex="-1" id="trackModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-center"> @lang('Exchange Information')</h4>
                <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </span>
            </div>
            <div id="exchange-information"></div>
        </div>
    </div>
</div>

<div class="adz-modal d-none" id="custom-loader">
    <div class="adz-modal__card">
        <span class="adz-modal__text">@lang('Loading...')</span>
        <div class="adz-progressbar">
            <div class="adz-progressbar__bg"></div>
            <div class="adz-progressbar__buffer"></div>
            <div class="adz-progressbar__line">
                <div class="adz-progressbar__indeterminate long"></div>
                <div class="adz-progressbar__indeterminate short"></div>
            </div>
        </div>
    </div>
</div>

@push('style')
    <style>
        .adz-modal__card {
            background: #<?php echo $general->base_color; ?> !important;
        }

        .trackModal .modal-header {
            border-bottom: 0px;
        }
    </style>
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            $('#tracking-form').on('submit', function(e) {
                e.preventDefault();
                let exchangeId = $(this).find("input[name=exchange_id]").val() || null;
                $.ajax({
                    url: $(this).attr('action'),
                    type: "GET",
                    dataType: 'json',
                    data: {
                        "exchange_id": exchangeId
                    },
                    cache: false,
                    beforeSend: function() {
                        $("#custom-loader").removeClass('d-none');
                    },
                    complete: function() {
                        $("#custom-loader").addClass('d-none');
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#trackModal').find("#exchange-information").html(response.html)
                            $("#trackModal").modal('show');
                        } else {
                            notify('error', response.error || response.message)
                        }
                    },
                    error: function() {
                        notify('error', `@lang('Something went the wrong')`)
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
