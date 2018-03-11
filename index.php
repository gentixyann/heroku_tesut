<?php
//  session_start();


// // DBに接続
//   require('dbconnect.php');


// $url = parse_url(getenv("mysql://bff163e3ca75f8:c676bd1d@us-cdbr-iron-east-05.cleardb.net/heroku_02dda95d941a585?reconnect=true"));

//     $server = $url["us-cdbr-iron-east-05.cleardb.net"];
//     $username = $url["bff163e3ca75f8"];
//     $password = $url["c676bd1d"];
//     //$db = substr($url["heroku_02dda95d941a585"], 1);
//     $db = $url["heroku_02dda95d941a585"];

//     $link = mysqli_connect($server, $username, $password, $db);
//     $result = mysqli_query($link, "SELECT * FROM heroku_02dda95d941a585.user");

//     while($user = mysqli_fetch_array($result)) {
//       echo $user['id'], " : ", $user['name'], "<br>";
//       var_dump($user['id']);
//     }







$db = parse_url($_SERVER['mysql://bff163e3ca75f8:c676bd1d@us-cdbr-iron-east-05.cleardb.net/heroku_02dda95d941a585?reconnect=true']);
$db['dbname'] = ltrim($db['path'], '/');
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";

try {
    $db = new PDO($dsn, $db['user'], $db['pass']);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM user';
    $prepare = $db->prepare($sql);
    $prepare->execute();

    echo '<pre>';
    $prepare->execute();
    $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
    print_r(h($result));
    echo "\n";
    echo '</pre>';
} catch (PDOException $e) {
    echo 'Error: ' . h($e->getMessage());
}

function h($var)
{
    if (is_array($var)) {
        return array_map('h', $var);
    } else {
        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
    }
}



?>




