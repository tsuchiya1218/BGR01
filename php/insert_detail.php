<?php
try {
    $dsn = 'sqlsrv:server=10.42.129.3;database=20grb1';
    $user = '20grb1';
    $password = '20grb1';
    //PDOオブジェクトの作成
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "接続エラー!: " . $e->getMessage() . "<br/>";
    die();
}

?>