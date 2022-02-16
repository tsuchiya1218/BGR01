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

$b_code = $_GET['b_code'];
$b = $_GET['b'];


if($b == 'buy'){
    //book表から$b_codeと一致した本の値段を取得
    $selectSQLprice = "SELECT b_purchaseprice FROM book WHERE b_code = ?";
    $stmtprice = $pdo->prepare($selectSQLprice);
    //SQL実行
    $stmtprice ->execute($b_code);
    //帰ってきた値を$array2に代入
    $arrayprice = $stmt->fetch(PDO::FetchBOTH);


    //buycart表からbc_codeをカウント
    $selectSQLcount = "SELECT COUNT(bc_code) as bc_county FROM　buycart";
    $stmtcount = $pdo->prepare($selectSQLcount);
    //SQL実行
    $stmtcount ->execute();
    //帰ってきた値を$array2に代入
    $arraycount = $stmt->fetch(PDO::FetchBOTH);


    //buycartを INSERT INTO table名() VALUES();
    $insertSQLbuy =  "INSERT INTO buycart(bc_code,bc_qty,bc_totalamount,b_code)
                        VALUES($arraycount['county'],1,$arrayprice['b_purchaseprice'],$b_code);";
    $stmtbuy = $pdo->prepare($insertSQLbuy);
    //SQL実行
    $stmtbuy ->execute();


   } else if($b == 'rent'){
       //book表から$b_codeと一致した本の値段を取得
    $selectSQLprice = "SELECT b_purchaseprice FROM book b_code = ?";
    $stmtprice = $pdo->prepare($selectSQLprice);
    //SQL実行
    $stmtprice ->execute($b_code);
    //帰ってきた値を$array3に代入
    $arrayprice = $stmt->fetch(PDO::FetchBOTH);
    

    //rentalcart表からrtc_codeをカウント
    $selectSQLcount = "SELECT COUNT(rtc_code) as rtc_county FROM rentalcart";
    $stmtcount = $pdo->prepare($selectSQLcount);
    //SQL実行   
    $stmtcount -> execute();
    //帰ってきた値を$array4に代入
    $arraycount = $stmt ->fetch(PDO::FetchBOTH);


    //rentalcartを INSERT INTO table名() VALUES();
    $insertSQLrental =  "INSERT INTO rentalcart(rtc_code,rtc_totalamount,b_code)
                        VALUES($arraycount[rtc_county],$arrayprice['b_purchaseprice'],$b_code);";
     $stmtrental = $pdo->prepare($insertSQLrental);
     //SQL実行
     $stmtrental ->execute();

}else if($b == 'reserve'){
    //book表から$b_codeと一致した本の値段を取得
    $selectSQLprice = "SELECT b_purchaseprice FROM book b_code =?";
    $stmtprice = $pdo->prepare($selectSQLprice);
    $stmtprice ->execute($b_code);
    $arrayprice = $stmt ->fetch(PDO::FetchBOTH);

    //rentalcart表からrtc_codeをカウント
    $selectSQLcount = "SELECT COUNT(rc_code) as rc_county FROM reservecart";
    $stmtcount = $pdo->prepare($selectSQLcount);
    $stmtcount ->execute();
    $arraycount = $stmt ->fetch(PDO::FetchBOTH);

    //reservecartを　INSERT INTO table名() VALUES();
    $insertSQLreserve = "INSERT INTO reservecart(rc_code,rc_totalamount,b_code,b_qty)
                        VALUES($arraycount(rc_county),$arrayprice[b_purchaseprice],$b_code,1)";
     $stmtreserve =$pdo->prepare($insertSQLreserve);
     $stmtreserve ->execute();

}

?>