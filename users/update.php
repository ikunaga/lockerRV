<html>
<head>
  <title>ユーザー編集</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <div id="wrapper"  style="margin-top: 50px; text-align: center;">
    <h4>処理結果（ユーザー編集）</h4>
    <header>
        <ul>
          <li><a href="../index.php" style="text-decoration: none;"><span>LockerRV</span></a>　(ロッカー予約管理システム)</li>
          <li style="margin-left: 700px"><a href="../admin.php" style="text-decoration: none;"><h2 style="color: #6495ed;">[ 管理者用ページ ]</h2></a></li>
        </ul>
    </header>

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

      //メールアドレス重複チェック
      $sql_mail = "SELECT COUNT(*) FROM users WHERE mail = ?";
      $stmt_mail = $dbh->prepare($sql_mail);
      $stmt_mail->bindValue(1, $mail, PDO::PARAM_STR);
      $stmt_mail->execute();
      $result_mail = $stmt_mail->fetchColumn(0);

      if ($result_mail !== 0) {
        echo "すでに登録されているメールアドレスです。" . "<br>";
        echo "<a href=index.php>一覧に戻る</a>";
      } else {
      // 指定したSQLを実行して、データベースとの接続を終了
      $stmt->execute();
      $dbh = null;
      echo "ユーザーID:" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "の更新が完了しました。<br>";
      echo "<a href='index.php'>一覧に戻る</a>";
      }

    } catch (Exception $e) {
      echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
      die();
    }
    ?>
    <footer></footer>
  </div>
</body>
</html>
