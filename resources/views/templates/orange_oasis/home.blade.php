@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $content = getContent('banner.content', true);
    @endphp
    

    <style>
    .banner-section {
        background: url('https://www.speedyexchanger.com/assets/templates/orange_oasis/images/shape/background.png') no-repeat center center fixed;
        background-size: cover;
    }
</style>


<div class="banner-section pt-10 pb-10">
    <div class="container">
        <h2 class="banner-title text-white">{{ __(@$content->data_values->heading) }}</h2>
        <div class="row g-6">
            <div class="col-lg-10">
                @include($activeTemplate . 'partials.exchange_form')
                @include($activeTemplate . 'partials.latest_exchange')
            </div>
            <div class="col-lg-10">
                @include($activeTemplate . 'partials.tracking_form')
            </div>
        </div>
    </div>
</div>
<!-- بوكس الترحيب -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Add styles for the dialog containers */
        .dialogContainer {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dialogBox {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
            margin: 20px;
        }

        /* Style for the OK button */
        .dialogBox button {
            background-color: #800080; /* Purple color */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold; /* Make the text bold */
            font-family: 'Courier New', monospace; /* Change the font family for the button text */
        }
    </style>
</head>
<body>
    <!-- Your website content goes here -->
    <!--<p>This is a paragraph on the website.</p>
    <button onclick="showDialog('dialogContainer1')">Show Dialog 1</button>
    <button onclick="showDialog('dialogContainer2')">Show Dialog 2</button>
    <button onclick="showDialog('dialogContainer3')">Show Dialog 3</button>

    <!-- The dialog containers -->
    <!--<div id="dialogContainer1" class="dialogContainer">
        <div id="dialogBox1" class="dialogBox">
            <h4><strong>شبكه فيزا ريدوت باي بها عطل حالياً وان عادت سوف تعود الخدمه متاحه مره اخري</strong></h4>
            <p></p>
            <button onclick="closeDialog('dialogContainer1')">OK</button>
        </div>
    </div>-->

    <div id="dialogContainer2" class="dialogContainer">
        <div id="dialogBox2" class="dialogBox">
            <h4><strong>              <h4><strong>SPEEDY EXCHANGER تنويه هام لعملاء    🌹❤️</strong></h4>
           <p><strong>Redot pay فيزا</strong></p>
    <p><strong> IDوليست الـBNB يتم شحنها عن طريق شبكه</strong></p>
    <p><strong>يتم خصم 0.19 سنت عموله</strong></p>
    <p><strong>كمثال إذا أردت 10 دولار سيتم إرسال 9.81 دولار</strong></p>
    <p><strong>للسحب يجب ان تنتظر العمليه من 4 ساعات الي 24 ساعه وارفاق صوره الاثبات النهائيه عند ارسال الطلب<strong></p>
</strong></h4>
            <p></p>
            <button onclick="closeDialog('dialogContainer2')">OK</button>
        </div>
    </div>

    <div id="dialogContainer3" class="dialogContainer">
        <div id="dialogBox3" class="dialogBox">
            <h4><strong>اي عمليه هتم من رقم سنترال او مش من رقمك الشخصي هتعتبر مرفوضه ومواعيد العمل من 12م الي 12ص والتحويله بتم في 10 دقايق الي 4 ساعات وكحد أقصي 12 ساعه وغالباً التحويله بتم في دقايق </strong></h4>
            <p></p>
            <button onclick="closeDialog('dialogContainer3')">OK</button>
        </div>
    </div>

    <script>
        function showDialog(dialogId) {
            document.getElementById(dialogId).style.display = 'flex';
        }

        function closeDialog(dialogId) {
            document.getElementById(dialogId).style.display = 'none';
        }
    </script>
</body>
</html>

<!-- بوكس الترحيب 2 -->



<!-- بوكس الترحيب 2  -->


<!-- YouTube -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" />
<a href="https://www.youtube.com/@SPEEDYEXCHANGER" class="yt" target="_blank">
  <i class="fab fa-youtube y"></i>
</a>
<style>
  .yt {
    position: fixed;
    width: 50px;
    height: 50px;
    bottom: 270px;
    left: 13px;
    background-color: #ff0000;
    color: #fff;
    border-radius: 33px;
    text-align: center;
    font-size: 33px;
    z-index: 100;
  }
  .y {
    color: #fff;
    margin-top: 1px;
  }
  .yt {
    animation: pulse 2s infinite;
  }
  .yt:hover {
    box-shadow: 2px 2px 11px rgb(0 0 0 / 70%);
  }
  @keyframes btnun-what {
    10% {
      transform: translate(0, 200px);
    }
    50% {
      transform: translate(0, -40px);
    }
    70% {
      transform: scale(1.1);
    }
  }
  @keyframes pulse {
    50% {
      transform: scale(1.1);
    }
  }
</style>
<!-- YouTube -->

 <!-- Facebook -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" />
<a href="https://www.facebook.com/profile.php?id=100092699509916" class="fb" target="_blank">
  <i class="fab fa-facebook f"></i>
</a>
<style>
  .fb {
    position: fixed;
    width: 50px;
    height: 50px;
    bottom: 200px;
    left: 13px;
    background-color: #1877f2;
    color: #fff;
    border-radius: 33px;
    text-align: center;
    font-size: 33px;
    z-index: 100;
  }
  .f {
    color: #fff;
    margin-top: 1px;
  }
  .fb {
    animation: pulse 2s infinite;
  }
  .fb:hover {
    box-shadow: 2px 2px 11px rgb(0 0 0 / 70%);
  }
  @keyframes btnun-what {
    10% {
      transform: translate(0, 200px);
    }
    50% {
      transform: translate(0, -40px);
    }
    70% {
      transform: scale(1.1);
    }
  }
  @keyframes pulse {
    50% {
      transform: scale(1.1);
    }
  }
</style>
<!-- Facebook -->

<!-- WhatsApp -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" />
<a href="##" class="wa" target="_blank">
  <i class="fab fa-whatsapp w"></i>
</a>
<style>
  .wa {
    position: fixed;
    width: 50px;
    height: 50px;
    bottom: 60px;
    left: 13px;
    background-color: #25D366;
    color: #fff;
    border-radius: 33px;
    text-align: center;
    font-size: 33px;
    z-index: 100;
  }
  .w {
    color: #fff;
    margin-top: 1px;
  }
  .wa {
    animation: pulse 2s infinite;
  }
  .wa:hover {
    box-shadow: 2px 2px 11px rgb(0 0 0 / 70%);
  }
  @keyframes btnun-what {
    10% {
      transform: translate(0, 200px);
    }
    50% {
      transform: translate(0, -40px);
    }
    70% {
      transform: scale(1.1);
    }
  }
  @keyframes pulse {
    50% {
      transform: scale(1.1);
    }
  }
</style>
<!-- WhatsApp -->  


    <!--تليجرام-->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css"/><a href="https://t.me/+X3glDPAwfMtiYmU0" class="tel" target="_blank"><i class="fab fa-telegram t"></i></a><style>.tel{position:fixed;width:50px;height:50px;bottom:130px;left:13px;background-color:#57b7eb;color:#FFF;border-radius:33px;text-align:center;font-size:33px;z-index:100} .t{color:#FFF;margin-top:1px} .tel{animation:pulse 2s infinite} .tel:hover{box-shadow: 2px 2px 11px rgb(0 0 0 / 70%);}   @keyframes btnun-what{10%{transform:translate(0,200px)}50%{transform:translate(0,-40px)}70%{transform:scale(1.1)}} @keyframes pulse{50%{transform:scale(1.1)}}   </style> 
     <!--تليجرام-->
     
     


<!-- Messenger المكون الإضافي "دردشة" Code -->
    <div id="fb-root"></div>

    <!-- Your المكون الإضافي "دردشة" code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "120523234379778");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v17.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
<!---مسنجر-->
	
    @if ($sections && $sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
    
@endsection
