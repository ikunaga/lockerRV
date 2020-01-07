<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ユーザー一覧</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
  </head>
  <body>
    <?php include_once("../template/adheader.tpl"); ?>
    <div style="text-align: center; margin-top: 80px;">
      <h4>ユーザー一覧</h4>
      <?php
      require_once '../db_config.php';

      try {
        //ユーザー一覧の取り出し
        $result = getUsrAll($dbh);

        echo "<table class='table2' align=center border=1>\n";
        echo "<tr style='background-color: #ffebcd;'>\n";
        echo "<th>性</th><th>名</th><th>メールアドレス</th><th>各種設定</th>\n";
        echo "</tr>\n";
        foreach ($result as $row) {
          echo "<tr>\n";
          echo "<td>" . htmlspecialchars($row['first_name'],ENT_QUOTES,'UTF-8') . "</td>\n";
          echo "<td>" . htmlspecialchars($row['last_name'],ENT_QUOTES,'UTF-8') . "</td>\n";
          echo "<td>" . htmlspecialchars($row['mail'],ENT_QUOTES,'UTF-8') . "</td>\n";
          //各種リンク
          echo "<td>\n";
          echo "<a href=detail.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">詳細</a>\n";
          echo "<a href=edit.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">変更</a>\n";
          echo "<a href=delete.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ">削除</a>\n";
          echo "</td>\n";
          echo "</tr>\n";
        }
        echo "</table>\n<br>";
        echo "<a href='create.html'>ユーザーを登録する</a>";
        $dbh = null;

      } catch (Exception $e) {
        echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
      }
      ?>
    </div>
    <footer></footer>
  </body>
</html>
