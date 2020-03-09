<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug(' 連絡掲示板 ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

//================================
// 画面処理
//================================


$siteTitle = '連絡掲示板';
require('head.php'); 
?>

  <body class="page-msg page-1colum">
    <style>

      /* 連絡掲示板 */
      .msg-info{
        background: #f6f5f4;
        padding: 15px;
        overflow: hidden;
        margin-bottom: 15px;
      }
      .msg-info .avatar{
        width: 80px;
        height: 80px;
        border-radius: 40px;
      }
      .msg-info .avatar-img{
        text-align: center;
        width: 100px;
        float: left;
      }
      .msg-info .avatar-info{
        float: left;
        padding-left: 15px;
        width: 500px;
      }
      .msg-info .product-info{
        float: left;
        padding-left: 15px;
        width: 315px;
      }
      .msg-info .product-info .left,
      .msg-info .product-info .right{
        float: left;
      }
      .msg-info .product-info .right{
        padding-left: 15px;
      }
      .msg-info .product-info .price{
        display: inline-block;
      }
      .area-bord{
        height: 500px;
        overflow-y: scroll;
        background: #f6f5f4;
        padding: 15px;
      }
      .area-send-msg{
        background: #f6f5f4;
        padding: 15px;
        overflow: hidden;
      }
      .area-send-msg textarea{
        width:100%;
        background: white;
        height: 100px;
        padding: 15px;
      }
      .area-send-msg .btn-send{
        width: 150px;
        float: right;
        margin-top: 0;
      }
      .area-bord .msg-cnt{
        width: 80%;
        overflow: hidden;
        margin-bottom: 30px;
      }
      .area-bord .msg-cnt .avatar{
        width: 5%;
        overflow: hidden;
        float: left;
      }
      .area-bord .msg-cnt .avatar img{
        width: 40px;
        height: 40px;
        border-radius: 20px;
        float: left;
      }
      .area-bord .msg-cnt .msg-inrTxt{
        width: 85%;
        float: left;
        border-radius: 5px;
        padding: 10px;
        margin: 0 0 0 25px;
        position: relative;
      }
      .area-bord .msg-cnt.msg-left .msg-inrTxt{
        background: #f6e2df;
      }
      .area-bord .msg-cnt.msg-left .msg-inrTxt > .triangle{
        position: absolute;
        left: -20px;
        width: 0;
        height: 0;
        border-top: 10px solid transparent;
        border-right: 15px solid #f6e2df;
        border-left: 10px solid transparent;
        border-bottom: 10px solid transparent;
      }
      .area-bord .msg-cnt.msg-right{
        float: right;
      }
      .area-bord .msg-cnt.msg-right .msg-inrTxt{
        background: #d2eaf0;
        margin: 0 25px 0 0;
      }
      .area-bord .msg-cnt.msg-right .msg-inrTxt > .triangle{
        position: absolute;
        right: -20px;
        width: 0;
        height: 0;
        border-top: 10px solid transparent;
        border-left: 15px solid #d2eaf0;
        border-right: 10px solid transparent;
        border-bottom: 10px solid transparent;
      }
      .area-bord .msg-cnt.msg-right .msg-inrTxt{
        float: right;
      }
      .area-bord .msg-cnt.msg-right .avatar{
        float: right;
      }
    </style>

    <!-- メニュー -->
    <?php
      require('header.php'); 
    ?>

    <p id="js-show-msg" style="display:none;" class="msg-slide">
      <?php echo getSessionFlash('msg_success'); ?>
    </p>


    <!-- メインコンテンツ -->
    <div id="contents" class="site-width">
      <!-- Main -->
      <section id="main" >
        <div class="msg-info">
          <div class="avatar-img">
            <img src="img/avatar.png" alt="" class="avatar"><br>
          </div>
          <div class="avatar-info">
            山田　太郎　33歳<br>
            〒111-11111<br>
            東京都墨田区◯◯◯１−１−１◯◯◯マンション１３０３号室<br>
            TEL：000-0000-0000
          </div>
          <div class="product-info">
            <div class="left">
              取引商品<br>
              <img src="img/sample01.jpg" alt="" height="70px" width="auto" >
            </div>
            <div class="right">
              iPhone6s<br>
              取引金額：<span class="price">¥87,000</span><br>
              取引開始日：2016/00/00
            </div>
          </div>
        </div>
        <div class="area-bord" id="js-scroll-bottom">
          <div class="msg-cnt msg-left">
            <div class="avatar">
              <img src="img/avatar2.jpg" alt="" class="avatar">
            </div>
            <p class="msg-inrTxt">
              <span class="triangle"></span>
              サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキスト
            </p>
          </div>
          <div class="msg-cnt msg-right">
            <div class="avatar">
              <img src="img/avatar.png" alt="" class="avatar">
            </div>
            <p class="msg-inrTxt">
              <span class="triangle"></span>
              サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキ
            </p>
          </div>
          <div class="msg-cnt msg-left">
            <div class="avatar">
              <img src="img/avatar2.jpg" alt="" class="avatar">
            </div>
            <p class="msg-inrTxt">
              <span class="triangle"></span>
              サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサ
            </p>
          </div>
          <div class="msg-cnt msg-right">
            <div class="avatar">
              <img src="img/avatar.png" alt="" class="avatar">
            </div>
            <p class="msg-inrTxt">
              <span class="triangle"></span>
              サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキ
            </p>
          </div>
          <div class="msg-cnt msg-left">
            <div class="avatar">
              <img src="img/avatar2.jpg" alt="" class="avatar">
            </div>
            <p class="msg-inrTxt">
              <span class="triangle"></span>
              サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサ
            </p>
          </div>
          <div class="msg-cnt msg-right">
            <div class="avatar">
              <img src="img/avatar.png" alt="" class="avatar">
            </div>
            <p class="msg-inrTxt">
              <span class="triangle"></span>
              サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキ
            </p>
          </div>
          <div class="msg-cnt msg-left">
            <div class="avatar">
              <img src="img/avatar2.jpg" alt="" class="avatar">
            </div>
            <p class="msg-inrTxt">
              <span class="triangle"></span>
              サンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサンプルテキストサ
            </p>
          </div>
        </div>
        <div class="area-send-msg">
          <textarea name="" id="" cols="30" rows="3"></textarea>
          <input type="submit" value="送信" class="btn btn-send">
        </div>
      </section>
      
      <script src="js/vendor/jquery-2.2.2.min.js"></script>
      
      <script>
        $(function(){
          $('#js-scroll-bottom').animate({scrollTop: $('#js-scroll-bottom')[0].scrollHeight}, 'fast');
        });
      </script>

    </div>

    <!-- footer -->
    <?php
      require('footer.php'); 
    ?>
