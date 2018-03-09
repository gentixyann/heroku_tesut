<?php


$dsn = 'mysql:dbname=ytmap;host=localhost';

//$user データベース接続用ユーザー $password そのパスワード
$user = 'root';
$password='root';


////本番環境
//$dsn = 'mysql:dbname=LAA0918693-phpkiso;host=mysql103.phy.lolipop.lan';
//
////$user データベース接続用ユーザー $password そのパスワード
//$user = 'LAA0918693';
//$password='gengen210';




//データベース接続オブジェクト
$dbh = new PDO($dsn, $user, $password);

//例外処理を使用可能にする方法(エラーを表示する)
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//今から実行するSQL文字コードutf-8で送る設定
$dbh->query('SET NAMES utf8');


?>