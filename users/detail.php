<html>
<head>
  <title>ユーザー詳細</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <?php include_once("../template/adheader.tpl"); ?>
  <div style="margin-top: 80px; text-align: center;">
    <h4>ユーザー詳細</h4>

  <?php
  require_once '../db_config.php';

  try {
    if (empty($_GET['id'])) throw new Exception('ID不正');
    $id = (int) $_GET['id'];

    //SQL１「ユーザー検索」
    $result = getUsrid($dbh, $id);
    //ユーザーid存在チェック
    $result_userid = getUsridCount($dbh, $id);

    if ($result_userid == 0) {
      echo "<p style='color: red'>存在しないIDです。</p>" . "<br>";
      echo "<a href=index.php>一覧に戻る</a>";
      exit;
    } else {
      echo htmlspecialchars($result['first_name'], ENT_QUOTES,'UTF-8') . " " . htmlspecialchars($result['last_name'], ENT_QUOTES,'UTF-8') . "<br>\n";
      echo "メール:" . htmlspecialchars($result['mail'], ENT_QUOTES,'UTF-8') . "<br>\n";
      $dbh = null;
      echo "<a href='index.php'>トップに戻る</a>";
    }

  } catch (Exception $e) {
    echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
  }
  ?>

  </div>
  <footer></footer>
</body>
</html>
