<?php
session_start();


// DBに接続
  require('dbconnect.php');

$lang = "en";

if (isset($_GET["lang"])){
  $_SESSION["lang"] = $_GET["lang"];
  $lang = $_SESSION["lang"];
}else{
    $_SESSION["lang"] =  $lang;
}


function trans($word,$lang){
  //翻訳ファイルを読み込み
  require("lang/words_".$lang.".php");

  //配列からデータを取得
  $trans_word = $word_list[$word];

  //文字を返す
  return $trans_word;
}

?>




<html>
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Where is *(アスタリスク)</title>
    <meta name="Nova theme" content="width=device-width, initial-scale=1">

    <!--    Goodle クライアントID-->
    <meta name="google-signin-client_id" content="1028844914150-vequeee5hlji30ij1ci4v8ebdva5o42v.apps.googleusercontent.com">


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
    
<style>
    .g-signin2 {
        width: 100%;
    }

    .g-signin2>div {
        margin: 0 auto;
    }
</style>
    
    
    
</head>


<body>
    <!-- Navigation
    ================================================== -->
<div class="hero-background">
    <img class="strips" src="earth.png">

    <div class="container">
<div class="header-container header">
    <div class="header-right">
        <a class="navbar-item" href="contact.php">Contact</a>
        <a class="navbar-item" href="index.php?lang=ja">
            <?php echo trans("ja",$lang); ?>
        </a>
        <a class="navbar-item" href="index.php?lang=en">
            <?php echo trans("en",$lang); ?>
        </a>
    </div><!--end of header-right-->
</div><!--end of header-->

        <div class="hero row">
<div class="hero-right col-sm-6 col-sm-6">
    <h1 class="header-headline bold">
        <?php echo trans("世界の景色をお手軽に",$lang); ?>
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
                            <p>投稿にはログインが必要だぜ</p>
                        </div>

                        <div class="hr">
                            <div></div>
                            <div>OR</div>
                            <div></div>
                        </div>
                                                               
                        <div class="social" style="">
                           
                            <div class="g-signin2" data-onsuccess="onSignIn" 
                                 data-width=220 data-height="50"  data-longtitle="true"></div>                  
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
  var config = {
    apiKey: "AIzaSyDVezH32ZycwFc8mHGYyhQgK0ovBgX1WGY",
    //apiKey: "AIzaSyDStsWYUik9kLI-hbkIPQxSsBX-X-smIlw",  
    authDomain: "where-map-e3a10.firebaseapp.com",
    databaseURL: "https://where-map-e3a10.firebaseio.com",
    projectId: "where-map-e3a10",
    storageBucket: "where-map-e3a10.appspot.com",
    messagingSenderId: "1028844914150"
  };
  firebase.initializeApp(config);
</script>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script type="text/javascript" src="js/google_login.js"></script>
    <script src="js/login.js"></script>
    <script src="js/script.js"></script>

</body>

</html>