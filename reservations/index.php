<html>
<head>
  <title>予約一覧</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <div id="wrapper"  style="margin-top: 50px; text-align: center;">
    <h4>予約一覧ページ</h4>
    <header>
        <ul>
          <li><a href="../index.php" style="text-decoration: none;"><span>LockerRV</span></a>　(ロッカー予約管理システム)</li>
          <li style="margin-left: 700px"><a href="../admin.php" style="text-decoration: none;"><h2 style="color: #6495ed;">[ 管理者用ページ ]</h2></a></li>
        </ul>
    </header>

    <?php
    require_once '../db_config.php';
    try {
          $sql = "SELECT
          reservations.id as reservation_id,
          reservations.start_date,
          reservations.end_date,
          reservations.approval,
          lockers.line,
          lockers.step,
          users.first_name,
          users.last_name
           FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id";
          $stmt = $dbh->query($sql);
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          $dbh = null;

        } catch (Exception $e) {
          echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
          die();
        }
    ?>
    <div style="float: left; text-align: center;">
      <table align=center style="float: left; margin-left: 400px;">
        <tr>
          <th>ロッカー</th><th>申請者</th><th>開始日時</th><th>終了日時</th><th>承認状況</th>
        </tr>
        <?php foreach ($result as $row) { ?>
              <tr>
                <td><?php echo htmlspecialchars($row['line']) . "-" . htmlspecialchars($row['step']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name']) . htmlspecialchars($row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                <td><?php if ($row['approval'] == 0) echo "未承認";
                          if ($row['approval'] == 1) echo "承認済";
                          if ($row['approval'] == 2) echo "否決"; ?></td>
                <td><form style="margin: 0px;" method="post" action="update.php">
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['reservation_id'],ENT_QUOTES,'UTF-8')?>">
                      <input type="hidden" name="approval" value="1">
                      <input type="submit" value="承認">
                    </form></td>
                <td><form style="margin: 0px;" method="post" action="update.php">
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['reservation_id'],ENT_QUOTES,'UTF-8')?>">
                      <input type="hidden" name="approval" value="2">
                      <input type="submit" value="否決">
                    </form></td>
                <td><form style="margin: 0px;" method="post" action=<?php echo "delete.php?id=" . htmlspecialchars($row['reservation_id'],ENT_QUOTES,'UTF-8')?>>
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['reservation_id'],ENT_QUOTES,'UTF-8')?>">
                      <input type="submit" value="削除">
                    </form></td>
              </tr>
      <?php  } ?>
        </table>
    </div>
  <footer></footer>
</div>
</body>
</html>
