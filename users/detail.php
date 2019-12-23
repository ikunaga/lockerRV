<html>
<head>
  <title>ユーザー詳細</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <header>
      <ul>
        <li><a href="../index.php" style="text-decoration: none;"><span>LockerRV</span></a>　(ロッカー予約管理システム)</li>
        <li style="margin-left: 850px"><a href="../admin.php" style="text-decoration: none;"><h2 style="color: #6495ed;">[ 管理者用ページ ]</h2></a></li>
      </ul>
    </header>
    <div style="margin-top: 80px;">

<?php
require_once '../db_config.php';

try {
  if (empty($_GET['id'])) throw new Exception('ID不正');
  $id = (int) $_GET['id'];
  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8', $user, $pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //プレースホルダを設定してSQLを入力
  $sql = "SELECT * FROM users WHERE id = ?";
  //設定したSQLをPDOで利用するように入力
  $stmt = $dbh->prepare($sql);
  //bindValueでプレースホルダの値を入力
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  //結果を格納するための$resultを入力
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  //echoで表示内容を指定
  echo "性:" . htmlspecialchars($result['first_name'], ENT_QUOTES,'UTF-8') . "<br>\n";
  echo "名:" . htmlspecialchars($result['last_name'], ENT_QUOTES,'UTF-8') . "<br>\n";
  echo "メール:" . htmlspecialchars($result['mail'], ENT_QUOTES,'UTF-8') . "<br>\n";
  $dbh = null;
  echo "<a href='index.php'>トップに戻る</a>";

} catch (Exception $e) {
  echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}
?>

</div>
<footer></footer>
</body>
</html>