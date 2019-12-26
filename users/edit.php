
<html>
<head>
  <title>ユーザー編集</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <header>
      <ul>
        <li><a href="../index.php" style="text-decoration: none;"><span>LockerRV</span></a>　(ロッカー予約管理システム)</li>
        <li style="margin-left: 850px"><a href="../admin.php" style="text-decoration: none;"><h2 style="color: #6495ed;">[ 管理者用ページ ]</h2></a></li>
      </ul>
  </header>
  <div style="margin-top: 80px; text-align: center;">
    <h4>ユーザー編集ページ</h4>
    <?php
    require_once '../db_config.php';
    try {
      if (empty($_GET['id'])) throw new Execption('ID不正');
      $id = (int) $_GET['id'];

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

    <form method="post" action="update.php">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">
      性：<input type="text" name="first_name" value="<?php echo htmlspecialchars($result['first_name'], ENT_QUOTES, 'UTF-8'); ?>"><br>
      名：<input type="text" name="last_name" value="<?php echo htmlspecialchars($result['last_name'], ENT_QUOTES, 'UTF-8'); ?>"><br>
      メールアドレス：<input type="text" name="mail" value="<?php echo htmlspecialchars($result['mail'], ENT_QUOTES, 'UTF-8'); ?>"><br>

      <input type="submit" value="更新">
    </form>
  </div>
  <footer></footer>
</body>
</html>
