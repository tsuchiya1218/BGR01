<?php
    session_start();
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
    
    $b_code = $_GET['b_code'];
    $b_code = $_GET['c_code'];
    //buycart
    if(){
    try{
        $deletebuy = "DELETE FROM buycart WHERE $b_code = b_code";
        $stmtdeb = $pdo->prepare($deletebuy);
        $stmtdeb ->execute($b_code);
        $arraydeb = $stmt ->fetch(PDO::FetchBOTH);
    } catch ( PDOException $e ) {
    print "接続エラー!: " . $e->getMessage ();
    exit();
    }
    //reservecart
}elseif(){
    try{
        $d = "DELETE FROM reservecart WHERE $b_code = b_code";
    } catch ( PDOException $e ) {
        print "接続エラー!: " . $e->getMessage ();
        exit();
    }
    //rentalcart
}elseif(){
    try{
        $d = "DELETE FROM rentalcart WHERE $b_code = b_code";
    } catch ( PDOException $e ) {
        print "接続エラー!: " . $e->getMessage ();
        exit();
    }
}
    
?>