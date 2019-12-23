<?php
require_once '../db_config.php';

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$user_id = $_POST['user_id'];
$locker_id = $_POST['locker_id'];
try {
  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8', $user, $pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "INSERT INTO reservations (start_date, end_date, user_id, locker_id) VALUES (?, ?, ?, ?)";
  $stmt = $dbh->prepare($sql);

  $stmt->bindValue(1, $start_date, PDO::PARAM_STR);
  $stmt->bindValue(2, $end_date, PDO::PARAM_STR);
  $stmt->bindValue(3, $user_id, PDO::PARAM_INT);
  $stmt->bindValue(4, $locker_id, PDO::PARAM_INT);

  $stmt->execute();
  $dbh = null;

  echo "予約が完了しました。<br>";
  echo "<a href='../index.php'>一覧に戻る</a>";
} catch (Exception $e) {
  echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}

?>
