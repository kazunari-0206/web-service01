<?php
$siteTitle = 'パスワード変更';
require('head.php'); 
?>

  <body class="page-passEdit page-2colum page-logined">
    <style>
      .form{
        margin-top: 50px;
      }
    </style>
    
    <!-- メニュー -->
    <?php
      require('header.php'); 
    ?>

    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">
      <h1 class="page-title">パスワード変更</h1>
      <!-- Main -->
      <section id="main" >
        <div class="form-container">
          <form action="" class="form">
           <div class="area-msg">
             古いパスワードが正しくありません。<br>
             新しいパスワードと新しいパスワード（再入力）が一致しません。<br>
             新しいパスワードは半角英数字6文字以上で入力してください。<br>
             パスワードが長すぎます。
           </div>
            <label>
              古いパスワード
              <input type="text" name="pass_old">
            </label>
            <label>
              新しいパスワード
              <input type="text" name="pass_new">
            </label>
            <label>
              新しいパスワード（再入力）
              <input type="text" name="pass_new_re">
            </label>
            <div class="btn-container">
              <input type="submit" class="btn btn-mid" value="変更する">
            </div>
          </form>
        </div>
      </section>
      
      <!-- サイドバー -->
      <?php
      require('sidebar_mypage');
      ?>
    </div>

    <!-- footer -->
    <?php
    require('footer.php'); 
    ?>
