<?php
require_once '../db_config.php';
try {
  if (empty($_GET['id'])) throw new Execption('ID不正');
  $id = (int) $_GET['id'];
  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8', $user, $pass);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "SELECT * FROM users WHERE id = ?";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $dbh = null;
} catch (Exception $e) {
  echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー編集</title>
</head>
<body>
  <h1>ユーザー編集画面</h1>
  <form method="post" action="update.php">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">
    性：<input type="text" name="first_name" value="<?php echo htmlspecialchars($result['first_name'], ENT_QUOTES, 'UTF-8'); ?>"><br>
    名：<input type="text" name="last_name" value="<?php echo htmlspecialchars($result['last_name'], ENT_QUOTES, 'UTF-8'); ?>"><br>
    メールアドレス：<input type="text" name="mail" value="<?php echo htmlspecialchars($result['mail'], ENT_QUOTES, 'UTF-8'); ?>"><br>

    <input type="submit" value="更新">
  </form>
</body>
</html>
