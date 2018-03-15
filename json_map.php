<?php
session_start();
require('dbconnect.php');

try{
 //markerしてる人の情報とる
    $sql = "SELECT * FROM `whereis_map` ";

    //sql実行
    //実行待ち
    $stmt = $dbh->prepare($sql);
    //実行
    $stmt->execute();

    $marker_info["Markers"] = array();
     while (1) {

          //PDOはPHP Data Objects FETCH_ASSOCは連想配列で取り出す意味
     $marker_data = $stmt->fetch(PDO::FETCH_ASSOC);
         $marker_info["Markers"][] = $marker_data;
         
         if ($marker_data == false){
         break;//中断する
     }else{            
    $json = json_encode($marker_info, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); 
        //var_dump($json);
   }
     }

}catch(Exception $e){

  }

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
var_dump($_SESSION["id"]);
?>


<!doctype html>
<html lang="ja">
<head>
 <meta charset="utf-8" />
 <title>See</title>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />   
    <meta name="Nova theme" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/hero.css"/>
   <link rel="stylesheet" type="text/css" href="css/map_style.css">
    <link rel="stylesheet" href="css/navi.css" />
    
    <script type="text/javascript" src="js/footerFixed.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0jIuanGD4d4KNxkq2w4jbwxbQ0tMImXc"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>


<header>
       <a class="navbar-brand logo" href="index.php"></a>
       
    <div class=" topnav" id="myTopnav"> 
       <?php if (isset($_SESSION["id"])){ ?>
       <a href="logout.php">Logout</a>
       <a href="profile.php">MyPage</a>
       <a href="post.php">POST</a>
       <?php } ?>
       <a href="help.php">Help</a>
       <a href="contact.php">Contact</a>
       <a class="active" href="json_map.php">*MAP*</a>
      <a href="javascript:void(0);" style="font-size:30px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
  </header>

<body>
  
  <div class="row">
	<div class="col-xs-4 col-xs-offset-4">
		<input type="text" id="address" class="form-control" placeholder="<?php echo trans("住所か地名ね",$lang); ?> ">
	</div>
    <button type="button" id="submit" class="btn btn-primary"> <?php echo trans("検索",$lang); ?> </button>
</div>

 <div id="gmap_wrapper">
  <div id="map_canvas"></div>
    </div>
     
    <div id="footer" class="footer">
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

 <script src="js/navi.js"></script>
 <script src="js/json_map.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</body>
</html>