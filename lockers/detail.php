<html>
<head>
  <meta charset="UTF-8">
  <title>詳細ページ</title>
</head>
<body>
  <h1>ロッカー詳細ページ</h1>


<?php
require_once '../db_config.php';
try {
  //idを正しくうけとれなかったときの処理
  if (empty($_GET['id'])) throw new Exception('ID不正');
  $id = (int) $_GET['id'];
  //データベースに接続
  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //プレースホルダを設定してSQLを入力
  $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ?";
  //設定したSQLをPDOで利用するように入力
  $stmt = $dbh->prepare($sql);
  //bindvalueでプレースホルダの値を入力
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  //結果を格納するための$resultを入力
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  //現在の利用者検索
  $sql2 = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date >= NOW() AND end_date <= NOW() AND approval = 1";
  $stmt2 = $dbh->prepare($sql2);
  $stmt2->bindValue(1, $id, PDO::PARAM_INT);
  $stmt2->execute();
  $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


} catch (Exception $e) {
      echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
      die();
}

  echo "現在の時刻：" . date("Y/m/d H:i:s") . "<br>";
  //echoで表示内容を指定（ロッカー番号）
  echo "ロッカー番号：" . htmlspecialchars($result[0]['line'], ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($result[0]['step'], ENT_QUOTES,'UTF-8') . "<br>\n";
  $dbh = null;

  if (empty($result2)) {
    echo "現在の利用者：なし" ;
  } else {
    foreach($result2 as $row) {
    echo "現在の利用者：" . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "<br>";
    }
  }

?>

  <table>
    <tr>
      <th>申請者</th><th>開始日時</th><th>終了日時</th><th>承認状況</th>
    </tr>
<?php
  foreach ($result as $row) {
?>
    <tr>
      <td><?php echo htmlspecialchars($row['first_name']) . htmlspecialchars($row['last_name']); ?></td>
      <td><?php echo htmlspecialchars($row['start_date']); ?></td>
      <td><?php echo htmlspecialchars($row['end_date']); ?></td>
      <td><?php if ($row['approval'] == 0) echo "未承認";
      if ($row['approval'] == 1) echo "承認済";
      if ($row['approval'] == 2) echo "否決";?></td>
    </tr>
  </table>


<?php
  }
?>
  <br>
  <a href=reserve.php?id=" . htmlspecialchars($id,ENT_QUOTES,'UTF-8') . ">このロッカーを予約する</a>

</body>
</html>
