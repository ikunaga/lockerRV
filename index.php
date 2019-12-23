<!DOCTYPE html>
<html lang="ja">
<head>
  <title>ロッカー一覧（トップ画面）</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <header>
    <ul>
      <li><span>LockerRV</span></li>
      <!-- <li style="margin-left: 900px;">使い方：</li>
      <li>1.予約したいロッカーをクリック</li>
      <li>index</li> -->
    </ul>
  </header>
  <div class="clearfix" style="margin-top: 80px;">
        <h4 style="padding-left: 50px;">ロッカー一覧</h4>

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
            $sql2 = "SELECT * FROM lockers WHERE id <= 20 AND id >= 11;";
            $stmt = $dbh->query($sql2);
            $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //データベースとの操作を入力(21~30)
            $sql3 = "SELECT * FROM lockers WHERE id <= 30 AND id >= 21;";
            $stmt = $dbh->query($sql3);
            $result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //データベースとの操作を入力(31~40)
            $sql4 = "SELECT * FROM lockers WHERE id <= 40 AND id >= 31;";
            $stmt = $dbh->query($sql4);
            $result4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //データベースとの操作を入力(41~50)
            $sql5 = "SELECT * FROM lockers WHERE id <= 50 AND id >= 41;";
            $stmt = $dbh->query($sql5);
            $result5 = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //データベースとの操作を入力(51~60)
            $sql6 = "SELECT * FROM lockers WHERE id <= 60 AND id >= 51;";
            $stmt = $dbh->query($sql6);
            $result6 = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<table border=1 class='table1'>\n";
            echo "<tr>\n";
            echo "<th> </th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>\n";
            echo "</tr>\n";
            //1段目
            echo "<tr>\n";
            echo "<td>A</td>";
            foreach ($result as $row) {
              echo "<td>\n";
              echo "<a href=lockers/detail.php?id=" . htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8') . ">" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</a>";
              echo "<br>";
              $sql7 = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date < NOW() < end_date AND approval = 1";

              $stmt = $dbh->prepare($sql7);
              $stmt->bindValue(1, $row['id'], PDO::PARAM_INT);
              $stmt->execute();
              $result7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result7 as $row2) {
                echo htmlspecialchars($row2['first_name'], ENT_QUOTES, 'UTF-8');
              }
              echo "</td>\n";
            }
            echo "</tr>\n";
            //2段目
            echo "<tr>\n";
            echo "<td>B</td>";
            foreach ($result2 as $row) {
              echo "<td>\n";
              echo "<a href=lockers/detail.php?id=" . htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8') . ">" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</a>";
              echo "<br>";
              $sql7 = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date < NOW() < end_date AND approval = 1";

              $stmt = $dbh->prepare($sql7);
              $stmt->bindValue(1, $row['id'], PDO::PARAM_INT);
              $stmt->execute();
              $result7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result7 as $row2) {
                echo htmlspecialchars($row2['first_name'], ENT_QUOTES, 'UTF-8');
              }
              echo "</td>\n";
            }
            echo "</tr>\n";
            //3段目
            echo "<tr>\n";
            echo "<td>C</td>";
            foreach ($result3 as $row) {
              echo "<td>\n";
              echo "<a href=lockers/detail.php?id=" . htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8') . ">" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</a>";
              echo "<br>";
              $sql7 = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date < NOW() < end_date AND approval = 1";

              $stmt = $dbh->prepare($sql7);
              $stmt->bindValue(1, $row['id'], PDO::PARAM_INT);
              $stmt->execute();
              $result7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result7 as $row2) {
                echo htmlspecialchars($row2['first_name'], ENT_QUOTES, 'UTF-8');
              }
              echo "</td>\n";
            }
            echo "</tr>\n";
            //4段目
            echo "<tr>\n";
            echo "<td>D</td>";
            foreach ($result4 as $row) {
              echo "<td>\n";
              echo "<a href=lockers/detail.php?id=" . htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8') . ">" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</a>";
              $sql7 = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date < NOW() < end_date AND approval = 1";

              $stmt = $dbh->prepare($sql7);
              $stmt->bindValue(1, $row['id'], PDO::PARAM_INT);
              $stmt->execute();
              $result7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result7 as $row2) {
                echo htmlspecialchars($row2['first_name'], ENT_QUOTES, 'UTF-8');
              }
              echo "</td>\n";
            }
            echo "</tr>\n";
            //5段目
            echo "<tr>\n";
            echo "<td>E</td>";
            foreach ($result5 as $row) {
              echo "<td>\n";
              echo "<a href=lockers/detail.php?id=" . htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8') . ">" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</a>";
              $sql7 = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date < NOW() < end_date AND approval = 1";

              $stmt = $dbh->prepare($sql7);
              $stmt->bindValue(1, $row['id'], PDO::PARAM_INT);
              $stmt->execute();
              $result7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result7 as $row2) {
                echo htmlspecialchars($row2['first_name'], ENT_QUOTES, 'UTF-8');
              }
              echo "</td>\n";
            }
            echo "</tr>\n";
            //6段目
            echo "<tr>\n";
            echo "<td>F</td>";
            foreach ($result6 as $row) {
              echo "<td>\n";
              echo "<a href=lockers/detail.php?id=" . htmlspecialchars($row['id'],ENT_QUOTES,'UTF-8') . ">" . htmlspecialchars($row['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($row['step'],ENT_QUOTES,'UTF-8') . "</a>";
              $sql7 = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date < NOW() < end_date AND approval = 1";

              $stmt = $dbh->prepare($sql7);
              $stmt->bindValue(1, $row['id'], PDO::PARAM_INT);
              $stmt->execute();
              $result7 = $stmt->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result7 as $row2) {
                echo htmlspecialchars($row2['first_name'], ENT_QUOTES, 'UTF-8');
              }
              echo "</td>\n";
            }
            echo "</tr>\n";
            echo "</table>\n";
            //DB接続終了
            $dbh = null;


          } catch (Exception $e) {
            echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
          }
          ?>
    </div>


    <?php
  // 位置検索
      require_once "db_config.php";
      try {
        $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        if(@$_POST["line"] != "" OR @$_POST["step"] != ""){
          $stmt3 = $dbh->query("SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE line='".$_POST["line"] ."' AND step ='".$_POST["step"] ."';");
        }

      } catch (Exception $e) {
        echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        die();
      }


  // 利用者検索
      require_once "db_config.php";
      try {
        $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        if(@$_POST["first_name"] != "" OR @$_POST["last_name"] != ""){
          $stmt2 = $dbh->query("SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE first_name ='".$_POST["first_name"] ."' AND last_name ='".$_POST["last_name"] ."';");
        }

      } catch (Exception $e) {
        echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        die();
      }
  ?>

