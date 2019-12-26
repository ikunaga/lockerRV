<?php
require_once '../db_config.php';

try {
  if (empty($_GET['id'])) throw new Exception('ID不正');
  $id = (int) $_GET['id'];

  $sql = "DELETE FROM reservations WHERE id = ?";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  $dbh = null;

  echo "ID:" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "予約を削除しました。<br>";
  echo "<a href='index.php'>一覧に戻る</a>";

} catch (Exceptino $e) {
  echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}
?>
