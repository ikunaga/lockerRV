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

          //データベースとの操作を入力(1~10)
          $sql = "SELECT * FROM lockers WHERE id <= 10;";
          $stmt = $dbh->query($sql);
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          //データベースとの操作を入力(11~20)
          $sql = "SELECT * FROM lockers WHERE id <= 20 AND id >= 11;";
          $stmt = $dbh->query($sql);
          $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
          //データベースとの操作を入力(21~30)
          $sql = "SELECT * FROM lockers WHERE id <= 30 AND id >= 21;";
          $stmt = $dbh->query($sql);
          $result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
          //データベースとの操作を入力(31~40)
          $sql = "SELECT * FROM lockers WHERE id <= 40 AND id >= 31;";
          $stmt = $dbh->query($sql);
          $result4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
          //データベースとの操作を入力(41~50)
          $sql = "SELECT * FROM lockers WHERE id <= 50 AND id >= 41;";
          $stmt = $dbh->query($sql);
          $result5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
          //データベースとの操作を入力(51~60)
          $sql = "SELECT * FROM lockers WHERE id <= 60 AND id >= 51;";
          $stmt = $dbh->query($sql);
          $result6 = $stmt->fetchAll(PDO::FETCH_ASSOC);

          echo "<table border=1>\n";
          echo "<tr>\n";
          echo "<th> </th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>\n";
          echo "</tr>\n";
          //1段目
          echo "<tr>\n";
          echo "<td>A</td>";
          foreach ($result as $row) {
            echo "<td>\n";
            echo "<a href=lockers/detail.php?id=" . htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8') . ">予約</a>" . "</td>\n";
          }
          echo "</tr>\n";
          //2段目
          echo "<tr>\n";
          echo "<td>B</td>";
          foreach ($result2 as $row) {
            echo "<td>\n";
            echo "" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</td>\n";
          }
          echo "</tr>\n";
          //3段目
          echo "<tr>\n";
          echo "<td>C</td>";
          foreach ($result3 as $row) {
            echo "<td>\n";
            echo "" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</td>\n";
          }
          echo "</tr>\n";
          //4段目
          echo "<tr>\n";
          echo "<td>D</td>";
          foreach ($result4 as $row) {
            echo "<td>\n";
            echo "" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</td>\n";
          }
          echo "</tr>\n";
          //5段目
          echo "<tr>\n";
          echo "<td>E</td>";
          foreach ($result5 as $row) {
            echo "<td>\n";
            echo "" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</td>\n";
          }
          echo "</tr>\n";
          //6段目
          echo "<tr>\n";
          echo "<td>F</td>";
          foreach ($result6 as $row) {
            echo "<td>\n";
            echo "" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</td>\n";
          }
          echo "</tr>\n";
          echo "</tabel>\n";
          //DB接続終了
          $dbh = null;


        } catch (Exception $e) {
          echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        }
        ?>

    </div>


    <?php
      require_once "db_config.php";
      try {
        $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        if(@$_POST["line"] != "" OR @$_POST["step"] != ""){
          $stmt = $dbh->query("SELECT * FROM lockers WHERE line='".$_POST["line"] ."' AND step ='".$_POST["step"] ."';");
        }

      } catch (Exception $e) {
        echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        die();
      }

     ?>

    <div>
         <form action="index.php" method="post">
           列：<input type="text" name="line"><br>
           段：<input type="text" name="step"><br>
           <input type="submit">
         </form>
    </div>

    <table>
      <tr><th>line</th><th>step</th></tr>
      <!-- 結果をループさせる -->

      <?php foreach ($stmt as $row){ ?>
          <tr><td><?php echo $row[1]?></td><td><?php echo $row[2]?></td></tr>
      <?php } ?>
    </table>
  </body>
</html>
