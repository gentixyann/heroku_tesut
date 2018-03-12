<?php
//  session_start();


// // DBに接続
  //require('dbconnect.php');



$url = parse_url(getenv("mysql://bff163e3ca75f8:c676bd1d@us-cdbr-iron-east-05.cleardb.net/heroku_02dda95d941a585?reconnect=true"));

$server = $url["us-cdbr-iron-east-05.cleardb.net"];
$username = $url["bff163e3ca75f8"];
$password = $url["c676bd1d"];
$db = substr($url["heroku_02dda95d941a585"], 1);

$conn = new mysqli($server, $username, $password, $db);


$conn->query();
$sql = 'select * from user';
//$stmt = $dbh->prepare($sql);
$stmt = $conn->prepare($sql);
  $stmt->execute();


// $url = parse_url(getenv("mysql://bff163e3ca75f8:c676bd1d@us-cdbr-iron-east-05.cleardb.net/heroku_02dda95d941a585?reconnect=true"));

//     $server = $url["us-cdbr-iron-east-05.cleardb.net"];
//     $username = $url["bff163e3ca75f8"];
//     $password = $url["c676bd1d"];
//     $db = substr($url["heroku_02dda95d941a585"], 1);
//     //$db = $url["heroku_02dda95d941a585"];

//     $link = mysqli_connect($server, $username, $password, $db);
//     $result = mysqli_query($link, "select * from user");



//   // DB接続オブジェクト
//   $dbh = new PDO($dsn, $user, $password);

//   // 例外処理を使用可能にする方法（エラー文を表示することが出来る）
//   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// // 今から実行するSQL文を文字コードutf8で
//  $dbh->query('SET NAMES utf8');


var_dump();
//     while($user = mysqli_fetch_array($result)) {
//       echo $user['id'], " : ", $user['name'], "<br>";
//       var_dump($user['id']);
// //     }



?>




