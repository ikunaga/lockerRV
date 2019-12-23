<html>
<head>
  <meta charset="UTF-8">
  <title>詳細ページ</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <header>
    <ul>
      <li><a href="../index.php" style="text-decoration: none;"><span>LockerRV</span></a>　(ロッカー予約管理システム)</li>
      <!-- <li style="margin-left: 900px;">使い方：</li>
      <li>1.予約したいロッカーをクリック</li>
      <li>index</li> -->
    </ul>
  </header>
  <div style="margin-top: 80px; text-align: center;">
  <h4>ロッカー詳細</h4>
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
      //SQL１「innnerjoin結合」
      $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ?";

      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(1, $id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      //SQL２「現在の利用者検索」
      $sql2 = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date < NOW() < end_date AND approval = 1";

      $stmt2 = $dbh->prepare($sql2);
      $stmt2->bindValue(1, $id, PDO::PARAM_INT);
      $stmt2->execute();
      $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

      //SQL３「ロッカー検索」
      $sql3 = "SELECT * FROM lockers WHERE id = ?";

      $stmt3 = $dbh->prepare($sql3);
      $stmt3->bindValue(1, $id, PDO::PARAM_INT);
      $stmt3->execute();
      $result3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);


    } catch (Exception $e) {
          echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
          die();
    }

      echo "現在の時刻：" . date("Y/m/d H:i:s") . "<br>";
      //echoで表示内容を指定（ロッカー番号）
      echo "【 ロッカー番号：" . htmlspecialchars($result3[0]['line'], ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($result3[0]['step'], ENT_QUOTES,'UTF-8') ." 】" . "<br>\n";
      $dbh = null;

      if (empty($result2)) {
        echo "現在の利用者：なし" ;
      } else {
        foreach($result2 as $row) {
        echo "現在の利用者：" . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "<br>";
        }
      }

    ?>
    <div style="text-align: center;">
      <table align="center">
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
        <br>
      </table>
    </div>


    <?php
      }
    ?>
      <br>
      <a href=reserve.php?id=<?php echo  htmlspecialchars($id,ENT_QUOTES,'UTF-8') ?>>このロッカーを予約する</a><br>
      <a href=../index.php>ロッカー一覧に戻る</a>
  </div>
  <footer>
    <ul style="padding-top: 8px;">
      <li style="margin-left: 500px;">[ 予約手順 ]</li>
      <li>1.予約したいロッカーをクリック</li>
      <li>2.詳細ページで予約するをクリック</li>
      <li>3.予約ページで期間を入力してOKをクリック</li>
    </ul>
  </footer>

</body>
</html>
