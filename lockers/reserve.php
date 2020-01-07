<html>
<head>
  <title>ロッカー予約申請</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <?php include_once("../template/header.tpl"); ?>
  <div style="margin-top: 80px; text-align: center; margin-bottom: 200px;">
      <h4>ロッカー予約申請</h4>

    <?php
    require_once '../db_config.php';
    try {
      if (empty($_GET['id'])) throw new Exception('ID不正');
      $id = (int) $_GET['id'];
      //指定したロッカー取り出し
      $result = getLckrid($dbh,$id);
      //ユーザーすべて取り出し
      $result2 = getUsrAll($dbh);

      echo "【 ロッカー番号:" . htmlspecialchars($result['line'], ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($result['step'], ENT_QUOTES,'UTF-8') . " 】" . "<br>\n";
      $dbh = null;

    } catch (Exception $e) {
      echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
      die();
    }
    ?>

    <form method="post" action="reserveact.php">
      <input type="hidden" name="locker_id" value="<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'); ?>">
      利用開始日：<input style="margin-top: 10px;" type="date" name="start_date"><br>
      利用終了日：<input style="margin-top: 10px;" type="date" name="end_date"><br>
      申請者：<select style="margin-top: 10px;" name='user_id'>
              <?php
              foreach($result2 as $record){?>
                <option value="<?php echo htmlspecialchars($record['id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($record['first_name'], ENT_QUOTES, 'UTF-8') . htmlspecialchars($record['last_name'], ENT_QUOTES, 'UTF-8'); ?></option>
        <?php }?>
              </select><br>
      <input style="margin-top: 10px;" type='submit' value='申請する' class="buttonRv">
    </form>
    <?php echo "<a href=detail.php?id="  . htmlspecialchars($id,ENT_QUOTES,'UTF-8') . ">ロッカー詳細に戻る</a>" . "<br>";?>
    <?php echo "<a href=../index.php>ロッカー一覧に戻る</a>";?>
  </div>
    <?php include_once("../template/footer.tpl"); ?>
</body>
</html>
