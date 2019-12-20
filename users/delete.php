<?php
require_once '../db_config.php';

try {
  if (empty($_GET['id'])) throw new Exception('ID不正');
  $id = (int) $_GET['id'];

  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8', $user, $pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "DELETE FROM users WHERE id = ?";
  $stmt = $dbh->prepare($sql);

  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();

  $dbh = null;

  echo "ID:" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "ユーザーを削除しました。<br>";
  echo "<a href='index.php'>一覧に戻る</a>";

} catch (Exceptino $e) {
  echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}
?>
