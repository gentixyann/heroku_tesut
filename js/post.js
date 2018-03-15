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