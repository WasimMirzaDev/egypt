<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title> {{ $general->siteName(__($pageTitle)) }}</title>
    @include('partials.seo')
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/color.php') }}?color={{ $general->base_color }}">




    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>


    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    @stack('style-lib')
    @stack('style')

    <style>

        .red-star {
            color: red;
            font-size: 29px !important;
            margin: 0px !important;
        }
        .orange-star{
            color:orange;
            font-size: 29px !important;
            margin: 0px !important;
        }
        .yellow-star {
            color: yellow;
            font-size: 29px !important;
            margin: 0px !important;
        }
        .green-yellow-star{
            color:greenyellow;
            font-size: 29px !important;
            margin: 0px !important;
        }
        .green-star{
            color:#11bd50;
            font-size: 29px !important;
            margin: 0px !important;
        }
        .size{
            font-size: 28px;
            cursor: pointer;
            margin:1px;

        }

        #rating_bar>span:hover:before,
        #rating_bar span:hover~span:before {
            color: #800080;

        }
        .slider-navigation {
            /* Adjust margin, padding, and other properties as needed */
        }

        .slider-dot {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            margin: 0 5px;
            background-color: lightgray; /* Default button color */
            transition: background-color 0.3s;
        }

        .slider-dot.active {
            background-color: purple; /* Active button color */
            cursor: pointer;
        }
    </style>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8477768365835363"
     crossorigin="anonymous"></script>
</head>

<body>
    <div class="preloader">
        <div class="preloader__img">
            <img src="{{ siteFavicon() }}" alt="image">
        </div>
    </div>

    @if (!request()->routeIs('user.login') && !request()->routeIs('user.register'))
        @include($activeTemplate . 'partials.notice_bar')
    @endif

    @yield('panel')

    @if (!request()->routeIs('user.login') && !request()->routeIs('user.register'))
        @include($activeTemplate . 'partials.footer')
    @endif

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/slick.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>

    @stack('script-lib')
    @stack('script')

    @include('partials.plugins')

    @include('partials.notify')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const reviewUsButton = document.getElementById("reviewUsButton");
            const unworkingModal = document.getElementById("unworkingModal");
            const modalCloseButton = unworkingModal.querySelector(".close");
            const modalBackdrop = document.querySelector(".modal-backdrop");

            reviewUsButton.addEventListener("click", function() {
                unworkingModal.classList.add("show", "fade");
                unworkingModal.style.display = "block";
                document.body.classList.add("modal-open");
                modalBackdrop.classList.add("fade", "show");
                document.body.appendChild(modalBackdrop);
            });

            modalCloseButton.addEventListener("click", function() {

                unworkingModal.classList.remove("show", "fade");
                unworkingModal.style.display = "none";
                document.body.classList.remove("modal-open");
                modalBackdrop.classList.remove("fade", "show");
                document.body.removeChild(modalBackdrop);
            });


            modalBackdrop.addEventListener("click", function() {
                unworkingModal.classList.remove("show", "fade");
                unworkingModal.style.display = "none";
                document.body.classList.remove("modal-open");
                modalBackdrop.classList.remove("fade", "show");
                document.body.removeChild(modalBackdrop);
            });
        });

    </script>

    <script>
        $(document).ready(function() {
            $(".star1").hover(function() {
                $(".star1, .star2, .star3, .star4, .star5").removeClass("red-star orange-star yellow-star green-yellow-star green-star");
                $(this).addClass("red-star");
            });

            $(".star2").hover(function() {
                $(".star1, .star2, .star3, .star4, .star5").removeClass("red-star orange-star yellow-star green-yellow-star green-star");
                $(this).prevAll().addBack().addClass("orange-star");
            });

            $(".star3").hover(function() {
                $(".star1, .star2, .star3, .star4, .star5").removeClass("red-star orange-star yellow-star green-yellow-star green-star");
                $(this).prevAll().addBack().addClass("yellow-star");
            });

            $(".star4").hover(function() {
                $(".star1, .star2, .star3, .star4, .star5").removeClass("red-star orange-star yellow-star green-yellow-star green-star");
                $(this).prevAll().addBack().addClass("green-yellow-star");
            });

            $(".star5").hover(function() {
                $(".star1, .star2, .star3, .star4, .star5").removeClass("red-star orange-star yellow-star green-yellow-star green-star");
                $(this).prevAll().addBack().addClass("green-star");
            });
            var rating
            $(".size").hover(
                function () {
                    rating = $(this).attr("value");

                }
            );

            $("#submitReview").click(function(event) {
                event.preventDefault();
                var description = $("#reviewDescription").val();


                $.ajax({
                    type: "POST",
                    url: "{{route('user.submit.review')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        rating: rating,
                        description: description
                    },
                    success: function(response) {
                        $("#unworkingModal").hide();

                        if (response.success) {
                            // Show SweetAlert success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                // Redirect or perform any other action after success
                                window.location.href = "{{ route('home') }}"; // Example redirection
                            });
                        }

                    },
                    error: function(xhr, status, error) {

                        console.log(xhr,error)
                        console.log(xhr.responseJSON.error)
                        if(xhr.responseJSON.error){
                            Swal.fire({
                                icon: 'error',
                                title: 'Unauthorized',
                                text: xhr.responseJSON.error,
                                timer:5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('user.login') }}";
                            });
                        }
                        else {
                            $("#unworkingModal").toggle();
                            console.log(xhr,error)

                            Swal.fire({

                                icon: 'error',
                                title: 'Validation Error',
                                text: xhr.responseJSON.message,
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer || result.dismiss === Swal.DismissReason.close) {

                                }
                            });

                        }
                        // Show SweetAlert error message

                    }
                });

            });

        });

    </script>

    <script>



        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            $('.policy').on('click', function() {
                $.get('{{ route('cookie.accept') }}', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });
            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);


            $.each($('input, select, textarea'), function(index, element) {
                $(element).siblings('label').attr('for', $(element).attr('name'));
                if (!$(element).attr('id')) {
                    $(element).attr('id', $(element).attr('name'))
                }
            });

            $.each($('input, select, textarea'), function(i, element) {
                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            });
            $('.captcha div').css({
                "background-color": "#fff",
                "border": "1px solid #f1f1f1",
                "border-radius": "5px",
                "font-size": "24px",
                "letter-spacing": "16px",
            });
        })(jQuery);
    </script>
</body>

</html>
