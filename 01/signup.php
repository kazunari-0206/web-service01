<?php

require('function.php');

//post送信されていた場合
if(!empty($_POST)) {

  //変数にユーザー情報を代入
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $pass_re = $_POST['pass_re'];

  //未入力チェック
  validRepuired($email, 'email');
  validRepuired($pass, 'pass');
  validRepuired($pass_re, 'pass_re');

  if(empty($err_msg)) {
  
    // emailの型式チェック
    validEmail($email, 'email');
    // emailの最大文字数チェック
    validMaxLen($email, 'email');
    // email重複チェック
    validEmailDup($email);

    // パスワードの半角英数字チェック
    validHalf($pass, 'pass');
    // パスワード最大文字数チェック
    validMaxLen($pass, 'pass');
    // パスワード最小文字数チェック
    validMinLen($pass, 'pass');

    if(empty($err_msg)) {
      // パスワードとパスワード再入力が合っているかチェック
      validMatch($pass, $pass_re, 'pass_re');

      if(empty($err_msg)) {

        //例外処理
        try {
          // DBへ接続
          $dbh = dbConnect();
          // SQL文作成
          $sql = 'INSERT INTO users (email, password, login_time, create_date) VALUES(:email, :pass, :login_time, :create_date)';
          $data = array(':email'=>$email, ':pass'=>password_hash($pass, PASSWORD_DEFAULT),
                                  ':login_time'=> date('Y-m-d H:i:s'),
                                  ':create_date'=> date('Y-m-d H:i:s'));
          // クエリ実行
          queryPost($dbh, $sql, $data);

          header("Location:mypage.html"); //マイページへ

        } catch (Exception $e) {
          error_log('エラー発生:' . $e->getMessage());
          $err_msg['common'] = MSG07;
        }
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録 | WEBKATU MARKET</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Montserrat:400,700">
</head>

<body class="page-signup page-1colum">

  <!-- メニュー -->
  <header>
    <div class="site-width">
      <h1><a href="index.html">WEBKATU MARKET</a></h1>
      <nav id="top-nav">
        <ul>
          <li><a href="signup.php" class="btn btn-primary">ユーザー登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- メインコンテンツ -->
  <div id="contents" class="site-width">

    <!-- Main -->
    <section id="main">

      <div class="form-container">
        
        <form action="" method="post" class="form">
          <h2 class="title">ユーザー登録</h2>
          <div class="area-msg">
            <?php 
            if(!empty($err_msg['common'])) echo $err_msg['common']; 
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['email'])) echo 'err'; ?>">
            Email
            <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
          </label>
          <div class="area-msg">
            <?php
            if(!empty($err_msg['email'])) echo $err_msg['email'];
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['pass'])) echo 'err' ?>">
            パスワード <span style="font-size: 12px;">※英数字6文字以上</span>
            <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass'] ?>">
          </label>
          <div class="area-msg">
            <?php
            if(!empty($err_msg['pass'])) echo $err_msg['pass'];
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['pass_re'])) echo 'err'; ?>">
            パスワード（再入力）
            <input type="password" name="pass_re" value="<?php if(!empty($_POST['pass_re'])) echo $_POST['pass_re']; ?>">
          </label>
          <div class="area-msg">
            <?php
            if(!empty($err_msg['pass_re'])) echo $err_msg['pass_re'];
            ?>
          </div>
          <div class="btn-container">
            <input type="submit" class="btn btn-mid" value="登録する">
          </div>
        </form>

      </div>

    </section>

  </div>

  <!-- footer -->
  <footer id="footer">
    Copyright <a href="http://webukatu.com/">ウェブカツ!!WEBサービス部</a>.All Rights Reserved.
  </footer>
  
  <!-- jquery読み込み -->
  <script src="js/vendor/jquery-2.2.2.min.js"></script>
  <!-- フッターを固定するjavascript追加 -->
  <script>
    $(function(){
      var $ftr = $('#footer');
      if(window.innerHeight > $ftr.offset().top + $ftr.outerHeight()){
        $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) + 'px;' });
      }
    })
  </script>
</body>
</html>