<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ユーザー一覧</title>
  </head>
  <body>
    <h1>ユーザー一覧</h1>
    <div style="width: 500px; background-color: #ffffe0; border: orange, solid, 10px;">

    <?php
    require_once '../db_config.php';

    try {
      //データベースとの接続を入力
      //データベース、文字コード、ユーザー名、パスワード指定
      $dbh = new  PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
      //PDO実行時のエラーモードを設定(どんな属性の情報を取得するか)
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //データベースとの操作を入力(1~10)
      $sql = "SELECT * FROM users";
      $stmt = $dbh->query($sql);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      echo "<table>\n";
      echo "<tr>\n";
      echo "<th>性</th><th>名</th><th>メールアドレス</th>\n";
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
      echo "</tabel>\n<br>";
      echo "<a href='create.html'>ユーザーを登録する</a>";
      //DB接続終了
      $dbh = null;


    } catch (Exception $e) {
      echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    }
    ?>

    </div>

  </body>
</html>
