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
?>


<!doctype html>
<html lang="ja">
<head>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-NVT76Q6');</script>
  <!-- End Google Tag Manager -->

    <meta charset="utf-8" />
    <title>Wheview</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta name="description" content="Wheview is a website created by a person with GoPro and strolling. 世界中の景色を動画で収め、地図上に配置するサイトです。">

    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/map_style.css">
    <link rel="stylesheet" href="css/searchAddress.css" />
    <link rel="stylesheet" href="css/modal.css" />

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0jIuanGD4d4KNxkq2w4jbwxbQ0tMImXc&libraries=places"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="js/analyticstracking.js"></script>
    <!-- serviceworker.jsを登録 -->
    <script>
if('serviceWorker' in navigator){
	navigator.serviceWorker.register('/serviceworker.js').then(function(){
		console.log("Service Worker Registered");
	});
}
</script>

<!-- Adsense紐ずけのコード -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-7811832444315082",
          enable_page_level_ads: true
     });
</script>

</head>


<body>
  <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NVT76Q6"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<div class="fullheight">

  <div class="popupModal1">
   <input type="radio" name="modalPop" id="pop11" />
<label for="pop11">
       <i class="fas fa-bars fa-lg"></i>
 </label>

   <input type="radio" name="modalPop" id="pop12" />
   <label for="pop12">CLOSE</label>
   <input type="radio" name="modalPop" id="pop13" />
   <label for="pop13">×</label>
   <div class="modalPopup2">
    <div class="modalPopup3">
     <div class="modalTitle">Cameraperson wanted</div>
     <div class="modalMain">
     <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdTp7UzgJthRaIRQl6zXyMHkivy0Q5PL9CIGJAyNr1WSkDshA/viewform?embedded=true" width="640" height="1056" frameborder="0" marginheight="0" marginwidth="0">読み込んでいます...</iframe>
       <a href="https://www.facebook.com/groups/wheview/" target="_blank"><img id="facebook" src="img/f-ogo_RGB_HEX-58.png"></a>
       <a href="https://www.instagram.com/wheview/" target="_blank"><img id="instagram" src="img/instagram_PNG9.png"></a>
      <img id="youtube" src="img/yt_logo.png">
     </div>
    </div>
   </div>
  </div>

    <input id="pac-input" class="controls" type="text" placeholder="Search">

 <div id="gmap_wrapper">
  <div id="map_canvas"></div>
    </div>
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
     // １本指で操作するためのコード
     gestureHandling: 'greedy',
     //航空写真切り替え
     mapTypeControl: false,
     //移動ボタン
     panControl: false,
     //ズームボタン
     zoomControl: false,
     //ストリートビューボタン
     streetViewControl: false,
    // mapTypeId:google.maps.MapTypeId.ROADMAP
    //航空写真+ラベル
    mapTypeId: 'hybrid'
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

        var contentString = '<div class="content">'+
            '<div class="bodyContent">'+
            // '<p>'+dat.movie_info+'</p>'+
            dat.movie_info
            '</div>'+
            '</div>';

        var infoWindow = new google.maps.InfoWindow({
            content: contentString
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
          map.setZoom(15);
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
    controlText.style.margin = '2px';
  controlText.style.width = '28px';
    controlText.style.height = '28px';
    controlText.style.backgroundImage = 'url(img/gps10.png)';
    controlText.style.backgroundSize = '17px 17px';
  controlText.style.backgroundPosition = '4px 4px';
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
            map.setZoom(15);
        });
    }else {
               //Geolocation API使えん
         handleLocationError(false, map.getCenter());
            }
}

</script>
</body>
</html>
