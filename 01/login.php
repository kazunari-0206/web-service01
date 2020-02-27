<?php

//共通変数・関数ファイルを読み込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「 ログインページ ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//ログイン認証
require('auth.php');

//================================
// ログイン画面処理
//================================
// post送信されていた場合
if(!empty($_POST)) {
  debug('POST送信があります。');

  // 変数にユーザー情報を代入
  $email = $_POST['email'];
  $pass = $_POST['pass'];
  $pass_save = (!empty($_POST['pass_save'])) ? true : false; //ショートハンド（略記法）という 三項演算子

  //未入力チェック
  validRequired($email, 'email');
  validRequired($pass, 'pass');
  
  // emailの形式チェック
  validEmail($email, 'email');
  // emailの最大文字数チェック
  validMaxLen($email, 'email');
  
  // パスワードの半角英数字チェック
  validHalf($pass, 'pass');
  // パスワードの最大文字数チェック
  validMaxLen($pass, 'pass');
  // パスワードの最小文字数チェック
  validMinLen($pass, 'pass');
  
  if(empty($err_msg)) {
    debug('バイデーションOKです。');
  
    //例外処理
    try {
      // DBへ接続
      $dbh = dbConnect();
      // SQL文作成
      $sql = 'SELECT password,id FROM users WHERE email = :email';
      $data = array(':email' => $email);
      // クエリ実行
      $stmt = queryPost($dbh, $sql, $data);
      // クエリ結果の値を取得
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
      debug('クエリ結果の中身: ' . print_r($result, true));
  
      // パスワード照合 password_verify関数はパスワード(第一引数)がハッシュ化されたパスワード(第二引数)とマッチするか
      if(!empty($result) && password_verify($pass, array_shift($result))) {
        debug('パスワードがマッチしました。');
  
        // ログイン有効期限（デフォルトを1時間とする）
        $sesLimit = 60*60;
        // 最終ログイン日時を現在日時に
        $_SESSION['login_date'] = time(); // time関数は1970年1月1日 00:00:00 を0として、1秒経過するごとに1ずつ増加させた値が入る(タイムスタンプ)
  
        // ログイン保持にチェックがある場合
        if($pass_save) {
          debug('ログイン保持にチェックがあります。');
          // ログイン有効期限を30日にしてセット
          $_SESSION['login_limit'] = $sesLimit * 24 *30;
        } else {
          debug('ログイン保持にチェックはありません。');
          // ログイン保持しないので、ログイン有効期限を1時間後にセット
          $_SESSION['login_limit'] = $sesLimit;
        }
        // ユーザーIDを格納
        $_SESSION['user_id'] = $result['id'];
  
        debug('セッション変数の中身 :' . print_r($_SESSION, true));
        debug('マイページへ遷移します。');
        header("Location:mypage.html"); //マイページへ
      } else {
        debug('パスワードがアンマッチです');
        $err_msg['common'] = MSG09;
      }
    } catch (Exception $e) {
      error_log('エラー発生 :' . $e->getMessage());
      $err_msg['common'] = MSG07;
    }
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<')
?>


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