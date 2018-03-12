<?php
//  session_start();


// // DBに接続
require('dbconnect.php');



// $url = parse_url(getenv("mysql://bff163e3ca75f8:c676bd1d@us-cdbr-iron-east-05.cleardb.net/heroku_02dda95d941a585?reconnect=true"));

// $server = $url["us-cdbr-iron-east-05.cleardb.net"];
// $username = $url["bff163e3ca75f8"];
// $password = $url["c676bd1d"];
// $db = substr($url["heroku_02dda95d941a585"], 1);

// $conn = new mysqli($server, $username, $password, $db);

try{

$sql = 'select * from whereis_map';
$stmt = $dbh->prepare($sql);
$stmt->execute();

 $marker_info["Markers"] = array();
while(1){
$marker_data = $stmt->fetch(PDO::FETCH_ASSOC);
 $marker_info["Markers"][] = $marker_data;
//     $link = mysqli_connect($server, $username, $password, $db);
//     $result = mysqli_query($link, "select * from user");

if ($marker_data == false){
         break;//中断する
     }else{            
    $json = json_encode($marker_info, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); 
        var_dump($json);
   }


}
//     while($user = mysqli_fetch_array($result)) {
//       echo $user['id'], " : ", $user['name'], "<br>";
//       var_dump($user['id']);
// //     }

}catch(Exception $e){

  }

?>




