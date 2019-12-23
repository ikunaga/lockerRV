<?php
require_once '../db_config.php';

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $mail = $_POST['mail'];
  // $created_at = $_POST['created_at'];

  try {
    $dbh = new PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
    //PDO実行時のエラーモードを設定
        //「プリペアドステートメント」のエミュレーションをPDO側で行うかどうかを設定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        //PDO::ERRMODE_EXCEPTION を設定すると例外をスローしてくれる
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //データベースにSQLをセット
    $sql = "INSERT INTO users (first_name, last_name, mail ) VALUES (?, ?, ?)";
    $stmt = $dbh->prepare($sql);

    //プレースホルダの値を指定
    $stmt->bindValue(1, $first_name, PDO::PARAM_STR);
    $stmt->bindValue(2, $last_name, PDO::PARAM_STR);
    $stmt->bindValue(3, $mail, PDO::PARAM_STR);
    // $stmt->bindValue(4, $created_at, PDO::PARAM_DATETIME);
    // $stmt->bindValue(5, $updated_at, PDO::PARAM_DATETIME);

    //指定したSQLを実行して、データベースとの接続を終了
    $stmt->execute();
    $dbh = null;

    //画面にメッセージを表示
    echo "ユーザーの登録が完了しました。<br>";
    echo "<a href=create.html>登録画面に戻る</a>";
  } catch (Exception $e) {
    echo "エラー発生：" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
    die();
  }
 ?>
