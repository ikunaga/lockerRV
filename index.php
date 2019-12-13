<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>ロッカー一覧（トップ画面）</title>
  </head>
  <body>
    <h1>ロッカー一覧</h1>
    <div style="width: 500px; background-color: #ffffe0; border: orange, solid, 10px;">

<?php
require_once 'db_config.php';

try {
  //データベースとの接続を入力
  //データベース、文字コード、ユーザー名、パスワード指定
  $dbh = new  PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
  //PDO実行時のエラーモードを設定(どんな属性の情報を取得するか)
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //データベースとの操作を入力
  $sql = "SELECT * FROM lockers";
  $stmt = $dbh->query($sql);

  // SQL分の結果の取り出し
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo "<table>\n";
  echo "<tr>\n";
  echo "<th> </th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th>\n";
  echo "</tr>\n";
  foreach ($result as $row) {
    echo "<tr>\n";
    echo "<td>1</td>";
    echo "<td>\n";
    echo "" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</td>\n";
    echo "</tr>\n";
  }
  echo "</tabel>\n";
  //DB接続終了
  $dbh = null;


} catch (Exception $e) {
  echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
}
?>

  </body>
</html>
