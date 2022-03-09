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


    $c_code = $_GET['c_code'];
    $c = $_GET['c'];

    //購入カート
    if($b == 'buy'){
        //book表から$b_codeと一致した本の値段を取得
        $selectSQLprice = "SELECT b_purchaseprice FROM book WHERE b_code = ?";
        $stmtprice = $pdo->prepare($selectSQLprice);
        //SQL実行
        $stmtprice ->execute($b_code);
        //帰ってきた値を$arraypriceに代入
        $arrayprice = $stmt->fetch(PDO::FETCH_BOTH);


        //buycart表からbc_codeをカウント
        $selectSQLcount = "SELECT COUNT(bc_code) as bc_county FROM　buycart";
        $stmtcount = $pdo->prepare($selectSQLcount);
        //SQL実行
        $stmtcount ->execute();
        //帰ってきた値を$arraycountに代入
        $arraycount = $stmt->fetch(PDO::FETCH_BOTH);


        //b_code,c_codeの値がある場合前のページに戻し、updatecartの作業として入る
        //値がない場合は新しい書籍としての判断、addcart内のINSERTに行く。
        $buys = "SELECT * FROM buycart WHERE c_code = $c_code
                    AND b_code = $b_code";
        if(isset($buys)){
        // $buys = $_POST['buys'];
        // $HTTP = $_SERVER['HTTP_REFERER'];
        // $URL = parse_url($HTTP);
        // $HOST = $URL['host'];
        

        }else{
        
        //buycartとして新しくカートに追加
        //$insertSQLbuy =  "INSERT INTO buycart(bc_code,bc_qty,bc_totalamount,b_code)VALUES($arraycount['bc_county'],1,$arrayprice['b_purchaseprice'],$b_code);";
        $stmtbuy = $pdo->prepare($insertSQLbuy);
        //SQL実行
        $stmtbuy ->execute();
        }

    //予約カート
    }else if($b == 'reserve'){
        //book表から$b_codeと一致した本の値段を取得
        $selectSQLprice = "SELECT b_purchaseprice FROM book b_code =?";
        $stmtprice = $pdo->prepare($selectSQLprice);
        $stmtprice ->execute($b_code);
        $arrayprice = $stmt ->fetch(PDO::FETCH_BOTH);

        //rentalcart表からrtc_codeをカウント
        $selectSQLcount = "SELECT COUNT(rc_code) as rc_county FROM reservecart";
        $stmtcount = $pdo->prepare($selectSQLcount);
        $stmtcount ->execute();
        $arraycount = $stmt ->fetch(PDO::FETCH_BOTH);

        $reserves = "SELECT * FROM reservecart WHERE c_code = $c_code
                    AND b_code = $b_code";
        if(isset($reserves)){
            // $reserves = $_POST['reserves'];
            // $HTTP = $_SERVER['HTTP_REFERER'];
            // $URL = parse_url($HTTP);
            // $HOST = $URL['host'];
            // echo $HOST;
        }else{
            //reservecartとして新しくカートに追加
            //$insertSQLreserve = "INSERT INTO reservecart(rc_code,rc_totalamount,b_code,b_qty)VALUES($arraycount['rc_county'],$arrayprice['b_purchaseprice'],$b_code,1)";
            $stmtreserve =$pdo->prepare($insertSQLreserve);
            $stmtreserve ->execute();
        }

    //レンタルカート
    } else if($b == 'rent'){
        //book表から$b_codeと一致した本の値段を取得
        $selectSQLprice = "SELECT b_purchaseprice FROM book b_code = ?";
        $stmtprice = $pdo->prepare($selectSQLprice);
        //SQL実行
        $stmtprice ->execute($b_code);
        //帰ってきた値を$arraypriceに代入
        $arrayprice = $stmt->fetch(PDO::FETCH_BOTH);
        

        //rentalcart表からrtc_codeをカウント
        $selectSQLcount = "SELECT COUNT(rtc_code) as rtc_county FROM rentalcart";
        $stmtcount = $pdo->prepare($selectSQLcount);
        //SQL実行   
        $stmtcount -> execute();
        //帰ってきた値を$arraycountに代入
        $arraycount = $stmt ->fetch(PDO::FETCH_BOTH);

        $rentals = "SELECT * FROM rentalcart WHERE c_code = $c_code
                    AND b_code = $b_code";
        if(isset($rentals)){
            // $rentals = $_POST['rentals'];
            // $HTTP = $_SERVER['HTTP_REFERER'];
            // $URL = parse_url($HTTP);
            // $HOST = $URL['host'];
            // echo $HOST;
        }else{
            //rentalcartとして新しくカートに追加
            //$insertSQLrental =  "INSERT INTO rentalcart(rtc_code,rtc_totalamount,b_code)VALUES($arraycount[rtc_county],$arrayprice['b_purchaseprice'],$b_code);";
            $stmtrental = $pdo->prepare($insertSQLrental);
            //SQL実行
            $stmtrental ->execute();
        }
    }
?>