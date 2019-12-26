<!DOCTYPE html>
<html lang="ja">
<head>
  <title>ロッカー一覧（トップ画面）</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div id="wrapper">
    <header>
      <ul>
        <li style="background-color: white;"><a href="index.php" style="text-decoration: none;"><span>LockerRV</span></a>　(ロッカー予約管理システム)</li>
      </ul>
    </header>
    <div class="clearfix" style="margin-top: 80px;">
      <div style="background-color: white; width: 200px;">
        <h4 style="padding-left: 50px;">ロッカー一覧</h4>
      </div>
      <?php
      require_once 'db_config.php';
      try {
            //ロッカーをすべて取り出して配列に格納
            $sql = "SELECT * FROM lockers";
            $stmt = $dbh->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $lockerdata = array();
            foreach ($result as $row) {
              $lockerdata[$row['step']][$row['line']] = $row;
            }

            //予約テーブル結合→取り出し
            $sql_rv = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE start_date < NOW() < end_date AND approval = 1";
            $stmt_rv = $dbh->query($sql_rv);
            $result_rv = $stmt_rv->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result_rv as $row) {
              $reservedata[$row['locker_id']] = $row;
            }

            //ロッカー一覧テーブル
            echo "<table border=1 class='table1' style='background-color: white;'>\n";
            echo "<tr>\n";
            echo "<th> </th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>\n";
            echo "</tr>\n";
            $val = 1;
            foreach($lockerdata as $row) {
              echo "<tr>\n";
              echo "<th>" . $val . "</th>";
              foreach ($row as $key ) {
                  echo "<td>\n";
                  echo "<a href=lockers/detail.php?id=" . htmlspecialchars($key['id'],ENT_QUOTES,'UTF-8') . ">" . htmlspecialchars($key['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($key['step'],ENT_QUOTES,'UTF-8') . "</a>";
                  echo "<br>";
                  if (!empty($reservedata[$key['id']]['first_name'])) {
                  echo htmlspecialchars($reservedata[$key['id']]['first_name'], ENT_QUOTES, 'UTF-8');
                  }
                  echo "</td>\n";
              }
              echo "</tr>\n";
              $val++;
            }
            echo "</table>";
            $dbh = null;
        } catch (Exception $e) {
          echo "エラー発生： " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
        }
        ?>
  　　</div>

<!-- 検索スクリプト -->
      <?php
      // 位置検索
        try {
              $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
              $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
              $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

              if(!empty($_POST["line"]) AND !empty($_POST["step"])){
                $searchnull = "null";
                $stmt3 = $dbh->query("SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE line='".$_POST["line"] ."' AND step ='".$_POST["step"] ."' AND approval = 1;");
                $result_research = $stmt3->fetchAll(PDO::FETCH_ASSOC);
              }
        } catch (Exception $e) {
              echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
              die();
        }

      // 利用者検索
        try {
              $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
              $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
              $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

              if(!empty($_POST["first_name"]) AND !empty($_POST["last_name"])){
                $stmt2 = $dbh->query("SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE first_name ='".$_POST["first_name"] ."' AND last_name ='".$_POST["last_name"] ."' AND approval = 1");
                $result_research2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
              }
          } catch (Exception $e) {
              echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
              die();
          }
      ?>

<!-- 検索フォーム、結果表示 -->
    <div class="clearfix" style="margin-left: 200px; margin-top: 50px; margin-bottom: 100px;">
      <h4 style="border-bottom: double #dc143c; color: #dc143c; width: 70px;">Search</h4>
        <!-- 位置検索結果 -->
        <div class="search_form">
        <?php
            if (!isset($searchnull)) {
                echo "ロッカーの列/段番号を入力して利用者を検索できます。";
            }else{
                echo htmlspecialchars($_POST['line']) . "-" . htmlspecialchars($_POST['step']) . "を現在利用しているメンバー";
                echo "<br>";
                if(empty($result_research)) {
                  echo "<p style='font-size: 15px; color: red;'>このロッカーの利用者は現在いません。</p>";
                } else {
                  foreach ($result_research as $row){
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
               <input type="submit" value="実行" class="button">
             </form>
        </div>
        <!-- 利用者検索結果 -->
        <div class="search_form" style="margin-left: 80px;">
          <?php
          if (empty($stmt2)) {
                echo "姓名を入力して利用中のロッカーを検索できます。";
              } else {
                echo htmlspecialchars($_POST['first_name']) . htmlspecialchars($_POST['last_name']) . "さんが利用中のロッカー";
                echo "<br>";
                if (empty($result_research2)) {
                  echo "<p style='font-size: 15px; color: red;'>存在しないユーザーです。</p>";
                } else {
                  foreach ($result_research2 as $row){
                    echo $row['line'] . "-" . $row['step'];
                    echo "<br>";
                  }
                }
              }
          ?>
        <!-- 利用者検索フォーム -->
          <h5>利用者から検索</h5>
             <form action="index.php" method="post">
              性：<input type="text" name="first_name"><br>
              名：<input type="text" name="last_name"><br>
               <input type="submit" value="実行" class="button">
             </form>
        </div>
    </div>
    <?php include_once("./template/footer.tpl"); ?>
  </div>
</body>
</html>
