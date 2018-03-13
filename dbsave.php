<?php
session_start();


// DBに接続
  require('dbconnect.php');

if(isset($_GET) && !empty($_GET["userID"]) && !empty($_GET["userName"]) && !empty($_GET["userEmail"]))
{
   $nick_name = $_GET["userName"];
   $email = $_GET["userEmail"];
   $password = $_GET["userID"];

   //$_SESSION['userID'] = $_GET['userID'];
    
     try {
         $sql = "SELECT COUNT(*) as `cnt` FROM `whereis_members` WHERE `email`=?";
         
         //sql文実行
 $data = array($email);
 $stmt = $dbh->prepare($sql);
 $stmt->execute($data);

 //件数とる
 $count = $stmt->fetch(PDO::FETCH_ASSOC);
         
          //重複エラー
     if ($count['cnt'] > 0) {
         // $_SESSION["id"] = $count['cnt'];
         
     $sql_member = "SELECT `id` FROM `whereis_members` WHERE `email`=?";
         
    $data = array($email);
    $stmt = $dbh->prepare($sql_member);
    $stmt->execute($data);
    $login_member = $stmt->fetch(PDO::FETCH_ASSOC);
         
    //mysqlでのuseridをセッションidにする     
    $_SESSION["id"] = $login_member["id"];
          
 }else{
         
         
  // DBに会員情報を登録するSQL文を作成
  // now() MYSQLが用意している関数。現在日時を取得できる
        $sql = "INSERT INTO `whereis_members` (`nick_name`, `email`, `password`, `created`, `modified`) VALUES (?,?,?,now(),now()) ";

  // SQL文実行
  // sha1 暗号化を行う関数
        $data = array($nick_name,$email,sha1($password));
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
         
         //新規ログインのidをセッションidにする
        $_SESSION["id"] = $dbh->lastInsertId('id');
             

         }

      } catch (Exception $e) {
        // tryで囲まれた処理でエラーが発生したときにやりたい処理を記述
        
        echo 'SQL実行エラー:' . $e->getMessage();
        exit();

      }
    
    
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>firebase with mysql</title>
</head>
<body>
    
</body>
</html>