<!-- 以下検索結果表示 -->
  <div style="margin-left: 200px; margin-top: 50px;">
      <!-- 位置検索結果 -->
      <div class="search_form">
      <?php
          if (empty($_POST['line'])) {
              echo "ロッカーの列/段番号を入力して利用者を検索できます。";
            }else{
              echo htmlspecialchars($_POST['step']) . "-" . htmlspecialchars($_POST['line']) . "を現在利用しているメンバー";
              echo "<br>";
              foreach ($stmt3 as $row){
                if(empty($row['id'])) {
                  echo "このロッカーの利用者は現在いません。";
                } else {
                echo $row['first_name'] . $row['last_name'];
                echo "<br>";
                }
              }
          }
     ?>
  <!-- 位置検索フォーム -->
        <h5>ロッカー番号から検索</h5>
           <form action="index.php" method="post">
             列：<input type="text" name="line"><br>
             段：<input type="text" name="step"><br>
             <input type="submit">
           </form>
      </div>
  <!-- 利用者検索結果 -->
      <div class="search_form" style="margin-left: 100px;">
        <?php
        if (empty($_POST['first_name'])) {
              echo "姓名を入力して利用中のロッカーを検索できます。";
            } else {
              echo htmlspecialchars($_POST['first_name']) . htmlspecialchars($_POST['last_name']) . "さんが利用中のロッカー";
              echo "<br>";
              foreach ($stmt2 as $row){
                echo $row['step'] . "-" . $row['line'];
                echo "<br>";
              }
            }
            ?>

<!-- 利用者検索フォーム -->
        <h5>利用者から検索</h5>
           <form action="index.php" method="post">
            性：<input type="text" name="first_name"><br>
            名：<input type="text" name="last_name"><br>
             <input type="submit">
           </form>
      </div>
  </div>
</body>
</html>
