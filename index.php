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
            $lockerdata = getLckrlist($dbh);
            //予約テーブル結合→取り出し
            $reservedata = getRvApproved($dbh);

            //ロッカー一覧テーブル
            echo "<table border=1 class='table1' style='background-color: white;'>\n";
            echo "<tr style='background-color: #ffe4e1;'>\n";
            echo "<th style='background-color: #eee8aa;'> </th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>\n";
            echo "</tr>\n";
            $val = 1;
            foreach($lockerdata as $row) {
              echo "<tr>\n";
              echo "<th style='background-color: #fffacd;'>" . $val . "</th>";
              foreach ($row as $key ) {
                  echo "<td>\n";
                  echo "<a href=lockers/detail.php?id=" . htmlspecialchars($key['id'],ENT_QUOTES,'UTF-8') . ">" . htmlspecialchars($key['line'],ENT_QUOTES,'UTF-8') . "-" . htmlspecialchars($key['step'],ENT_QUOTES,'UTF-8') . "</a>";
                  echo "<br>";
                  if (!empty($reservedata[$key['id']]['first_name'])) {
                  echo "<span style='font-size: 15px; color: #6b8e23; font-weight: 500px;'>" . htmlspecialchars($reservedata[$key['id']]['first_name'], ENT_QUOTES, 'UTF-8') . "</span>";
                } else {
                  echo "<span style='font-size: 15px; color: #d2b48c;'>空き</span>";
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
                //入力されたロッカー番号に紐づく予約のうち、承認されているものを取り出し
                $stmt3 = $dbh->query("SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE line='".$_POST["line"] ."' AND step ='".$_POST["step"] ."' AND approval = 1;");
                $result_research = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                //入力されたロッカーが存在するか検索
                $stmt_lckrexist = $dbh->query("SELECT * FROM lockers WHERE line='".$_POST["line"] ."' AND step ='".$_POST["step"] ."'");
                $result_lckrexist = $stmt_lckrexist->fetchAll(PDO::FETCH_ASSOC);
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
                //予約レコードのうち、入力されたユーザーのもの　かつ　承認になっているものを取り出し
                $stmt2 = $dbh->query("SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE first_name ='".$_POST["first_name"] ."' AND last_name ='".$_POST["last_name"] ."' AND approval = 1");
                $result_research2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                //入力されたユーザーが存在するか検索
                $stmt_usrexist = $dbh->query("SELECT * FROM users WHERE first_name ='".$_POST["first_name"] ."' AND last_name ='".$_POST["last_name"] ."'");
                $result_usrexist = $stmt_usrexist->fetchAll(PDO::FETCH_ASSOC);
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
            if (empty($_POST["line"]) AND empty($_POST["step"])) {
                echo "列/段番号を入力して利用者を検索できます。";
            } elseif(empty($_POST["line"]) OR empty($_POST["step"])) {
                echo "<span style='font-size: 15px; color: red;'>列と段の両方を入力してください。</span>";
            } elseif(empty($result_lckrexist)){
                echo "<span style='font-size: 15px; color: red;'>存在しないロッカー番号です。</span>";
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
               <input type="submit" value="検索" class="button" style="margin-left: 280px; width: 80px;">
             </form>
        </div>
        <!-- 利用者検索結果 -->
        <div class="search_form" style="margin-left: 80px;">
          <?php
          if (empty($_POST["first_name"]) AND empty($_POST["last_name"])) {
                echo "姓名を入力して利用中のロッカーを検索できます。";
              } elseif(empty($_POST["first_name"]) OR empty($_POST["last_name"])) {
                echo "<span style='font-size: 15px; color: red;'>姓名の両方を入力してください。</span>";
              } elseif(empty($result_usrexist)){
                  echo "<span style='font-size: 15px; color: red;'>存在しないユーザーです。</span>";
              } else {
                echo htmlspecialchars($_POST['first_name']) . htmlspecialchars($_POST['last_name']) . "さんが利用中のロッカー";
                echo "<br>";
                if (empty($result_research2)) {
                  echo "<p style='font-size: 15px; color: red;'>現在ありません。</p>";
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
            <input type="submit" value="検索" class="button" style="margin-left: 280px; width: 80px;">
          </form>
        </div>
    </div>
    <?php include_once("./template/footer.tpl"); ?>
  </div>
</body>
</html>
