<?php

session_start();

    //データベースに接続する
    try {
        $server_name = "10.42.129.3";    // サーバ名
        $db_name = "20grb1";    // データベース名(自分の学籍番号を入力)

        $user_name = "20grb1";    // ユーザ名(自分の学籍番号を入力)
        $user_pass = "20grb1";    // パスワード(自分の学籍番号を入力)

        // データソース名設定
        $dsn = "sqlsrv:server=$server_name;database=$db_name";

        // PDOオブジェクトのインスタンス作成
        $pdo = new PDO($dsn, $user_name, $user_pass);
        // PDOオブジェクトの属性の指定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "接続エラー!: " . $e->getMessage();
        exit();
    }

$cart = $_SESSION['cart'];
$c_code = $_SESSION['c_code'];
$url  = $_SESSION['url'];

    //buycart
    if($cart == 'buycart'){

        $cart_code = $_GET['bc_buyCartCode'];
        $sql = "DELETE FROM buycart WHERE bc_buyCartCode = ? AND c_code = ?";	

        try{

            $stmt = $pdo->prepare($sql);
            $stmt -> execute(array($cart_code,$c_code));

        } catch (PDOException $e) {
            print "接続エラー!: " . $e->getMessage();
            exit();
        }

        //reservecart
    } elseif ($cart == 'reservecart') {

	$cart_code = $_GET['rc_reserveCartCode'];
	$sql = "DELETE FROM reservecart  WHERE rc_reserveCartCode = ? AND c_code = ?";

        try {

            $stmt = $pdo->prepare($sql);
            $stmt -> execute(array($cart_code,$c_code));

        } catch (PDOException $e) {
            print "接続エラー!: " . $e->getMessage();
            exit();
        }

        //rentalcart
    } elseif ($cart == 'rentalcart') {

	$cart_code = $_GET['rtc_code'];
	$sql = "DELETE FROM rentalcart WHERE rtc_code = ? AND c_code = ?";

        try {

            $stmt = $pdo->prepare($sql);
            $stmt -> execute(array($cart_code,$c_code));

        } catch (PDOException $e) {
            print "接続エラー!: " . $e->getMessage();
            exit();
        }
    } else{
        $_SESSION['emsg'] = '削除できませんでした';
    }

header("Location:$url");
?>