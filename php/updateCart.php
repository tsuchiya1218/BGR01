<?php
    //データベースに接続する
    try {
<<<<<<< HEAD
        $server_name = "10.42.129.3";	// サーバ名
        $db_name = "20grb1";	// データベース名(自分の学籍番号を入力)

        $user_name = "20grb1";	// ユーザ名(自分の学籍番号を入力)
        $user_pass = "20grb1";	// パスワード(自分の学籍番号を入力)
=======
        $server_name = "10.42.129.3";    // サーバ名
        $db_name = "20grb1";    // データベース名(自分の学籍番号を入力)
        $user_name = "20grb1";    // ユーザ名(自分の学籍番号を入力)
        $user_pass = "20grb1";    // パスワード(自分の学籍番号を入力)
>>>>>>> 84cc037a5fe1d59c1c11fb83ad290e52d1d2bd0e

        // データソース名設定
        $dsn = "sqlsrv:server=$server_name;database=$db_name";

        // PDOオブジェクトのインスタンス作成
<<<<<<< HEAD
        $pdo = new PDO ($dsn, $user_name, $user_pass);

        // PDOオブジェクトの属性の指定
        $pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch ( PDOException $e ) {
        print "接続エラー!: " . $e->getMessage ();
        exit();
    }
=======
        $pdo = new PDO($dsn, $user_name, $user_pass);

        // PDOオブジェクトの属性の指定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "接続エラー!: " . $e->getMessage();
        exit();
    }

    //商品IDと数とカートの種類と顧客コードの値を受け取ってUPDATE文で更新
    $cart = $_GET['cart'];
    $qty = $_GET['qty'];
    $b_code = $_GET['b_code'];
    $c_code = $_GET['c_code'];
    
    if($cart==1){
        $sql = "UPDATE buycart
                SET    bc_qty = $qty
                WHERE　b_code = $b_code
                AND c_code = $c_code";
    }else if($cart==2){
        $sql = "UPDATE reservecart
                SET    rc_qty = $qty 
                WHERE　b_code = $b_code
                AND c_code = $c_code";
    }
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "SQL実行エラー！:" . $e->getMessage();
        exit();
    }
    header('Location:Cart.php');
>>>>>>> 84cc037a5fe1d59c1c11fb83ad290e52d1d2bd0e
?>