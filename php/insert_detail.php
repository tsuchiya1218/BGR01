<?php

session_start();
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
$cart = $_SESSION['cart'];
$c_code = $_SESSION['c_code'];
$select = $_SESSION['select'];

if($cart=='buycart'){
    
}else if($cart=='reservecart'){

}else if($cart=='rentalcart'){

}
?>