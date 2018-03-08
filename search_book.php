<?php
  // var_dump($_POST["keyword"]);

  if (isset($_POST["keyword"]) && !empty($_POST["keyword"])){

    //APIへアクセスするURLを作成
    //キーワードをurlエンコードして、urlの一部に結合
    $url = "https://www.googleapis.com/books/v1/volumes?q=".urlencode($_POST["keyword"]);

    //APIを叩いてJSON形式で検索結果を取得
    $json = file_get_contents($url);

    //文字化け対策
    $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    
    //配列に変換（trueを付けないとオブジェクト型、つけると配列型になる）
    $array = json_decode($json, true);
  }

?>
<!DOCTYPE html>
<html>
<head>
  <title>GoogleAPIで本検索</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-xs-6 col-xs-offset-3">
       <h1>読みたい本を検索</h1>
       <form method="post" action="">
       <div class="input-group">
        <input name="keyword" type="text" class="form-control" placeholder="Search for...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
        </span>
      </div>
      </form>
    </div>
    <div class="col-xs-3"></div>
  </div><!-- row -->
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2">
      <p>
      <ul>
        <li>検索結果をここに表示</li>
      </ul>
      <pre>
      <?php
         var_dump($array);
      ?>
      </pre>
      </p>
    </div>
  </div>
</div><!-- container -->

<script
  src="https://code.jquery.com/jquery-1.11.2.min.js"
  integrity="sha256-Ls0pXSlb7AYs7evhd+VLnWsZ/AqEHcXBeMZUycz/CcA="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>