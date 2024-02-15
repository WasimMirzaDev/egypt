@php
    $content = getContent('testimonial.content', true);
    $elements = getContent('testimonial.element');
@endphp
@if ($content)
    <div class="pt-80 pb-80 section-bg">
        <div class="container">
            <div class="row justify-content-center ms-5 mb-3">
                <div class="col-md-10">
                    <div class="section-title ms-4">
                        <div class="section-title__wrapper">
                            <h2 class="section-title__title mb-1">{{ __(@$content->data_values->heading) }}</h2>
                            <p class="section-title__desc">{{ __(@$content->data_values->subheading) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                     <button id="reviewUsButton" class=" rounded py-1 px-4 btn--primary shadow-lg"  data-bs-toggle="modal" data-bs-target="workingModal">Review Us</button>
                </div>

{{--                //modal code//--}}

                @include('partials._reviewModal')

            </div>

            <!-- Carousel wrapper -->
            @if(@$reviews)
            <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner" style="margin-bottom: 40px;">

                    @foreach(@$reviews->chunk(3) as $index => $reviewChunk)
                        <div class="carousel-item {{$index === 0 ? 'active' : ''}}">
                            <div class="row text-center p-4 mb-5">
                                @foreach($reviewChunk as $review)
                                    <div class="col-md-4 mb-4 mb-md-0 card-hover-bounce ">
                                        <div class="card  ">
                                            <div class="card-body py-4  mt-2">
                                                <div class="d-flex justify-content-center mb-4">

                                                    <img src="{{ asset('assets/images/user/u.jfif') }}" class="rounded-circle shadow-1-strong" width="110" height="70" />

                                                </div>
                                                <h4 class="font-weight-bold"><b>{{$review->user->fullname}}</b></h4>

                                                <ul class="list-unstyled d-flex justify-content-center">
                                                    @php
                                                        $rating = $review->rating;
                                                        $fullStars = floor($rating);
                                                        $halfStar = $rating - $fullStars;
                                                    @endphp

                                                    @for($i = 1; $i <= $fullStars; $i++)
                                                        <li><i style="font-size: 1.2rem;margin:2px" class="fas fa-star text-warning"></i></li>
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
                        </div>
                    @endforeach
                </div>

                <div class="carousel-indicators mt-5 ">
                    @foreach(@$reviews->chunk(3) as $index => $reviewChunk)
                        <button style="margin-top:20px;width: 16px;height: 16px;border-radius: 50%;" type="button" data-bs-target="#reviewsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}   bg--primary rounded-circle" aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>

                <button   class="carousel-control-prev " type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            @endif



    </div>


@endif
