<!doctype html>
<html lang="ja">
<head>
 <meta charset="utf-8" />
 <title>See</title>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
   
    <meta name="Nova theme" content="width=device-width, initial-scale=1">
<!--    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png"/>-->
    
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    
<!--    <link rel="stylesheet" href="css/responsive.css"/>-->

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
   
    <link rel="stylesheet" href="css/hero.css"/>

   <link rel="stylesheet" type="text/css" href="css/map_style.css">
   
    <link rel="stylesheet" href="css/navi.css" />
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    
    <script type="text/javascript" src="js/footerFixed.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0jIuanGD4d4KNxkq2w4jbwxbQ0tMImXc"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!--<script src="data.js"></script>-->
</head>


<header>
   
       <a class="navbar-brand logo" href="#"></a>
       
    <div class=" topnav" id="myTopnav">
      <a href="#">Logout</a>
       <a href="#">Contact</a>
       <a href="#">MyPage</a>
       <a href="#">POST</a>
       <a class="active" href="#">*MAP*</a>
       <a href="javascript:void(0);" style="font-size:30px;" class="icon" onclick="myFunction()">&#9776;</a>
    </div>
  
  </header>





<body>
  
  <div class="row">
	<div class="col-xs-4 col-xs-offset-4">
	
		<input type="text" id="address" class="form-control" placeholder="住所か地名ね">
	</div>
    <button type="button" id="submit" class="btn btn-primary">検索</button>
      
</div>
  
  
  
<!--
  <div id="floating-panel">
    <input id="address" type="textbox" placeholder="住所か地名ね">
    <input id="submit" type="button" value="Geocode">
</div>
-->

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



<script type="text/javascript">
    
   $(function(){
  // JSONファイル読み込み開始
  $.ajax({
    url:"json/map.json",
    cache:false,
    dataType:"json",
    success:function(json){
      var data=jsonRequest(json);
      initialize(data);
    }
  });
});

   // JSONファイル読み込み完了
function jsonRequest(json){
  var data=[];
  if(json.Marker){
    var n=json.Marker.length;
    for(var i=0;i<n;i++){
      data.push(json.Marker[i]);
    }
  }
  return data;
}
    
    
    
    
    
    console = null; // warningを表示しないようnullで(ry
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

// マップを生成して、複数のマーカーを追加
function initialize(data/*Array*/){
  var op={
    zoom:13,
    center:new google.maps.LatLng(34.67347038699344,135.44394850730896),
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
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
             '<p>'+dat.iframe+'</p>'+'<input type="text class=comment">'+
             '</div>'
        });
        
         google.maps.event.addListener(marker, 'click', createClickCallback(marker, infoWindow));
    }
    
     var geocoder = new google.maps.Geocoder();
            
            //createElementでdivを生成。
     var geolocationDiv = document.createElement('div');
            //GeolocationControlで現在地とる。jsのAPI
     var geolocationControl = new GeolocationControl(geolocationDiv, map);
            
            //submit押すとgeocoder発動。住所検索する
            document.getElementById('submit').addEventListener('click', function(){
             geocodeAddress(geocoder, map);
                
                
            })
            
            //現在地ボタン
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push
            (geolocationDiv); 
      
}
// ]]>
     //住所検索の関数
         function geocodeAddress(geocoder, resultsMap){
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
            
            //検索が可能なら
            if (status === google.maps.GeocoderStatus.OK) {
                resultsMap.setCenter(results[0].geometry.location);
                
                //２個目の検索マーカーを消す
                if(marker)
           	marker.setMap(null)
                
                 marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location,
                     zoom: 10
                    
//                    if(Marker){
//                    Marker.setMap(null)
//                };
                                                    
                                                    
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
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