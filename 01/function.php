<?php
//================================
// ログ
//================================
//E_STRCTレベル以外のエラーを報告する
error_reporting(E_ALL); 
//画面にエラーを表示させるか
ini_set('display_errors','On'); 
//ログを取るか
ini_set('log_errors','on');
//ログの出力ファイルを指定
ini_set('error_log','php.log');


//================================
// デバッグ
//================================
// デバッグフラグ
$debug_flg = true;
//デバッグログ関数
function debug($str){
  global $debug_flg;
  if(!empty($debug_flg)){
    error_log('デバッグ : ' . $str);
  }
}

//================================
// セッション準備・セッション有効期限を伸ばす
//================================
//セッションファイルの置き場を変更する（/var/tmp/以下に置くと30日は削除されない）
session_save_path("/var/tmp/");
//ガーベージコレクションが削除するセッションの有効期限を設定（30日以上経っているものに対してだけ100分の1の確率で削除）
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);
//ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
//セッションをつかう
session_start();
//現在のセッションIDを新しく生成したものと置き換える（なりすましのセキュリティ対策）
session_regenerate_id();

//================================
// 画面表示処理開始ログ吐き出し関数
//================================
function debugLogStart(){
  debug('>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示開始');
  debug('セッションID :' . session_id());
  debug('セッション変数の中身 :' . print_r($_SESSION, true));
  debug('現在日時タイムスタンプ :' . time());
  if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
    debug('ログイン期限日時タイムスタンプ :' . ($_SESSION['login_date'] + $_SESSION['login_limit']));
  }
}

//================================
// 定数
//================================
//エラーメッセージを定数に設定
define('MSG01', '入力必須です');
define('MSG02', 'Emailの形式で入力してください');
define('MSG03', 'パスワード（再入力）が合っていません');
define('MSG04', '半角英数字のみご利用いただけます');
define('MSG05', '6文字以上で入力してください');
define('MSG06', '255文字以内で入力してください');
define('MSG07', 'エラーが発生しました。しばらく経ってからやり直してください。');
define('MSG08', 'そのEmailは既に登録されています');
define('MSG09', 'メールアドレスまたはパスワードが違います'); //必ずメールアドレスまたはパスワードとあいまいにする
define('MSG10', '電話番号の形式が違います'); 
define('MSG11', '郵便番号の形式が違います'); 
define('MSG12', '古いパスワードが違います'); 
define('MSG13', '古いパスワードと同じです'); 
define('MSG14', '文字で入力してください'); 
define('MSG15', '正しくありません'); 
define('MSG16', '有効期限が切れています'); 
define('MSG17', '半角数字のみご利用いただけます'); 
define('SUC01', 'パスワードを変更しました'); 
define('SUC02', 'プロフィールを変更しました'); 
define('SUC03', 'メールを送信しました'); 
define('SUC04', '登録しました'); 

//================================
// グローバル変数
//================================
//エラーメッセージ格納用の配列
$err_msg = array();

