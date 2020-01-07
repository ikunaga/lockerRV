<html>
<head>
  <meta charset="UTF-8">
  <title>詳細ページ</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <?php include_once("../template/header.tpl"); ?>
  <div style="margin-top: 80px; text-align: center;">
    <h4>ロッカー詳細</h4>
    <?php
    require_once '../db_config.php';
    try {
      //idを正しくうけとれなかったときの処理
      if (empty($_GET['id'])) throw new Exception('ID不正');
      $id = (int) $_GET['id'];

      //SQL１予約テーブルをinnnerjoin結合したうえで、ロッカーIDに紐づくものを取り出し
      $result = getRvLckrid($dbh,$id);
      //SQL２現在の利用者検索
      $result2 = getRvApprovedLckridNow($dbh,$id);
      //SQL３ロッカー検索
      $result3 = getLckrid($dbh,$id);
      //id存在チェック
      $result_lckrid = getLckridCount($dbh,$id);
      if ($result_lckrid == 0) {
        echo "<p style='color: red'>存在しないIDです。</p>" . "<br>";
        echo "<a href=../index.php>一覧に戻る</a>";
        exit;
      }

    } catch (Exception $e) {
          echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
          die();
    }
      //echoで表示内容を指定（ロッカー番号）
      echo "【 ロッカー番号：" . htmlspecialchars($result3['line'], ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($result3['step'], ENT_QUOTES,'UTF-8') ." 】" . "<br>\n";
      $dbh = null;

      if (empty($result2)) {
        echo "現在の利用者：なし" ;
      } else {
          foreach($result2 as $row) {
            echo "現在の利用者：" . htmlspecialchars($row['first_name'], ENT_QUOTES, 'UTF-8') . htmlspecialchars($row['last_name'], ENT_QUOTES, 'UTF-8') . "<br>";
        }
      }
    ?>

    <p>＜このロッカーに対する申請一覧＞</p>
    <div style="text-align: center;">
      <table align="center" border=1 class="table2">
        <tr style="background-color: #ffebcd;">
          <th>申請者</th><th>開始日時</th><th>終了日時</th><th>承認状況</th>
        </tr>
        <?php
          foreach ($result as $row) {
        ?>
          <tr>
            <td><?php echo htmlspecialchars($row['first_name'],ENT_QUOTES,'UTF-8') . htmlspecialchars($row['last_name'],ENT_QUOTES,'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars(date( "Y/m/d" , strtotime($row['start_date']) ),ENT_QUOTES,'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars(date( "Y/m/d" , strtotime($row['end_date']) ),ENT_QUOTES,'UTF-8'); ?></td>
            <td><?php if ($row['approval'] == 0) echo "未承認";
            if ($row['approval'] == 1) echo "承認済";
            if ($row['approval'] == 2) echo "否決";?></td>
          </tr>
        <?php } ?>
      </table>
    </div>
    <br>

    <div style="text-align: center; margin-bottom: 120px;">
      <a href=reserve.php?id=<?php echo  htmlspecialchars($id,ENT_QUOTES,'UTF-8') ?>>このロッカーを予約申請する</a><br>
      <a href=../index.php>ロッカー一覧に戻る</a>
    </div>
  </div>
  <?php include_once("../template/footer.tpl"); ?>
</body>
</html>
