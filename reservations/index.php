<html>
<head>
  <title>予約一覧</title>
</head>
<body>
  <h1>予約一覧ページ</h1>


  <?php
  require_once '../db_config.php';
  try {
        // PDOの接続方法を入力
        $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //DB操作
        $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id";
        $stmt = $dbh->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //DB操作2
        $sql2 = "SELECT * FROM reservations";
        $stmt2 = $dbh->query($sql2);
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $dbh = null;

      } catch (Exception $e) {
        echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        die();
      }
  ?>
    <div style="float: left;">
      <table>
        <tr>
          <th>ロッカー</th><th>申請者</th><th>開始日時</th><th>終了日時</th><th>承認状況</th>
        </tr>
        <?php
          foreach ($result as $row) {
        ?>
          <tr>
            <td><?php echo htmlspecialchars($row['line']) . "-" . htmlspecialchars($row['step']); ?></td>
            <td><?php echo htmlspecialchars($row['first_name']) . htmlspecialchars($row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
            <td><?php if ($row['approval'] == 0) echo "未承認";
                      if ($row['approval'] == 1) echo "承認済";
                      if ($row['approval'] == 2) echo "否決"; ?></td>
          </tr>
          <?php
          } ?>
        </table>
      </div>
      <!-- 承認ボタン -->
      <div style="float: left; padding-top: 30px;">
          <?php foreach ($result2 as $row2) {?>
              <form style="margin: 0px;" method="post" action="update.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row2['id'],ENT_QUOTES,'UTF-8')?>">
                <input type="hidden" name="approval" value="1">
                <input type="submit" value="承認">
              </form>
          <?php
                }?>
      </div>
      <!-- 否決ボタン -->
      <div style="float: left; padding-top: 30px;">
          <?php foreach ($result2 as $row2) {?>
              <form style="margin: 0px;" method="post" action="update.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row2['id'],ENT_QUOTES,'UTF-8')?>">
                <input type="hidden" name="approval" value="2">
                <input type="submit" value="否決">
              </form>
          <?php
                }?>
      </div>



</body>
</html>
