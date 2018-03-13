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
       em
       
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

        <script type="text/javascript">
            var map;
            var marker = "";
            var randomLat = Math.random()*140 - 70;   
            var randomLng = Math.random()*360 - 180;
            /* 初期設定 */
            function initialize() {
                var Marker;

                /* 初期表示の緯度経度*/
                var latlng = new google.maps.LatLng(randomLat.toFixed(6),randomLng.toFixed(6));
                /* 地図のオプション */
                var myOptions = {
                    /*初期のズーム レベル */
                    zoom: 6,
                    /* 地図の中心 */
                    center: latlng,
                    /* 地図タイプ */
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                /* 地図オブジェクト */
                map = new google.maps.Map(document.getElementById("map"), myOptions);
                //review();

                Marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });

                //地図上でクリックするとマーカー登場。マーカーを移動可能にするイベント登録
                google.maps.event.addListener(map, 'click',
                    function(event) {

                        // //setMap()はMarkerクラスのメソッド。引数nullでマーカー削除
                        if (Marker) {
                            Marker.setMap(null)
                        };

                        //クリックで出現するマーカー設定
                        var icon = new google.maps.MarkerImage('img/click_icon.png',
                            new google.maps.Size(73, 51),
                            new google.maps.Point(0, 0),
                            //クリックした所と出現するマーカーのズレを無くす為
                            new google.maps.Point(15, 30)
                        );

                        //新しいマーカーはこっちで用意したマーカー(icon)に指定
                        Marker = new google.maps.Marker({
                            icon: icon,
                            position: event.latLng,
                            draggable: true,
                            map: map
                        });

                        infotable(
                            Marker.getPosition().lat(),
                            Marker.getPosition().lng(),
                            map.getZoom());


                        geocode();
                        //マーカー移動後に座標を取得するイベントの登録
                        google.maps.event.addListener(Marker, 'dragend',
                            function(event) {
                                infotable(
                                    Marker.getPosition().lat(),
                                    Marker.getPosition().lng(),
                                    map.getZoom());
                                geocode();



                            })


                        //ズーム変更後に倍率を取得するイベントの登録
                        google.maps.event.addListener(map, 'zoom_changed',
                            function(event) {
                                infotable(
                                    Marker.getPosition().lat(),
                                    Marker.getPosition().lng(),
                                    map.getZoom());
                            })
                    })

                //マーカーの位置を地図座標に変換するジオコーディングの設定
                function geocode() {
                    var geocoder = new google.maps.Geocoder();

                    geocoder.geocode({
                            'location': Marker.getPosition()
                        },
                        function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK && results[0]) {
                                document.getElementById('id_address').innerHTML =
                                    results[0].formatted_address.replace(/^日本, /, '');

                                //consoleに出す
                                console.log(Marker.getPosition().lat());
                                console.log(Marker.getPosition().lng());
                                console.log(results[0].formatted_address.replace(/^日本, /, ''));

                                //inputに表示
                                document.getElementById('map_lat').value = Marker.getPosition().lat();
                                document.getElementById('map_lng').value = Marker.getPosition().lng();
                                document.getElementById('map_address').value = results[0].formatted_address.replace(/^日本, /, '');


                            } else {
                                document.getElementById('id_address').innerHTML =
                                    "Geocode 取得に失敗しました";
                                alert("Geocode 取得に失敗しました reason: " +
                                    status);
                            }
                        });

                    //submit押されるとgeocodeAddresse関数発動
                    document.getElementById('submit').addEventListener('click', function() {
                        geocodeAddress(geocoder, map);
                    });
                }

                //HTMLtag更新
                function infotable(ido, keido, level) {

                    //document.getElementById('id_ido').innerHTML = ido;
                    //document.getElementById('id_keido').innerHTML = keido;

                };

                var geocoder = new google.maps.Geocoder();

                //createElementでdivを生成。
                var geolocationDiv = document.createElement('div');
                //GeolocationControlで現在地とる。jsのAPI
                var geolocationControl = new GeolocationControl(geolocationDiv, map);

                //submit押すとgeocoder発動。住所検索する
                document.getElementById('submit').addEventListener('click', function() {
                    geocodeAddress(geocoder, map);
                })

                //現在地ボタン
                map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(geolocationDiv);

            } //initialize()終わり

            //住所検索の関数
            function geocodeAddress(geocoder, resultsMap) {
                var address = document.getElementById('address').value;
                geocoder.geocode({
                    'address': address
                }, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        resultsMap.setCenter(results[0].geometry.location);

                        //２個目の検索マーカーを消す
                        if (marker)
                            marker.setMap(null)

                        marker = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location
                        });

                        //inputに表示
                        console.log(marker.position.lat());
                        console.log(marker.position.lng());
                        //console.log(results[0].geometry.location);
                        console.log(results[0].formatted_address.replace(/^日本, /, ''));

                        document.getElementById('map_lat').value = marker.position.lat();
                        document.getElementById('map_lng').value = marker.position.lng();
                        //document.getElementById('map_address').value = results[0].geometry.location;
                        document.getElementById('map_address').value = results[0].formatted_address.replace(/^日本, /, '');



                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

            function GeolocationControl(controlDiv, map) {

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

                //controlUIクリックしたらgeolocate関数発動
                google.maps.event.addDomListener(controlUI, 'click', geolocate);
            }

            //現在地ボタン押した時のgeolocate
            function geolocate() {

                if (navigator.geolocation) {

                    navigator.geolocation.getCurrentPosition(function(position) {

                        //緯度経度を現在地にする
                        var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                        // 現在地にマーカー置く
                        marker = new google.maps.Marker({
                            position: pos,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            map: map
                        });

                        //座標をセット。１番目の引数には設定する中心座標
                        map.setCenter(pos);
                    });
                } else {
                    //Geolocation API使えん
                    handleLocationError(false, map.getCenter());
                }
            }



            function review() {
                var objname = (chk()) ? "svp" : "map";
                if (objname == "map") {
                    document.getElementById("svp").style.display = "none";
                } else {
                    document.getElementById("svp").style.display = "block";
                }
                //ストリートビューパノラマ表示 
                var svp = new google.maps.StreetViewPanorama(
                    document.getElementById(objname), {
                        position: map.getCenter()
                    });
                map.setStreetView(svp);
            }
            //チェック
            function chk() {
                var obj = document.getElementsByName("svp");
                for (var i = 0; i < obj.length; i++) {
                    if (obj[i].checked) {
                        return parseInt(obj[i].value);
                    }
                }
            }
            // ロード時に初期化 
            google.maps.event.addDomListener(window, 'load', initialize);

        </script>

    </body>

    </html>
