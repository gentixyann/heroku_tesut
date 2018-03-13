<?php

session_start();

//DBに接続
require('dbconnect.php');

function login_save(){
if (isset($_COOKIE["email"]) && !empty($_COOKIE["email"])) {
  $_POST["email"] = $_COOKIE["email"];
  $_POST["password"] = $_COOKIE["password"];
  //$_POST["save"] = "on";
}
    
    //POST送信されていたら認証処理
if (isset($_POST) && !empty($_POST)){
  //認証
  try{
    //メンバーズテーブルの中からメアドとパスワードが、入力されたものと合致する
    //データを取得
    $sql ="SELECT * FROM `whereis_members` WHERE `email`=? AND `password`=?";

    //sql実行 sha1は暗号化の種類
    $data = array($_POST["email"], sha1($_POST["password"]));
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    //一行取得
    $member = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($member);
    if($member == false){
      //認証失敗
      $error["login"] = "failed";
    }else{
      //認証成功
      //１、セッション変数に会員のidを保存
      $_SESSION["id"] = $member["member_id"];

      //２、ログインした時間をセッション変数に保存
      $_SESSION["time"] = time();

      //３、自動ログイン
      //if ($_POST["save"] == 'on') {
        //クッキーにログイン情報記録
        //setcookie(保存したい名前、保存したい値、保存したい期間 : 秒数)。この場合２週間保存
        setcookie('email', $_POST["email"], time()+60*60*24*14);
        setcookie('password', $_POST["password"], time()+60*60*24*14);
     // }

      //４、ログイン後の画面移動
      header("Location: json_map.php");
      exit();
    }

  }catch(Exception $e){

  }
} 
}


function logout(){
    //セッションの中身を空の配列で上書きする
$_SESSION = array();

//セッション情報を有効期限切れにする
if (ini_get("session.use_cookies")) {
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'],
    $params['secure'], $params['httponly']);
}

//セッション情報の破棄
session_destroy();

//cookie情報も削除
setcookie('email','',time() - 3000);
setcookie('password','',time() - 3000);

//ログイン後の画面に戻る
header("Location: index.php");
exit();
}




// ログインチェックを行う関数
function login_check(){

   if (isset($_SESSION['id'])) {
    // ログインしている状態

  }else{
    // ログインしていない
    // ログイン画面に飛ばす
    header("Location: index.php");
    exit();

  }
}

?>