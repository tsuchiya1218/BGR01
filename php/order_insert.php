<?php
session_start();
$cart = $_SESSION['cart']; //カート種別
$c_code = $_SESSION['c_code']; //顧客コード 
$get_method = $_SESSION['select']; //受取方法

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
    print "接続エラー!: " . $e->getMessage() . "<br/>";
    die();
}

//buydetailにデータが入ってるかどうか確認
$sql = 'SELECT count(*) as cnt FROM buydetail';

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $array = $stmt->fetch(PDO::FETCH_BOTH);
    $stmt = null;
} catch (PDOException $e) {
    //print "SQL実行エラー！:" . $e->getMessage();
    echo $e;
    exit();
}
//buydetailにデータが入っていなかったばあい
//データを1とする

$num = $array['cnt'] + 1;

if ($cart == 'buycart') {
    $buy_date = date('Y-m-d');
    $get_date = date("Y-m-d", strtotime("+1 hour"));
    $deliverydate = date('Y-m-d');
    $sql = 'SELECT * FROM buycart WHERE c_code = ?';
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($c_code));
        $array = $stmt->fetchAll(PDO::FETCH_BOTH);
    } catch (PDOException $e) {
        //print "SQL実行エラー！:" . $e->getMessage();
        echo $e;
        exit();
    }
    foreach ($array as $value) {
        $sql = 'INSERT INTO buydetail(c_code,buy_code,bd_buydate,bd_deliverydate,get_method,bc_buycartcode)
                            VALUES(?,?,?,?,?,?)';
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($c_code, $num, $buy_date, $deliverydate,1,$value['bc_buyCartCode']));
        } catch (PDOException $e) {
            //print "SQL実行エラー！:" . $e->getMessage();
            echo $e;
            exit();
        }
        $num +=1;
    }


    $sql = "DELETE FROM buycart WHERE c_code = ?";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($cart_code, $c_code));
    } catch (PDOException $e) {
        print "接続エラー!: " . $e->getMessage();
        exit();
    }
    $sql = null;
    $stmt = null;

    header('location:../html/Order_completion.html');
} else if ($cart == 'reservecart') {
    $cartcode = 'rc_reserveCartCode';
} else {
    $cartcode = 'rtc_code';
}
