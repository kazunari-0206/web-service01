<?php
$siteTitle = '商品出品登録';
require('head.php'); 
?>

  <body class="page-profEdit page-2colum page-logined">

    <!-- メニュー -->
    <?php
    require('header.php'); 
    ?>

    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">
      <h1 class="page-title">商品を出品する</h1>
      <!-- Main -->
      <section id="main" >
        <div class="form-container">
          <form action="mypage.html" class="form">
            <div class="area-msg">
              金額には数字を入力してください<br>
              商品名が長すぎます<br>
              詳細は500文字までです
            </div>
            <label>
              商品名
              <input type="text" name="name">
            </label>
            <label>
              カテゴリ
              <select name="category" id="">
                <option value="1">スマホ</option>
                <option value="2">自転車</option>
              </select>
            </label>
            <label>
              詳細
              <textarea name="comment" id="" cols="30" rows="10" style="height:150px;"></textarea>
            </label>
            <p class="counter-text">0/500文字</p>
            <label style="text-align:left;">
              金額
              <div class="form-group">
                <input type="text" name="price" style="width:150px" placeholder="50,000"><span class="option">円</span>
              </div>
            </label>
            <label>
              画像１
              <div class="area-drop">
                ここに画像をドラッグ＆ドロップ
              </div>
            </label>
            <label>
              画像２
              <div class="area-drop">
                ここに画像をドラッグ＆ドロップ
              </div>
            </label>
            <label>
              画像３
              <div class="area-drop">
                ここに画像をドラッグ＆ドロップ
              </div>
            </label>

            <div class="btn-container">
              <input type="submit" class="btn btn-mid" value="出品する">
            </div>
          </form>
        </div>
      </section>

      <!-- サイドバー -->
      <section id="sidebar">
        <a href="registProduct.html">商品を登録する</a>
        <a href="tranSale.html">販売履歴を見る</a>
        <a href="profEdit.html">プロフィール編集</a>
        <a href="passEdit.html">パスワード変更</a>
        <a href="withdraw.html">退会</a>
      </section>
    </div>

    <!-- footer -->
    <?php
    require('footer.php'); 
    ?>