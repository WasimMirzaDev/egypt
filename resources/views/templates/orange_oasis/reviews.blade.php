@extends($activeTemplate . 'layouts.frontend')
@php
    $reviews = getContent('contact_us.content', true);
    $elements = getContent('contact_us.element', orderById: true);
@endphp
@section('content')

        <div class="bg-light">
            <div class="container">
                <div class="row">
                    @foreach($reviewss as $review)

                        <div class="rounded shadow-lg mt-5 mb-5 bg-white d-flex align-items-center card-hover-bounce p-5">
                            <div class="col-md-5 p-1">
                                <img src="{{ asset('assets/images/user/u.jfif') }}" class="shadow-1-strong ms-5" width="210" height="150" />
                            </div>
                            <div class="col-md-7 p-1">
                                <div class="px-3">

                                    <h3 class="font-weight-bold mb-2"><b>{{$review->user->fullname}}</b></h3>
                                    <ul class="list-unstyled d-flex mb-2">
                                        @php
                                            $rating = $review->rating;
                                            $fullStars = floor($rating);
                                            $halfStar = $rating - $fullStars;
                                        @endphp

                                        @for($i = 1; $i <= $fullStars; $i++)
                                            <li><i style="font-size: 2rem;margin:2px" class="fas fa-star text-warning"></i></li>
                                        @endfor

                                        @if($halfStar > 0)
                                            <li><i class="fas fa-star-half-alt  text-lite"></i></li>
                                        @endif

                                        @for($i = 1; $i <= (5 - $rating); $i++)
                                            <li><i class="far fa-star  text-lite"></i></li>
                                        @endfor
                                    </ul>
                                    <p class="mb-2">
                                        <i class="fas fa-quote-left pe-2"></i>{{$review->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center mt-4 mb-4">
                        {{ $reviewss->links() }}
                    </div>
                </div>
            </div>
        </div>


@endsection


@push('script')
    <script>
        "use strict";
        (function($) {

            let captcha = $("input[name=captcha]");
            if (parseInt(captcha.length) > 0) {
                let html = `
                        <div class="floating-label form-group mb-0">
                                <input type="text" name="captcha" class="floating-input form-control form--control" placeholder="none" required>
                                <label class="form-label-two" for="">@lang('Captcha')</label>
                        </div>
                        `;
                $(captcha).remove();
                $(".captchaInput").html(html);
            }

            $('.customCaptcha').find('label').first().remove();

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .contact-form {
            max-width: unset;
        }

        .fw-medium {
            font-weight: 600 !important;
        }

        .contact-info {
            background: #ffffff;
            padding: 30px;
            box-shadow: 0 3px 45px #e6edf4db;
            border-radius: 15px;
        }
    </style>
@endpush
