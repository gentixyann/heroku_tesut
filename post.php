<?php
session_start();

//DBに接続
require('dbconnect.php');

if(isset($_POST) && !empty($_POST["lat"]) && !empty($_POST["lng"]) && !empty($_POST["iframe"]) && !empty($_POST["address"])){
  //trim関数 文字列の両端の空白を削除
    $member_id = $_SESSION["id"];
    $lat = trim($_POST['lat']);
     $lng = trim($_POST['lng']);
     $iframe = trim($_POST['iframe']);
    $address = trim($_POST['address']);
    
    
  try{
//DBに動画情報を登録するSQL文
  //now() MySQLが用意した関数。現在日時を取得。
  $sql = " INSERT INTO `whereis_map`(`member_id`, `lat`, `lng`,
  `movie_info`, `address`, `created`)
   VALUES ('$member_id', '$lat','$lng','$iframe','$address',now() )";

      
  //SQL文実行
   //sha1 暗号化行う関数
   $data = array($member_id, $lat, $lng, $iframe, $address);

// print $sql."<br />\n";
// var_dump($data);
   $stmt = $dbh->prepare($sql);
   $stmt->execute($data);

   header("Location: post.php");
    exit();

  }catch(Exception $e){

  }
}

var_dump($_SESSION["id"]);
var_dump($_SESSION["lang"]);

if(isset($_SESSION["lang"])){
    $lang = $_SESSION["lang"];

function trans($word,$lang){
  //翻訳ファイルを読み込み
  require("lang/words_".$lang.".php");

  //配列からデータを取得
  $trans_word = $word_list[$word];

  //文字を返す
  return $trans_word;
}
}

?>


    <html>

    <head>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>post</title>
        <meta name="Nova theme" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

        <link rel="stylesheet" href="css/post.css" />
        <link rel="stylesheet" href="css/hero.css" />
        <link rel="stylesheet" href="css/navi.css" />

        <!-- Google Maps APIの読み込み -->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZAIM1bSjO2lOUlrRBsNt4sQ-xmAItFaU"></script>

    </head>

    <body>
        <div class="hero-background">
  <header>
       
    <div class=" topnav" id="myTopnav"> 
       <?php if (isset($_SESSION["id"])){ ?>
       <a href="logout.php">Logout</a>
       <a href="profile.php">MyPage</a>
       <a class="active" href="post.php">POST</a>
       <?php } ?>
       <a href="help.php">Help</a>
       <a href="contact.php">Contact</a>
       <a href="json_map.php">*MAP*</a>
      <a href="javascript:void(0);" style="font-size:30px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>  
  </header>
  

            <div class="container">
                <div class="hero row">
                    <div class="row">
                        <div class="col-md-6">
                            <h1>POST<small><?php echo trans("ここで投稿できるよ",$lang); ?></small></h1>
                        </div>
                        <div class="col-md-6">
                            <h1><a href="https://www.youtube.com" target="_blank"><img src="img/yt_logo.png" width="200" height="40"></a></h1>
                        </div>
                    </div>

                    <form action="" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputlat"><?php echo trans("緯度",$lang); ?></label>
                                <input type="text" id="map_lat" class="form-control" name="lat">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputlng"><?php echo trans("経度",$lang); ?></label>
                                <input type="text" id="map_lng" class="form-control" name="lng">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputiframe"><?php echo trans("動画埋め込みコード",$lang); ?></label>
                            <input type="text" class="form-control" name="iframe">
                        </div>
                        <input type="hidden" id="map_address" name="address">
                        <button type="submit" class="btn btn-primary">Go</button>
                    </form>

                    <p>
                        <label for="svp_2">
            <input type="radio" name="svp" id="svp_2" value="1" onclick="review()" />
            <?php echo trans("ストリートビューパノラマを表示",$lang); ?></label>
                    </p>

                    <table id="infoshow">
                        <tr class="info">
                            <td><?php echo trans("住所",$lang); ?></td>
                            <td id="id_address"></td>
                        </tr>
                    </table>

                    <div class="row">
                        <div class="col-xs-4">
                            <input type="text" id="address" class="form-control" placeholder="<?php echo trans("住所か地名ね",$lang); ?>">
                        </div>
                        <button type="button" id="submit" class="btn btn-primary"><?php echo trans("検索",$lang); ?></button>
                    </div>

                    <br>

                    <!-- 地図の埋め込み表示 -->
                    <div id="map"></div>
                    <!-- ストリートビュー表示 -->
                    <div id="svp"></div>

                </div>
                <!--hero-->
            </div>
            <!--hero-container-->
        </div>
        <!--hero-background-->


        <!-- Features
  ================================================== -->

        <!--features-section-->

        <!-- Logos
  ================================================== -->



        <!-- White-Section
  ================================================== -->

        <!--white-section-text-section--->


        <!-- Pricing
  ================================================== -->
        <!--pricing-background-->

        <!-- Team
  ================================================== -->

        <!--team-section--->

        <!-- Email-Section
  ================================================== -->


        <!--blue-section-->

        <!-- Footer
  ================================================== -->

        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8 webscope">
                        <span class="webscope-text"> The world view by </span>
                        <a href=""> <img src="img/logo04.png"/> </a>
                    </div>
                    <!--webscope-->
                    <div class="col-sm-2">
                        <!--social-links-->
                    </div>
                    <!--social-links-parent-->
                </div>
                <!--row-->
            </div>
            <!--container-->
        </div>
        <!--footer-->

        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="js/navi.js"></script>
        <script src="js/post.js"></script>

    </body>

    </html>
