<?php 
session_start();



require('dbconnect.php');

  if(isset($_POST) && !empty($_POST["nick_name"])  && !empty($_POST["email"]) && !empty($_POST["inquiries"])){

    $nick_name = $_POST["nick_name"];
    $email = $_POST["email"];
    $inquiries = $_POST["inquiries"];
    $member_id = $_SESSION['id'];

    
      $sql = "INSERT INTO `whereis_contact`(`member_id`, `nick_name`, `email`, `inquiries`, `created`) VALUES ($member_id, '$nick_name', '$email', '$inquiries', now())";
      $data = array($nick_name, $email, $inquiries);
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

// $to      = 'kokogento@gmail.com';
// $subject = 'title';
// $message = 'body';
// $headers = 'From: from@hoge.co.jp' . "\r\n";

// if(mail($to, $subject, $message, $headers)){
//  echo "メールを送信しました";
// }else{
//   echo "メールの送信に失敗しました";
// }


header("Location: contact.php");

  }
var_dump($_SESSION["id"]);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Contact Us</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="js/footerFixed.js"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/navi.css" />
    <link rel="stylesheet" href="css/hero.css" />
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>


    <script>
    //Google Maps
    //initMapでMapを作っている
      var map;
      var randomLat = Math.random()*140 - 70;
      var randomLng = Math.random()*360 - 180;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          //center: {lat: -34.397, lng: 150.644},
          center: {lat: randomLat, lng: randomLng},
          zoom: 3
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL3qe_lcSnHCs7ENLJM9sMEHnxNABZb04&callback=initMap"
    async defer></script>



    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        /*height: 100%;*/
        height:250px;
        width: 250px;
        border-radius: 50%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <!-- header -->

</head>
<body>

<header>
   <a class="navbar-brand logo" href="index.php"></a>
    <div class=" topnav" id="myTopnav"> 
       <?php if (isset($_SESSION["id"])){ ?>
       <a href="logout.php">Logout</a>
       <a href="profile.php">MyPage</a>
       <a href="post.php">POST</a>
       <?php } ?>
       <a href="help.php">Help</a>
       <a href="json_map.php">*MAP*</a>
      <a href="javascript:void(0);" style="font-size:30px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
</header>

  <div class="container">
    <div class="row">
      <section>
        <div class="col-xs-4">
          <div id="map"></div>
        </div>

            <div class="col-xs-6">
              <form id="update" method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
                <legend class="profile_title">Contact Us</legend>
                <!-- Your Name -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Your Name</label>
                      <div class="col-sm-8">
                        <input type="text" name="nick_name" class="form-control" placeholder=""   value="">
                      </div>
                  </div>
                  <!-- Email Address -->
                  <div class="form-group">
                    <label class="col-sm-3 control-label">E-mail</label>
                      <div class="col-sm-8">
                        <input type="email" name="email" class="form-control" placeholder="" value="">
                      </div>
                  </div>
                  
                  <!-- Message -->
                  <div class="form-group">
                    <div class="col-sm-11">
                      <textarea name="inquiries" class="form-control" placeholder="Enter Your Message" value="" rows="10" cols="100"></textarea>

                      <?php if(isset($_POST["inquiries"]) && ($_POST["inquiries"] == "")){ ?>
                        <p class="error">Please Enter Your Message.</p>
                      <?php } ?>
                
                    </div>
                  </div>
                  <!-- </form> -->
                  <div class="submit_button form-group">
                  <input id="btn-submit" type="submit" class="btn btn-default" value="Send Email">
                  </div>
              </form>
            </div>

      </section>
    </div>
  </div>

  <div id="footer" class="footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-2"></div>
          <div class="col-sm-8 webscope">
            <span class="webscope-text"> The world view by </span>
            <a href="index.php,,"> <img src="img/logo04.png"/> </a>
          </div>
        <div class="col-sm-2"></div>
      </div>
    </div>
  </div>

 <script src="js/navi.js"> </script>
  <script src="js/warn_contact.js"> </script>
  <script>
    $(document).on('click', '#btn-submit', function(e) {
         e.preventDefault();
          popup();
    });

    // 関数で一つにまとめる
    function popup() {

      // optionsの中身を設定 = ボタンを押した時に出るダイアログ
      var options = {
        title: "メールを送信しますか",
        icon: "info",
        buttons: {
          cancel: "Cancel", // キャンセルボタン
          ok: true
        }
      };

      // この関数がコールバック処理をしている
      swal(options)
        // then() メソッドを使えばクリックした時の値が取れます
        .then(function(val) {
          console.log(val)
          if (val) {
            // Okボタンが押された時の処理
            // この中でコールバック処理をしている
            swal({
              text: "メールを送信しました",
              icon: "success",
            });
        // submitされた何秒後に自動的に閉じる
              setTimeout(
                function(){
                  // ()の中はformのidからきている #myform #はidを指定する時に使い、. はclassを指定する時に使う
               $('#update').submit();
              },2000);

          } else {
            // キャンセルボタンを押した時の処理
            // この中でコールバック処理をしている
            // valには 'null' が返ってきます
            swal({
              text: "キャンセルされました",
              icon: "warning",
              buttons: false,
              timer: 2500 // 2.5秒後に自動的に閉じる
            });
          }
      });
    }
  </script>
  </body>
  </html>