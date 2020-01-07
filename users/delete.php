<html>
<head>
  <title>ユーザー削除</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <div id="wrapper"  style="margin-top: 50px; text-align: center;">
    <h4>処理結果（ユーザー削除）</h4>
    <header>
        <ul>
          <li><a href="../index.php" style="text-decoration: none;"><span>LockerRV</span></a>　(ロッカー予約管理システム)</li>
          <li style="margin-left: 700px"><a href="../admin.php" style="text-decoration: none;"><h2 style="color: #6495ed;">[ 管理者用ページ ]</h2></a></li>
        </ul>
    </header>

    <?php
    require_once '../db_config.php';

    try {
      if (empty($_GET['id'])) throw new Exception('ID不正');
      $id = (int) $_GET['id'];
      //ユーザー削除
      deleteUsr($dbh, $id);
      $dbh = null;

      echo "ID:" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "ユーザーを削除しました。<br>";
      echo "<a href='index.php'>一覧に戻る</a>";

    } catch (Exceptino $e) {
      echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
      die();
    }
    ?>

    <footer></footer>
  </div>
</body>
</html>
