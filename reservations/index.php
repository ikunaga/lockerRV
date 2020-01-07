<html>
<head>
  <title>申請一覧</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <div id="wrapper"  style="margin-top: 50px; text-align: center;">
    <h4>利用申請一覧ページ</h4>
    <?php
    include_once("../template/adheader.tpl");
    require_once '../db_config.php';
    try {
          //予約一覧取り出し
          $result = getRvAs($dbh);
          $dbh = null;
        } catch (Exception $e) {
          echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
          die();
        }
    ?>
    <div style="float: left; text-align: center; margin-bottom: 20px;">
      <table class="table2" border=1 align=center style="margin-left: 150px;">
        <tr style="background-color: #ffebcd;">
          <th>申請id</th><th>ロッカー</th><th>申請者</th><th>開始日時</th><th>終了日時</th><th>承認状況</th><th>承認</th><th>否決</th><th>削除</th>
        </tr>
        <?php foreach ($result as $row) { ?>
              <tr>
                <td><?php echo htmlspecialchars($row['reservation_id']); ?></td>
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
                      <input type="submit" value="承認" class="buttonRv" style="border: none;">
                    </form></td>
                <td><form style="margin: 0px;" method="post" action="update.php">
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['reservation_id'],ENT_QUOTES,'UTF-8')?>">
                      <input type="hidden" name="approval" value="2">
                      <input type="submit" value="否決" class="buttonRv" style="background-color: #ffe4e1; border: none;">
                    </form></td>
                <td><form style="margin: 0px;" method="post" action=<?php echo "delete.php?id=" . htmlspecialchars($row['reservation_id'],ENT_QUOTES,'UTF-8')?>>
                      <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['reservation_id'],ENT_QUOTES,'UTF-8')?>">
                      <input type="submit" value="削除" class="buttonRv" style="background-color: #ffebcd; border: none;">
                    </form></td>
              </tr>
      <?php  } ?>
        </table>
    </div>
  <footer></footer>
</div>
</body>
</html>
