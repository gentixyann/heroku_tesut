<?php
session_start();


// DBに接続
  require('dbconnect.php');

?>




<html>
<head>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-NVT76Q6');</script>
  <!-- End Google Tag Manager -->

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WheView</title>
    <meta name="Nova theme" content="width=device-width, initial-scale=1">

    <!--    Goodle クライアントID-->
    <meta name="google-signin-client_id" content="***.apps.googleusercontent.com">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/login.css" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!--    Goodleのアカウント使用で必要-->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="js/analyticstracking.js"></script>

<style>
    .g-signin2 {
        width: 100%;
    }

    .g-signin2 div {
        margin: 0 auto;
    }
</style>
<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117970367-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-117970367-1');
</script> -->

</head>


<body>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NVT76Q6"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <!-- Navigation
    ================================================== -->
<div class="hero-background">

    <img class="strips" src="img/earth.png">

    <div class="container">
<div class="header-container header">

</div><!--end of header-->

        <div class="hero row">
<div class="hero-right col-sm-6 col-sm-6">
    <h1 class="header-headline bold">
        <p>Hello World</p>
        <br>
    </h1>
</div>

            <form method="POST" action="">
                <div class="col-sm-6 col-sm-6 ">
                    <div class="loginpanel">

                        <a href="json_map.php" class="submit_button">
                  <input type="button" value="Visitor" class="submit_button">
                  </a>

                        <div id="forget_pw">
                            <p>You need to login if you want to post</p>
                        </div>

                        <div class="hr">
                            <div></div>
                            <div>OR</div>
                            <div></div>
                        </div>

                        <div class="social" style="">

                            <div class="g-signin2" data-onsuccess="onSignIn"
                                 data-width=240 data-height="50"  data-longtitle="true"></div>
                        </div>

                    </div>
                </div>
            </form>
        </div><!--end of hero row-->
    </div><!--end of container-->
</div><!--end of hero-background-->

    <script src="https://www.gstatic.com/firebasejs/4.9.1/firebase.js"></script>


<script>
  // Initialize Firebase
  // san genのアカウント
  var config = {
    apiKey: "***",
    authDomain: "***.firebaseapp.com",
    databaseURL: "***.firebaseio.com",
    projectId: "***",
    storageBucket: "***.appspot.com",
    messagingSenderId: "***",
    appId: "***",
    measurementId: "***"
  };
  firebase.initializeApp(config);
</script>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script type="text/javascript" src="js/google_login.js"></script>
    <!-- <script src="js/script.js"></script> -->

</body>

</html>
