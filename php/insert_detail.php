<?php

session_start();
$cart = $_SESSION['cart']; //カート種別
$c_code = $_SESSION['c_code']; //顧客コード 
$select = $_SESSION['select']; //受取方法

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

$sql = 'SELECT count(buy_code) FROM buydetail';

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
} catch (PDOException $e) {
    print "SQL実行エラー！:" . $e->getMessage();
    exit();
}
if($array==null){
    $array[0] = 1;
}else{
    $array[0] +=1;
}
if($select == 'store'){//店舗
    $get_method = 1;
}else{//郵送
    $get_method = 2;
}

if($cart == 'buycart'){
    $cartcode = 'bc_buyCartCode';
    $buy_date = date('Y-m-d');
    $get_date = date("Y-m-d",strtotime("+1 hour"));
    $deliverydate = $get_date;

    $sql = 'INSERT INTO buydetail(c_code,buy_code,bd_buydate,bd_deliverydate,get_method,bc_buycartcode)
                        VALUES(?,?,?,?,?,?)';
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($c_code,$array[0],$buy_date,$deliverydate,$get_method,$cartcode));
    } catch (PDOException $e) {
        print "SQL実行エラー！:" . $e->getMessage();
        exit();
    }
    $sql = "DELETE FROM buycart WHERE c_code = ?";	

    try{
        $stmt = $pdo->prepare($sql);
        $stmt -> execute(array($cart_code,$c_code));
    } catch (PDOException $e) {
        print "接続エラー!: " . $e->getMessage();
        exit();
    }
    $sql = null;
    $stmt = null;

    header('location:../html/Order_completion.html');

}else if($cart == 'reservecart'){
    $cartcode = 'rc_reserveCartCode';
}else{
    $cartcode = 'rtc_code';
}
