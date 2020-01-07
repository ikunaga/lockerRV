<?php
//@全体
  //ユーザー名/パスワード指定
  $user = "ikunaga";
  $pass = "PhpAdmin2019";
  // $user = "m-ikunaga";
  // $pass = "kS8NVyxI";

  //データベースとの接続を入力（接続情報、出力エラー指定）
  $dbh = new  PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


// @index
  //ロッカーをすべて取り出して配列に格納
  function getLckrlist($dbh){
    $sql = "SELECT * FROM lockers";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $lockerdata = array();
    foreach ($result as $row) {
      $lockerdata[$row['step']][$row['line']] = $row;
    }
    return $lockerdata;
  }

  //予約テーブル結合→取り出し
  function getRvApproved($dbh){
    $sql_rv = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE start_date < NOW() < end_date AND approval = 1";
    $stmt_rv = $dbh->query($sql_rv);
    $result_rv = $stmt_rv->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_rv as $row) {
      $reservedata[$row['locker_id']] = $row;
    }
    return $reservedata;
  }

  //@lockers/detail
  //予約テーブルをinnnerjoin結合したうえで、ロッカーIDに紐づくものを取り出し
  function getRvLckrid($dbh,$id){
    $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  //SQL２「現在の利用者検索」
  function getRvApprovedLckridNow($dbh,$id){
    $sql = "SELECT * FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id WHERE locker_id = ? AND start_date < NOW() < end_date AND approval = 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  //SQL３「ロッカー検索」(@lockers/reserveでも使用)
  function getLckrid($dbh,$id){
    $sql = "SELECT * FROM lockers WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  //id存在チェック
  function getLckridCount($dbh,$id){
    $sql_lckrid = "SELECT COUNT(*) FROM lockers WHERE id = ?";
    $stmt_lckrid = $dbh->prepare($sql_lckrid);
    $stmt_lckrid->bindValue(1, $id, PDO::PARAM_STR);
    $stmt_lckrid->execute();
    $result_lckrid = $stmt_lckrid->fetchColumn(0);
    return $result_lckrid;
  }

//@locker/reserve
  //ユーザーすべて取り出し（@user/indexでも使用）
  function getUsrAll($dbh){
    $sql = "SELECT * FROM users";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

//@locker/reserveact
  //SQL１「innnerjoin結合」（エラーチェック用）
  function getRvApprovedLckrid($dbh,$locker_id){
    $sql = "SELECT * FROM reservations
    INNER JOIN users ON reservations.user_id = users.id
    INNER JOIN lockers ON reservations.locker_id = lockers.id
    WHERE locker_id = ? AND approval = 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $locker_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  //SQL２「予約レコード作成」
  function InsertRv($dbh,$start_date,$end_date,$user_id,$locker_id){
    $sql = "INSERT INTO reservations (start_date, end_date, user_id, locker_id) VALUES (?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $start_date, PDO::PARAM_STR);
    $stmt->bindValue(2, $end_date, PDO::PARAM_STR);
    $stmt->bindValue(3, $user_id, PDO::PARAM_INT);
    $stmt->bindValue(4, $locker_id, PDO::PARAM_INT);
    $stmt->execute();
  }

//@reservation/index
  //予約テーブルを結合して呼び出し　※id判別用にas使用
  function getRvAs($dbh){
    $sql = "SELECT
    reservations.id as reservation_id,
    reservations.start_date,
    reservations.end_date,
    reservations.approval,
    lockers.line,
    lockers.step,
    users.first_name,
    users.last_name
    FROM reservations INNER JOIN users ON reservations.user_id = users.id INNER JOIN lockers ON reservations.locker_id = lockers.id";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

//@users/detail
  //ユーザーID検索
  function getUsrid($dbh, $id){
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  //ユーザーid存在チェック
  function getUsridCount($dbh, $id){
    $sql_userid = "SELECT COUNT(*) FROM users WHERE id = ?";
    $stmt_userid = $dbh->prepare($sql_userid);
    $stmt_userid->bindValue(1, $id, PDO::PARAM_STR);
    $stmt_userid->execute();
    $result_userid = $stmt_userid->fetchColumn(0);
    return $result_userid;
  }

//@users/delete
//SQL１「ユーザー削除」
function deleteUsr($dbh, $id){
  $sql = "DELETE FROM users WHERE id = ?";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();
}
?>
