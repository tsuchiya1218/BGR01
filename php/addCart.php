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
// $cart = $_SESSION['cart'];
// $c_code = $_SESSION['c_code'];

$c_code = $_SESSION['c_code']; //セッションから顧客コード
$b_code = $_GET['b_code']; //本のコード パラメータ
$cart = $_GET['cart']; //カート種別　hidden
$price = $_GET['price']; //本の値段 hidden

//echo $c_code. $b_code. $cart.$price;


//カートに商品がすでに入ってるかどうかを確認
//$testsql = "SELECT COUNT(*) as co FROM buycart WHERE c_code = ? AND b_code ?";


//購入カート
if ($cart == 'buycart') {

    //buycart表からbc_codeをカウント
    $testsql = "SELECT COUNT(*) as co FROM buycart WHERE c_code = '" . $c_code . "' AND b_code ='" . $b_code . "'";
    $stmt = $pdo->prepare($testsql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_BOTH);

    if ($row['co'] != 0) {
        $_SESSION["eMsg"] = "既にカートに入っています。";
        // header("Location: $_SESSION);
    } else {

        $sql = "SELECT MAX(bc_buyCartCode) as bc_count FROM buycart";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            print "SQL 実行エラー!: " . $e->getMessage();
            exit();
        }
        $count[0] += 1;

        $sql = "INSERT INTO buycart(c_code,bc_buyCartCode,b_code,bc_qty,bc_totalamount)
                            VALUES(?,?,?,1,?)";
        try {
            $stmt = $pdo->prepare($sql);
            //SQL実行
            $stmt->execute(array($c_code, $count[0], $b_code, $price));
            $sql = null;
            $stmt = null;
        } catch (PDOException $e) {
            print "SQL 実行エラー!: " . $e->getMessage();
            exit();
        }
    }
    //予約カート
} else if ($cart == 'reservecart') {

    //reservecart表からbc_codeをカウント
    $testsql = "SELECT COUNT(*) as co FROM reservecart WHERE c_code = '" . $c_code . "' AND b_code ='" . $b_code . "'";
    $stmt = $pdo->prepare($testsql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_BOTH);

    if ($row['co'] != 0) {
        $_SESSION["eMsg"] = "既にカートに入っています。";
        // header("Location: $_SESSION);
    } else {

        $sql = "SELECT MAX(rc_reserveCartCode) as bc_count FROM reservecart";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_BOTH);
        } catch (PDOException $e) {
            print "SQL 実行エラー!: " . $e->getMessage();
            exit();
        }
        $count[0] += 1;

        $sql = "INSERT INTO reservecart(c_code,rc_reserveCartCode,b_code,bc_qty,bc_totalamount)
                            VALUES(?,?,?,1,?)";
        try {
            $stmt = $pdo->prepare($sql);
            //SQL実行
            $stmt->execute(array($c_code, $count[0], $b_code, $price));
            $sql = null;
            $stmt = null;
        } catch (PDOException $e) {
            print "SQL 実行エラー!: " . $e->getMessage();
            exit();
        }
    }
    //レンタルカート
} else if ($cart == 'rentalcart') {
    $testsql = "SELECT COUNT(*) as co FROM rentalcart WHERE c_code = '" . $c_code . "' AND b_code ='" . $b_code . "'";
    $stmt = $pdo->prepare($testsql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_BOTH);

    if ($row['co'] != 0) {
        $_SESSION["eMsg"] = "既にカートに入っています。";
        // header("Location: $_SESSION);
    } else {
        //rentalcart表からrtc_codeをカウント
        $sql = "SELECT MAX(rtc_code) as bc_count FROM rentalcart";
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_BOTH);
            $sql = null;
            $stmt = null;
        } catch (PDOException $e) {
            print "SQL 実行エラー!: " . $e->getMessage();
            exit();
        }
        $count [0]+=1;

        $sql = "INSERT INTO rentalcart(c_code,rtc_code,b_code,rtc_totalamount)
                            VALUES(?,?,?,?)";
        try {
            $stmt = $pdo->prepare($sql);
            //SQL実行
            $stmt->execute(array($c_code, $count[0],$b_code,$price));
            $sql = null;
            $stmt = null;
        } catch (PDOException $e) {
            print "SQL 実行エラー!: " . $e->getMessage();
            exit();
        }
    }
}
header("Location:buyCart.php");
