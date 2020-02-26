<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン | WEBKATU MARKET</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Montserrat:400,700">
</head>

<body class="page-login page-1colum">

  <!-- メニュー -->
  <header>
    <div class="site-width">
      <h1><a href="index.html">WEBKATU MARKET</a></h1>
      <nav id="top-nav">
        <ul>
          <li><a href="signup.php" class="btn btn-primary">ユーザー登録</a></li>
          <li><a href="login.html">ログイン</a></li>
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
          <h2 class="title">ログイン</h2>
          <div class="area-msg">
            <?php
            if((!empty($err_msg['common']))) echo $err_msg['common'];
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['email'])) echo 'err' ?>">
            メールアドレス
            <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
          </label>
          <div class="area-msg">
            <?php
            if((!empty($err_msg['email']))) echo $err_msg['email'];
            ?>
          </div>
          <label class="<?php if(!empty($err_msg['pass'])) echo 'err' ?>">
            パスワード
            <input type="password" name="pass" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
          </label>
          <div class="area-msg">
            <?php
            if((!empty($err_msg['pass']))) echo $err_msg['pass'];
            ?>
          </div>
          <label>
            <input type="checkbox" name="pass_save">次回ログインを省略する
          </label>
          <div class="btn-container">
            <input type="submit" class="btn btn-mid" value="ログイン">
          </div>
            パスワードを忘れた方は<a href="passRemindsend.html">コチラ</a>
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