<html>
<head>
  <title>予約一覧</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <div id="wrapper"  style="margin-top: 50px; text-align: center;">
    <h4>処理結果（ユーザー登録）</h4>
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
        $sql = "INSERT INTO users (first_name, last_name, mail ) VALUES (?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        //SQL「ユーザー取り出し」
        $sql_uselect = "SELECT * FROM users";
        $stmt_uselect = $dbh->query($sql_uselect);
        $result = $stmt_uselect->fetchAll(PDO::FETCH_ASSOC);

        //プレースホルダの値を指定
        $stmt->bindValue(1, $first_name, PDO::PARAM_STR);
        $stmt->bindValue(2, $last_name, PDO::PARAM_STR);
        $stmt->bindValue(3, $mail, PDO::PARAM_STR);

        //メールアドレス重複チェック
        $sql_mail = "SELECT COUNT(*) FROM users WHERE mail = ?";
        $stmt_mail = $dbh->prepare($sql_mail);
        $stmt_mail->bindValue(1, $mail, PDO::PARAM_STR);
        $stmt_mail->execute();
        $result_mail = $stmt_mail->fetchColumn(0);

        if ($result_mail !== 0) {
          echo "すでに登録されているメールアドレスです。" . "<br>";
          echo "<a href=create.html>登録画面に戻る</a>";
        } else {
        // 指定したSQLを実行して、データベースとの接続を終了
        $stmt->execute();
        $dbh = null;
        echo "ユーザーの登録が完了しました。<br>";
        echo "<a href=create.html>登録画面に戻る</a>";
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