//================================
// バリデーション関数
//================================
//バリデーション関数（未入力チェック）
function validRequired($str, $key){
  if(empty($str)){
    global $err_msg;
    $err_msg[$key] = MSG01;
  }
}
//バリデーション関数（Email形式チェック）
function validEmail($str, $key){
  if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)) {
    global $err_msg;
    $err_msg[$key] = MSG02;
  }
}
//バリデーション関数（Email重複チェック）
function validEmailDup($email){
  global $err_msg;
  //例外処理
  try{
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT count(*) FROM users WHERE email = :email AND delete_flg = 0';
    $data = array(':email' => $email);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);
    // クエリ結果の値を取得
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //array_shift関数は配列の先頭を取り出す関数です。クエリ結果は配列形式で入っているので、array_shiftで１つ目だけ取り出して判定します
    if(!empty(array_shift($result))){
      $err_msg['email'] = MSG08;
    }
  } catch (Exception $e){
    error_log('エラー発生 :' . $e->getMessage());
    $err_msg['common'] = MSG07;
  }
}
//バリデーション関数（同値チェック）
function validMatch($str1, $str2, $key){
  if($str1 !== $str2){
    global $err_msg;
    $err_msg[$key] = MSG03;
  }
}
//バリデーション関数（最小文字数チェック）
function validMinLen($str, $key, $min){
  if(mb_strlen($str) < $min){
    global $err_msg;
    $err_msg[$key] = MSG05;
  }
}
//バリデーション関数（最大文字数チェック）
function validMaxLen($str, $key, $max){
  if(mb_strlen($str) > $max){
    global $err_msg;
    $err_msg[$key] = MSG06;
  }
}
//バリデーション関数（半角チェック）
function validHalf($str, $key){
  if(!preg_match('/^[0-9a-zA-Z]*$/', $str)) {
    global $err_msg;
    $err_msg[$key] = MSG04;
  }
}
// 電話番号形式チェック
function validTel($str, $key) {
  if(!preg_match("/0\d{1,4}\d{1,4}\d{4}/", $str)) {
    global $err_msg;
    $err_msg[$key] = MSG10;
  }
}
// 郵便番号形式チェック
function validZip($str, $key) {
  if(!preg_match("/^\d{7}$/", $str)) {
    global $err_msg;
    $err_msg[$key] = MSG11;
  }
}
// 半角数字チェック
function validNumber($str, $key) {
  if(!preg_match("/^[0-9]+$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG17;
  }
}
//固定長チェック
function validLength($str, $key, $len = 8){
  if( mb_strlen($str) !== $len){
    global $err_msg;
    $err_msg[$key] = MSG14;
  }
}
// パスワードチェック
function validPass($str, $key) {
  // 半角英数字チェク
  validHalf($str, $key);
  // 最大文字数チェック
  validMaxLen($str, $key, 255);
  // 最小文字数チェック
  validMinLen($str, $key, 6);
}
//selectboxチェック
function validSelect($str, $key){
  if(!preg_match("/^[0-9]+$/", $str)){
    global $err_msg;
    $err_msg[$key] = MSG15;
  }
}
// エラーメッセージ表示
function getErrMsg($key) {
  global $err_msg;
  if(!empty($err_msg[$key])) {
    return $err_msg[$key];
  }
}

//================================
// データベース
//================================
// DB接続関数
function dbConnect(){
  // DB接続準備
  $dsn = 'mysql:dbname=freemarket;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
  $options = array(
    //SQL実行失敗時にはエラーコードのみ設定
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // デフォルトフェッチモードを連想配列型式に設定
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // バッファードクエリを使う（一度に結果セットを全て取得し、サーバー負荷を軽減）
    // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );
  // PDOオブジェクト生成（DBへ接続）
  $dbh = new PDO($dsn, $user, $password, $options);
  return $dbh;
}
// SQL実行関数
// function queryPost($dbh, $sql, $data){
  // クエリー作成
  // $stmt = $dbh->prepare($sql);
  //プレースホルダに値をセットし、SQL文を実行
  // $stmt->execute($data);
  // return $stmt;
// }
function queryPost($dbh, $sql, $data){
  // クエリー作成
  $stmt = $dbh->prepare($sql);
  //プレースホルダに値をセットし、SQL文を実行
  if(!$stmt->execute($data)){
    debug('クエリに失敗しました。');
    $err_msg['common'] = MSG07;
    return false;
  }
  debug('クエリ成功.');
  return $stmt;
}
// ユーザー情報取得関数
function getUser($u_id) {
  debug('ユーザー情報を取得します。');
  // 例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT * FROM users WHERE id = :u_id AND delete_flg = 0';
    $data = array(':u_id' => $u_id);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    // クエリ成功時
    // if($stmt) {
    //   debug('クエリ成功。');
    // } else {
    //   debug('クエリに失敗しました。');
    // }
    //クエリ結果のデータを１レコード返却
    if($stmt){
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生 :' .$e->getMessage());
  }
  // クエリ結果のデータを返却
  // return $stmt->fetch(PDO::FETCH_ASSOC);
}

//================================
// メール送信
//================================
function sendMail($from, $to, $subject, $comment) {
  if(!empty($to) && !empty($subject) && !empty($comment)) {
    // 文字化けしないように設定（お決まりパターン）
    mb_language("Japanese"); // 現在使っている言語を設定する
    mb_internal_encoding("UTF-8"); // 内部の日本語をどうエンコーディング（機械が分かる言葉へ変換）するかを設定

    // メールを送信（送信結果はtrueかfalseで帰ってくる）
    $result = mb_send_mail($to, $subject, $comment, "From: " . $from);
    // 送信結果を判定
    if($result) {
      debug('メールを送信しました。');
    } else {
      debug('【エラー発生】メールの送信に失敗しました。');
    }
  }
}

//================================
// その他
//================================
// フォーム入力保持
function getFormData($str) {
  global $dbFormData;
  global $err_msg;
  // ユーザーデータがある場合
  if(!empty($dbFormData)){
    // フォームのエラーがある場合
    if(!empty($err_msg[$str])){
      // POSTにデータがある場合
      if(isset($_POST[$str])){ //金額や郵便番号などのフォームで数字や数値の0が入っている場合もあるので、issetを使うこと
        return $_POST[$str];
      } else {
        // ない場合（フォームにエラーがある=POSTされてるはずなので、まずありえないが）はDBの情報を表示
        return $dbFormData[$str];
      }
    } else {
      // POSTにデータがあり、DBの情報と違う場合（このフォームも変更していてエラーはないが、他のフォームでひっかかっている状態）
      if(isset($_POST[$str]) && $_POST[$str] !== $dbFormData[$str]) {
        return $_POST[$str];
      }else { //そもそも変更していない
        return $dbFormData[$str];
      }
    }
  } else {
    if(isset($_POST[$str])) {
      return $_POST[$str];
    }
  }
}
// sessionを1回だけ取得できる
function getSessionFlash($key) {
  if(!empty($_SESSION[$key])) {
    $data = $_SESSION[$key];
    $_SESSION[$key] = '';
    return $data;
  }
}
//認証キー生成
function makeRandKey($length = 8){
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
  $str = '';
  for ($i = 0; $i < $length; ++$i) {
    $str .= $chars[mt_rand(0, 61)];
  }
  return $str;
}
?>