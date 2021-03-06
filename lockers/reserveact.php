
<html>
<head>
  <title>ロッカー予約</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <?php include_once("../template/header.tpl"); ?>
  <div style="margin-top: 80px; text-align: center; margin-bottom: 200px;">
      <h4>ロッカー予約</h4>
<?php
require_once '../db_config.php';

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$user_id = $_POST['user_id'];
$locker_id = $_POST['locker_id'];

try {
      if ($start_date > $end_date) { throw new Exception('終了日時は開始日時と同日か後ろの日付にしてください。');}
      if (empty($start_date) OR empty($end_date) OR empty($user_id)) {throw new Exception('項目はすべて入力してください');}

      //SQL１「innnerjoin結合」（エラーチェック用）
      $result2 = getRvApprovedLckrid($dbh,$locker_id);
      //予約エラーチェック
      $cnt = 0;
      foreach($result2 as $row) {
          if($start_date <= $row['end_date'] AND $end_date >= $row['start_date']) {
            $cnt++;
            break;
          } else {
            continue;
          }
      }

      //予約エラー結果表示 or 予約実行
      if ($cnt >= 1) {
        echo "期間が他の申請と重複しています。" . "<br>";
        echo "<a href='reserve.php?id=" . htmlspecialchars($locker_id,ENT_QUOTES,'UTF-8') . "'>申請画面に戻る</a>";
      } else {
        InsertRv($dbh,$start_date,$end_date,$user_id,$locker_id);
        $dbh = null;
        echo "申請しました。<br>";
        echo "<a href='../index.php'>一覧に戻る</a>";
      }

    } catch (Exception $e) {
      echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
      die();
    }

?>
  </div>
  <?php include_once("../template/footer.tpl"); ?>
</body>
</html>
