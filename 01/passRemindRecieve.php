<?php
$siteTitle = 'パスワード再発行認証';
require('head.php'); 
?>

  <body class="page-signup page-1colum">

    <!-- メニュー -->
    <?php
      require('header.php'); 
    ?>

    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">

      <!-- Main -->
      <section id="main" >

        <div class="form-container">

          <form action="passEdit.php" class="form">
            <p>ご指定のメールアドレスお送りした【パスワード再発行認証メール】内にある「認証キー」をご入力ください。</p>
            <div class="area-msg">
              認証キーが違います
            </div>
            <label>
              認証キー
              <input type="text" name="token">
            </label>
            <div class="btn-container">
              <input type="submit" class="btn btn-mid" value="変更画面へ">
            </div>
          </form>
        </div>
        <a href="passRemindSend.php">&lt; パスワード再発行メールを再度送信する</a>
      </section>

    </div>

    <!-- footer -->
    <?php
    require('footer.php'); 
    ?>