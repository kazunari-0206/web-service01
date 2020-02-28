<?php
$siteTitle = 'プロフィール編集';
require('head.php'); 
?>

  <body class="page-profEdit page-2colum page-logined">

    <!-- メニュー -->
    <?php
    require('header.php'); 
    ?>

    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">
      <h1 class="page-title">プロフィール編集</h1>
      <!-- Main -->
      <section id="main" >
        <div class="form-container">
          <form action="" method="post" class="form">
            <div class="area-msg">
              <?php
              if(!empty($err_msg['common'])) echo $err_msg['common'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['username'])) echo 'err'; ?>">
              名前
              <input type="text" name="username" value="<?php getFormData('username'); ?>">
            </label>
            <div class="area-msg">
              <?php
              if(!empty($err_msg['username'])) echo $err_msg['username'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['tel'])) echo 'err' ?>">
              TEL<span style="font-size:12px;margin-left:5px;">※ハイフン無しでご入力ください</span>
              <input type="text" name="tel" value="<?php getFormData('tel'); ?>">
            </label>
            <div class="area-msg">
              <?php
              if(!empty($err_msg['tel'])) echo $err_msg['tel'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['zip'])) echo 'err' ?>">
              郵便番号<span style="font-size:12px;margin-left:5px;">※ハイフン無しでご入力ください</span>
              <input type="text" name="zip" value="<?php if(!empty(getFormData('zip'))) { echo getFormData('zip');} ?>">
            </label>
            <div class="area-msg">
              <?php
              if(!empty($err_msg['zip'])) echo $err_msg['zip'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['addr'])) echo 'err' ?>">
              住所
              <input type="text" name="addr" value="<?php getFormData('addr'); ?>">
            </label>
            <div class="area-msg">
              <?php
              if(!empty($err_msg['addr'])) echo $err_msg['addr'];
              ?>
            </div>
            <label style="text-align:left;" class="<?php if(!empty($err_msg['age'])) echo 'err' ?>">
              年齢
              <input type="number" name="age" value="<?php getFormData('age'); ?>">
            </label>
            <div class="area-msg">
              <?php
              if(!empty($err_msg['age'])) echo $err_msg['age'];
              ?>
            </div>
            <label class="<?php if(!empty($err_msg['email'])) echo 'err' ?>">
              Email
              <input type="text" name="email" value="<?php getFormData('email'); ?>">
            </label>
            <div class="area-msg">
              <?php
              if(!empty($err_msg['email'])) echo $err_msg['email'];
              ?>
            </div>
            
            <div class="btn-container">
              <input type="submit" class="btn btn-mid" value="変更する">
            </div>
          </form>
        </div>
      </section>
      
      <!-- サイドバー -->
      <?php
      require('sidebar_mypage.php');
      ?>
    </div>

    <!-- footer -->
    <?php
    require('footer.php'); 
    ?>
