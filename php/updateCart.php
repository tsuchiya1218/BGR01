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

    //商品IDと数とカートの種類と顧客コードの値を受け取ってUPDATE文で更新
    

    $cart = $_SESSION['cart'];
    $c_code = $_SESSION['c_code'];
    
    if($cart=='buycart'){
        $sql = "UPDATE buycart
                SET    bc_qty = $qty
                WHERE　bc_buyCartCode = ?
                AND c_code = ?";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($cart,$c_code));
        } catch (PDOException $e) {
            print "SQL実行エラー！:" . $e->getMessage();
            exit();
        }
        header('Location:Cart.php');
    }else if($cart=='reservecart'){
        $sql = "UPDATE reservecart
                SET    rc_qty = $qty 
                WHERE　rc_reserveCartCode = ?
                AND c_code = ?";
        try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($cart));
        } catch (PDOException $e) {
            print "SQL実行エラー！:" . $e->getMessage();
            exit();
        }
        header('Location:Cart.php');
    }
    ?>