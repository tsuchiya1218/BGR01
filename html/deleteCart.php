<?php
    //データベースに接続する
    try {
        $server_name = "10.42.129.3";	// サーバ名
        $db_name = "20grb1";	// データベース名(自分の学籍番号を入力)

        $user_name = "20grb1";	// ユーザ名(自分の学籍番号を入力)
        $user_pass = "20grb1";	// パスワード(自分の学籍番号を入力)

        // データソース名設定
        $dsn = "sqlsrv:server=$server_name;database=$db_name";

        // PDOオブジェクトのインスタンス作成
        $pdo = new PDO ($dsn, $user_name, $user_pass);

        // PDOオブジェクトの属性の指定
        $pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch ( PDOException $e ) {
        print "接続エラー!: " . $e->getMessage ();
        exit();
    }
    session_start();
    unset($_SESSION['b_code']);
    
?>