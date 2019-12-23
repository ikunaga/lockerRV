<html>
<head>
  <title>ロッカー予約</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <header>
    <ul>
      <li><span>LockerRV</span></li>
      <!-- <li style="margin-left: 900px;">使い方：</li>
      <li>1.予約したいロッカーをクリック</li>
      <li>index</li> -->
    </ul>
  </header>
  <h4>ロッカー予約ページ</h4>
  <div style="margin-top: 80px; text-align: center;">

<?php
require_once '../db_config.php';

try {
  if (empty($_GET['id'])) throw new Exception('ID不正');
  $id = (int) $_GET['id'];

  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8', $user, $pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  //プレースホルダを設定してSQLを入力
  $sql = "SELECT * FROM lockers WHERE id = ?";
  $sql2 = "SELECT * FROM users";
  //設定したSQLをPDOで利用するように入力
  $stmt = $dbh->prepare($sql);
  $stmt2 = $dbh->query($sql2);
  //bindvalueでプレースホルダの値を入力
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
  //結果を格納するための$resultを入力
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  //echoで表示内容を指定
  echo "ロッカー番号:" . htmlspecialchars($result['line'], ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($result['step'], ENT_QUOTES,'UTF-8') . "<br>\n";
  $dbh = null;

} catch (Exception $e) {
  echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}
?>

  <form method="post" action="reserveact.php">
    <input type="hidden" name="locker_id" value="<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">
    利用開始日：<input type="date" name="start_date"><br>
    利用終了日：<input type="date" name="end_date"><br>
    申請者：<select name='user_id'>
            <?php
            foreach($result2 as $record){?>
              <option value="<?php echo htmlspecialchars($record['id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($record['first_name'], ENT_QUOTES, 'UTF-8') . htmlspecialchars($record['last_name'], ENT_QUOTES, 'UTF-8'); ?></option>
      <?php }?>
            </select><br>
    <input type='submit' value='送信'>
  </form>
    <?php echo "<a href=detail.php?id="  . htmlspecialchars($id,ENT_QUOTES,'UTF-8') . ">ロッカー詳細に戻る</a>";?>
  </div>
</body>
</html>
