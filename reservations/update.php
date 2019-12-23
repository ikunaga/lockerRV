<?php
require_once '../db_config.php';

//各項目の値を変数に代入
$id = $_POST['id'];
$approval = $_POST['approval'];

//POST変数からidを受け取る
try {
  if (empty($_POST['id'])) throw new Exception('ID不正');
  $id = (int) $_POST['id'];
  //データベースに接続する
  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8', $user,$pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //UPDATEのSQLを入力する
  $sql = "UPDATE reservations SET approval = ? WHERE id = ?";
  $stmt = $dbh->prepare($sql);
  //プレースホルダの値を指定して、データベースの操作を実行する
  $stmt->bindValue(1, $approval, PDO::PARAM_INT);
  $stmt->bindValue(2, $id, PDO::PARAM_INT);
  $stmt->execute();
  $dbh = null;
  //画面にメッセージを表示
  echo "ID: " . htmlspecialchars($id,ENT_QUOTES,'UTF-8') . "完了しました。<br>";
  echo "<a href='index.php'>トップに戻る</a>";
} catch (Exception $e) {
  echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}


 ?>
