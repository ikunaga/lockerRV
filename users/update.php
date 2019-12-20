<?php
require_once '../db_config.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$mail = $_POST['mail'];

try {
  if (empty($_POST['id'])) throw new Exception('ID不正');
  $id = (int) $_POST['id'];

  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8', $user, $pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "UPDATE users SET first_name = ?, last_name = ?, mail = ? WHERE id = ?";
  $stmt = $dbh->prepare($sql);

  $stmt->bindValue(1, $first_name, PDO::PARAM_STR);
  $stmt->bindValue(2, $last_name, PDO::PARAM_STR);
  $stmt->bindValue(3, $mail, PDO::PARAM_STR);
  $stmt->bindValue(4, $id, PDO::PARAM_INT);
  $stmt->execute();
  $dbh = null;

  echo "ID:" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "ユーザーの更新が完了しました。<br>";
  echo "<a href='index.php'>一覧に戻る</a>";
} catch (Exception $e) {
  echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}
 ?>
