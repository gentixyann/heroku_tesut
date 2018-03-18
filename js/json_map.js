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
    
   
// マップを生成して、複数のマーカーを追加
function initialize(data/*Array*/){
  var op={
        
    zoom:5,
    //center:new google.maps.LatLng(34.67347038699344,135.44394850730896),
      
     center:new google.maps.LatLng(randomLat.toFixed(6),randomLng.toFixed(6)),
    
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
            
            //submit押すとgeocoder発動。住所検索する
            document.getElementById('submit').addEventListener('click', function(){
             geocodeAddress(geocoder, map);
                
                
            })
            
            //現在地ボタン
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push
            (geolocationDiv); 
}



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
    