<?php
require_once '../db_config.php';
//POSTで受け取った値を数値に変換して変数に格納
$line = (int)$_POST['line'];
$step = (int)$_POST['step'];

try {
  //データベースとの接続を入力
  //データベース、文字コード、ユーザー名、パスワード指定
  $dbh = new  PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
  //PDO実行時のエラーモードを設定(どんな属性の情報を取得するか)
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //データベースとの操作を入力
  $sql = "INSERT INTO lockers (line, step) VALUES (?, ?)";
  $stmt = $dbh->prepare($sql);

  // プレースホルダの値を指定
  $stmt->bindValue(1, $line, PDO::PARAM_INT);
  $stmt->bindValue(2, $step, PDO::PARAM_INT);

  //指定したSQLを実行して、データベースとの接続を終了する
  $stmt->execute();
  $dbh = null;
  echo "ロッカーの登録が完了しました。<br>";
  
} catch (Exception $e) {
  echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
}
