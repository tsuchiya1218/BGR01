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
<<<<<<< HEAD
    session_start();
    unset($_SESSION['b_thum']['b_name']['b_author']['b_publisher']['b_release']['b_purchaseprice']);


=======
    
    $b_code = $_GET['b_code'];
    $b = $_GET['b'];
    $c_code = $_GET['c_code'];
    //buycart
    if($b == 'buycart'){
    try{
        $deletebuy = "DELETE FROM buycart WHERE $b_code = b_code AND $c_code = c_code";
        $stmtdeb = $pdo->prepare($deletebuy);
        $stmtdeb ->execute();
        $arraydeb = $stmt ->fetch(PDO::FETCH_BOTH);
    } catch ( PDOException $e ) {
    print "接続エラー!: " . $e->getMessage ();
    exit();
    }
    //reservecart
}elseif($b == 'reservecart'){
    try{
        $deletereserve = "DELETE FROM reservecart WHERE $b_code = b_code AND $c_code = c_code";
        $stmtder = $pdo->prepare($deletereserve);
        $stmtder ->execute();
        $arrayder = $stmt ->fetch(PDO::FETCH_BOTH);
    } catch ( PDOException $e ) {
        print "接続エラー!: " . $e->getMessage ();
        exit();
    }
    //rentalcart
}elseif($b == 'rentalcart'){
    try{
        $deleterental = "DELETE FROM rentalcart WHERE $b_code = b_code AND $c_code = c_code";
        $stmtdel = $pdo->prepare($deleterental);
        $stmtdel ->execute();
        $arraydel = $stmt ->fetch(PDO::FETCH_BOTH);
    } catch ( PDOException $e ) {
        print "接続エラー!: " . $e->getMessage ();
        exit();
    }
}
>>>>>>> 84cc037a5fe1d59c1c11fb83ad290e52d1d2bd0e
    
?>