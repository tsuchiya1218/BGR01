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
    $selectSQL1 = "SELECT b_purchaseprice FROM book WHERE b_code = ?";
    $stmt1 = $pdo->prepare($selectSQL1);
    //SQL実行
    $stmt1 ->execute($b_code);
    //帰ってきた値を$array2に代入
    $array1 = $stmt->fetch(PDO::FetchBOTH);


    //buycart表からbc_codeをカウント
    $selectSQL2 = "SELECT COUNT(bc_code) as bc_county FROM　buycart";
    $stmt2 = $pdo->prepare($selectSQL2);
    //SQL実行
    $stmt2 ->execute();
    //帰ってきた値を$array2に代入
    $array2 = $stmt->fetch(PDO::FetchBOTH);


    //buycartを INSERT INTO table名() VALUES();
    $selectSQL3 =  "INSERT INTO buycart(bc_code,bc_qty,bc_totalamount,b_code)
        VALUES($array2['county'],1,$array1['b_purchaseprice'],$b_code);";
    $stmt3 = $pdo->prepare($selectSQL3);
    //SQL実行
    $stmt3 ->execute();


   } else if($b == 'rent'){
       //book表から$b_codeと一致した本の値段を取得
    $selectSQL4 = "SELECT b_purchaseprice FROM book b_code = ?";
    $stmt4 = $pdo->prepare($selectSQL4);
    //SQL実行
    $stmt4 ->execute($b_code);
    //帰ってきた値を$array3に代入
    $array3 = $stmt->fetch(PDO::FetchBOTH);
    

    //rentalcart表からrtc_codeをカウント
    $selectSQL5 = "SELECT COUNT(rtc_code) as rtc_county FROM rentalcart";
    $stmt5 = $pdo->prepare($selectSQL5);
    //SQL実行   
    $stmt5 -> execute();
    //帰ってきた値を$array4に代入
    $array4 = $stmt ->fetch(PDO::FetchBOTH);

    
    //rentalcartを INSERT INTO table名() VALUES();
    $selectSQL6 =  "INSERT INTO rentalcart(rtc_code,rtc_totalamount,b_code)
     VALUES(rtc_code,$array3['b_purchaseprice'],$b_code);";
     $stmt6 = $pdo->prepare($selectSQL6);
     //SQL実行
     $stmt ->execute();

}
    


?>