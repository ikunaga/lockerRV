<html>
<head>
  <title>予約一覧</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <div id="wrapper"  style="margin-top: 50px; text-align: center;">
    <h4>処理結果（承認・否決）</h4>
    <?php include_once("../template/adheader.tpl"); ?>

    <?php
    require_once '../db_config.php';

    //各項目の値を変数に代入
    $id = $_POST['id'];
    $approval = $_POST['approval'];

    //POST変数からidを受け取る
    try {
      if (empty($_POST['id'])) throw new Exception('ID不正');
      $id = (int) $_POST['id'];
      //UPDATEのSQLを入力する
      $sql = "UPDATE reservations SET approval = ? WHERE id = ?";
      $stmt = $dbh->prepare($sql);
      //プレースホルダの値を指定して、データベースの操作を実行する
      $stmt->bindValue(1, $approval, PDO::PARAM_INT);
      $stmt->bindValue(2, $id, PDO::PARAM_INT);
      $stmt->execute();
      $dbh = null;
      //画面にメッセージを表示
      if ($approval == 1) {
        echo "予約ID: " . htmlspecialchars($id,ENT_QUOTES,'UTF-8') . "を承認しました。<br>";
        echo "<a href='index.php'>トップに戻る</a>";
      } elseif ($approval == 2) {
        echo "予約ID: " . htmlspecialchars($id,ENT_QUOTES,'UTF-8') . "を否決しました。<br>";
        echo "<a href='index.php'>トップに戻る</a>";
      }

    } catch (Exception $e) {
      echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
      die();
    }
    ?>

    <footer></footer>
  </div>
</body>
</html>
