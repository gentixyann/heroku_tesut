<?php
session_start();

//DB接続
require('dbconnect.php');
//var_dump($_SESSION["id"]);

  // if (isset($_POST["id"]) && empty($_POST["nick_name"]) && $_GET["error"] == 1) {
    
  //   header("Location: profile.php?error=1");
  //   exit();
  // }


  $sql = "SELECT * FROM `whereis_members` WHERE `id`=".$_SESSION["id"];
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $login_member = $stmt->fetch(PDO::FETCH_ASSOC);

  // var_dump($login_member['id']);


  if(isset($_POST["nick_name"]) && !empty($_POST["nick_name"]) || isset($_POST["email"]) && !empty($_POST["email"])){

    $ud_profile_sql = "UPDATE `whereis_members` SET `nick_name`=?,`email`=? WHERE `id`=".$_SESSION["id"];
    $ud_profile_data = array($_POST['nick_name'],$_POST['email']);
    $ud_profile_stmt = $dbh->prepare($ud_profile_sql);
    $ud_profile_stmt->execute($ud_profile_data);

    header("Location: profile.php?member_id".$_SESSION["id"]);
    exit();
  }


  $movie_sql = "SELECT * FROM `whereis_map` WHERE `member_id`=".$_SESSION["id"]." ORDER BY `created` DESC ";
  $movie_data = array($login_member['id']);
  $movie_stmt = $dbh->prepare($movie_sql);
  $movie_stmt->execute($movie_data);

        //var_dump($movie_sql);
        //var_dump($movie_data);

     $whereis_map = array();
      while(1){

        $one_movie = $movie_stmt->fetch(PDO::FETCH_ASSOC);
          //var_dump($one_movie);
        if($one_movie == false){
          break;
        }else{
          $whereis_map[] = $one_movie;

      }





        // if(isset($_POST["delete"])){
        //   // var_dump(isset($_POST["delete"]))
        //   $delete_movie = $whereis_map[0]["id"];

        //   var_dump($delete_movie);


        //   $del_sql = "DELETE FROM `whereis_map` WHERE `id`=".$delete_movie;
        //   $del_stmt = $dbh->prepare($del_sql);
        //   $del_stmt ->execute();

        //   header("Location: profile.php?member_id".$_SESSION["id"]);
        //   exit();
        // }


  }

   // var_dump($_POST);
      if (!empty($_POST["delete"])) {
        $del_sql = "DELETE FROM `whereis_map` WHERE `id`=".$_POST["delete"];
          $del_stmt = $dbh->prepare($del_sql);
          $del_stmt ->execute();

          header("Location: profile.php?member_id".$_SESSION["id"]);
          exit();
      }

?>




<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Page</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/form.css" rel="stylesheet"> -->
    <!-- <link href="assets/css/timeline.css" rel="stylesheet"> -->
    <link href="css/profile_tmp.css" rel="stylesheet">
    <link href="css/profile.css" rel="stylesheet">
    <!-- <link rel="styleseet" type="text/css" href="assets/css/bootstrap.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="profile.css"> -->
    <!-- header -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/navi.css" />
    <link rel="stylesheet" href="css/hero.css" />
    <script type="text/javascript" src="js/footerFixed.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
</head>
<body>

<header>
    <a class="navbar-brand logo" href="index.php"></a>
    <div class=" topnav" id="myTopnav">
     <?php if (isset($_SESSION["id"])){ ?>
       <a href="logout.php">Logout</a>
       <a class="active" href="profile.php">MyPage</a>
       <a href="post.php">POST</a>
       <?php } ?>
       <a href="help.php">Help</a>
       <a href="contact.php">Contact</a>
       <a href="json_map.php">*MAP*</a>
      <a href="javascript:void(0);" style="font-size:30px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
</header>

  <div class="container">
    <div class="row">
      <div class="col-xs-6 col-xs-offset-3 content-margin-top">
        <legend class="profile_title">Profile</legend>
        <form id="" method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
          <!-- Nick Name -->
          <div class="form-group">
            <label for="nick_name1" class="col-sm-3 control-label">Nick Name</label>
            <div class="col-sm-8">
              <p><?php echo $login_member["nick_name"]; ?></p>
            </div>
          </div>

          <!-- Email Address -->
          <div class="form-group">
            <label class="col-sm-3 control-label">E-mail</label>
            <div class="col-sm-8">
              <p><?php echo $login_member["email"]; ?></p>
            </div>
          </div>

        </form>
      </div>
   </div>
 </div>



<!-- 連想配列のキーがカラム名と同じものにテーブルのカラム名と同じものをかく予定）-->
<div class="container">
  <div class="row">
      <?php foreach ($whereis_map as $one_movie) { ?>
      <div class="messages-table">
        <div class="messages text-center">
          <div class="messages-top">
              <br>

                <div> <?php echo $one_movie["movie_info"]; ?></div>
                <div> <?php echo $one_movie["id"]; ?></div>

                <form id="delete" method="post">
                  <a><?php echo $one_movie["address"];?></a>
                  <!-- 投稿日時 -->
                  <a>
                  <?php
                  $created_date = $one_movie["created"];
                  //strtotime 文字型のデータを日時型に変換できる
                  //(Y年m月d日 と記述することも可能)(H24時間表記、h12時間表記)
                  $created_date = date("Y-m-d H:i",strtotime($created_date));
                  echo $created_date;
                  ?>
                  </a><br>
                  <!-- <?php //if(isset($_GET["id"]) && !empty($_GET["id"])){}?> -->
                   <!--  <input id="btn-delete" name="delete" type="submit" class="btn btn-default delete" value="削除"  data-add="<?php echo $one_movie["<address></address>"];?>"> -->




                    <input type="hidden" name="delete" value="<?php echo $one_movie["id"] ; ?>" >
                    <input type="submit" class="delete" value="削除">

                    <!-- <a href="profile.php?id=<?php // echo $one_movie["id"]; ?>"><input id="btn-delete" type="button" class="btn btn-default" value="削除"></a> -->

                  <br><br>
                </form>
          </div>
        </div>
      </div>
      <?php }?>
  </div>
</div>

  <div id="footer" class="footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-2"></div>
          <div class="col-sm-8 webscope">
            <span class="webscope-text"> The world view by </span>
            <a href=""> <img src="img/logo04.png"/> </a>
          </div>
        <div class="col-sm-2"></div>
      </div>
    </div>
  </div>

  <script src="js/navi.js"> </script>

  <!-- ポイント2つ -->
  <!-- form、inputにidをつける -->
  <!-- 関数でまとめる -->
  <!-- Change Profile -->

<script src="js/warning_form.js"></script>

</body>
</html>