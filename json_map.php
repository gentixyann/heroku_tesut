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
//var_dump($_SESSION["id"]);
?>


<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <title>See</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta name="Nova theme" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/hero.css" />
    <link rel="stylesheet" type="text/css" href="css/map_style.css">
    <link rel="stylesheet" href="css/navi.css" />
    <link rel="stylesheet" href="css/searchAddress.css" />

    <script type="text/javascript" src="js/footerFixed.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0jIuanGD4d4KNxkq2w4jbwxbQ0tMImXc&libraries=places"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>




<div id="inr">
    <a href="json_map.php?lang=ja"><img src="img/btn_03.png" width="60" height="15" alt="Japanese"></a>|
    <a href="json_map.php?lang=en"><img src="img/btn_04.png" width="52" height="15" alt="English"></a>
</div>

<header>
    <a class="navbar-brand logo" href="index.php"></a>

    <div class=" topnav" id="myTopnav">
        <?php if (isset($_SESSION["id"])){ ?>
        <a href="logout.php">Logout</a>
        <a href="profile.php">MyPage</a>
        <a href="post.php">POST</a>
        <?php } ?>
        <a href="help.php">Help</a>
        <a class="active" href="json_map.php">*MAP*</a>
        <a href="javascript:void(0);" style="font-size:30px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
</header>

<body>
<div class="row">
    <div class="col-xs-4 col-xs-offset-4">
        <input id="pac-input" class="controls" type="text" placeholder="Search">
    </div>
</div>

 <div id="gmap_wrapper">
  <div id="map_canvas"></div>
    </div>

    <div id="footer" class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8 webscope">
                <a href="privacy_policy.html"> <span class="webscope-text">Privacy Policy </span></a>
                <a href="terms_of_use.html"> <span class="webscope-text">Team Of Use </span></a>
                <a href="contact.php"> <span class="webscope-text">Contact Us</span></a>
                <span class="webscope-text"> The world view by </span>
                <a href="json_map.php"> <img src="img/logo04.png"/> </a>
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



<script type="text/javascript">

    $(function(){
    var json = <?php echo $json ?>;
    console.log(json);

    var data=jsonRequest(json);
    console.log(data);
    initialize(data);
    });

   // JSONファイル読み込み完了
function jsonRequest(json){
  var data=[];

    //Markersはjsonデータ配列のMarkerのこと。配列の塊を全て読み込んで、その数を変数nにする。
  if(json.Markers){
    var n=json.Markers.length;
    for(var i=0;i<n;i++){
      data.push(json.Markers[i]);
    }
  }
  return data;
}



//    console = null; // warningを表示しないようnullで(ry
  var currentInfoWindow = null;

  function createClickCallback(marker, infoWindow) {
    return function() {
      if (currentInfoWindow){
        currentInfoWindow.close();
      }
      infoWindow.open(marker.getMap(), marker);

      currentInfoWindow = infoWindow;
    };
  }

    var map; 
    var marker = ""; 
    var randomLat = Math.random()*140 - 70; 
    var randomLng = Math.random()*360 - 180; 
    var input = document.getElementById('pac-input'); 
    var searchBox = new google.maps.places.SearchBox(input);

// マップを生成して、複数のマーカーを追加
function initialize(data/*Array*/){

//この変数がmapのoption
  var op={
    zoom:8,
    //center:new google.maps.LatLng(34.67347038699344,135.44394850730896),
     center:new google.maps.LatLng(randomLat.toFixed(6),randomLng.toFixed(6)),
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };

//基本となるマップのobject
   map=new google.maps.Map(document.getElementById("map_canvas"),op);

  var i=data.length;
    while(i-- >0){
        var dat = data[i];
        var marker=new google.maps.Marker({
            position:new google.maps.LatLng(dat.lat,dat.lng),
            map:map
        });

        var infoWindow = new google.maps.InfoWindow({
            content:'<div class="infoWindow">'+
            //dat.movie_infoはDBのカラム名
             '<p>'+dat.movie_info+'</p>'+
             '</div>'
        });
         google.maps.event.addListener(marker, 'click', createClickCallback(marker, infoWindow));
    }

     var geocoder = new google.maps.Geocoder();
            //createElementでdivを生成。
     var geolocationDiv = document.createElement('div');
            //GeolocationControlで現在地とる。jsのAPI
     var geolocationControl = new GeolocationControl(geolocationDiv, map);

       //現在地ボタンをmapの中に表示
      map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push
      (geolocationDiv);

      //住所検索のinputをmapの中に表示
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
      map.addListener('bounds_changed', function(){
      searchAddress()
   })
}//end of initialize()

//住所検索の関数
function searchAddress(){
        searchBox.setBounds(map.getBounds());
        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              //console.log("Returned place contains no geometry");
              alert("Returned place contains no geometry");
              return;
            }

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              title: place.name,
              zoom: 15,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
}

  function GeolocationControl(controlDiv, map) {

    // Set CSS for the control button
    //createElementでdivを作る。その変数がcontrolUI。ボタンの箱作ってる
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
	controlUI.style.border = 'none';
	controlUI.style.outline = 'none';
	controlUI.style.width = '28px';
	controlUI.style.height = '28px';
	controlUI.style.borderRadius = '2px';
	controlUI.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
	controlUI.style.cursor = 'pointer';
	controlUI.style.marginRight = '10px';
	controlUI.style.padding = '0px';
	controlUI.title = 'Your Location';
	controlDiv.appendChild(controlUI);

    // Set CSS for the control text
    //ボタン作ってる
    var controlText = document.createElement('div');
    controlText.style.margin = '5px';
	controlText.style.width = '18px';
  controlText.style.height = '18px';
	controlText.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
	controlText.style.backgroundSize = '180px 18px';
	controlText.style.backgroundPosition = '0px 0px';
	controlText.style.backgroundRepeat = 'no-repeat';
	controlText.id = 'you_location_img';
	controlUI.appendChild(controlText);

    // Setup the click event listeners to geolocate user
    //controlUIクリックしたらgeolocate関数発動
    google.maps.event.addDomListener(controlUI, 'click', geolocate);
}

    //現在地ボタン押した時のgeolocate
    function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            // Create a marker and center map on user location
             marker = new google.maps.Marker({
                position: pos,
                draggable: true,
                animation: google.maps.Animation.DROP,
                zoom: 12,
                map: map
            });
            //座標をセット。１番目の引数には設定する中心座標
            map.setCenter(pos);
        });
    }else {
               //Geolocation API使えん
         handleLocationError(false, map.getCenter());
            }
}

</script>

 <script src="js/navi.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</body>
</html>
