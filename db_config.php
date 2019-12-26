<?php
//ユーザー名/パスワード指定
$user = "ikunaga";
$pass = "PhpAdmin2019";
// $user = "m-ikunaga";
// $pass = "kS8NVyxI";
// $user = "root";
// $pass = "1234";


//データベースとの接続を入力
//データベース、文字コード、ユーザー名、パスワード指定
$dbh = new  PDO('mysql:host=localhost;dbname=locker_rv;charset=utf8',$user,$pass);
//PDO実行時のエラーモードを設定(どんな属性の情報を取得するか)
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

 ?>
