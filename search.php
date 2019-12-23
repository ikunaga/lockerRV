<?php
require_once "db_config.php";
try {
  $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
  $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  if(@$_POST["line"] != "" OR @$_POST["step"] != ""){
    $stmt = $dbh->query("SELECT * FROM lockers WHERE line='".$_POST["line"] ."' OR step ='".$_POST["step"] ."';");
  }

} catch (Exception $e) {
  echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}

 ?>
