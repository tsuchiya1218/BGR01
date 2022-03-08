<?php
//データベースに接続する
session_start();
try {
    $server_name = "10.42.129.3";    // サーバ名
    $db_name = "20grb1";    // データベース名(自分の学籍番号を入力)

    $user_name = "20grb1";    // ユーザ名(自分の学籍番号を入力)
    $user_pass = "20grb1";    // パスワード(自分の学籍番号を入力)

    // データソース名設定
    $dsn = "sqlsrv:server=$server_name;database=$db_name";

    // PDOオブジェクトのインスタンス作成
    $dbh = new PDO($dsn, $user_name, $user_pass);

    // PDOオブジェクトの属性の指定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "接続エラー!: " . $e->getMessage();
    exit();
}

?>
<?php
    
    // c_codeでお客様情報を受け取る
    $how_c = $_SESSION['c_code'];
 



    // cartからbuyまたはreserveまたはrentalを受け取る
    $how_cart = $_SESSION['cart'];
    // buyだった場合
    if($_SESSION['cart'] == 'buy'){
        try {
            $sql = "SELECT bc_buyCartCode,c_code FROM store  where bc_buyCartCode = c_code and c_code=?";
            // SQL 文を準備
            $stmt = $dbh->prepare($sql);
            // SQL 文を実行
            $stmt->execute(array($s_region));
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
        } catch (PDOException $e) {
            print "接続エラー!: " . $e->getMessage();
            exit();
        }
    }
    // reserveだった場合 
    if ($_SESSION['cart'] == 'reserve') {
        try {
            $sql1 = "SELECT rc_reserveCartCode,c_code FROM store  where rc_reserveCartCode = c_code and c_code=?";
            // SQL 文を準備
            $stmt = $dbh->prepare($sql);
            // SQL 文を実行
            $stmt->execute(array($s_region));
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
        } catch (PDOException $e) {
            print "接続エラー!: " . $e->getMessage();
            exit();
        }
    }
    // rentalだった場合
    if ($_SESSION['retal'] == 'rental') {
        try {
            $sql2 = "SELECT rental_code,c_code FROM store  where rental_code = c_code and c_code=?";
            // SQL 文を準備
            $stmt = $dbh->prepare($sql);
            // SQL 文を実行
            $stmt->execute(array($s_region));
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
        } catch (PDOException $e) {
            print "接続エラー!: " . $e->getMessage();
            exit();
        }
    }

    // どのcartか
    $_SESSION['cartinfo'] => array("how_get"=>array('cart'=$_SESSION['cart'],'c_code'=$_SESSION['c_code'],'howrec'=$_SESSION['howrec']));
?>

<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/top.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/region.css" type="text/css">
    <title>受取方法選択</title>
</head>

<body>
    <header>
        <div id="top">
            <h1 id="title"><a href="Top.html">BOOK ON</a></h1>
            <p id="subtitle">It's a book but it's not a book!</p>
            <div id="right">
                <input type="button" value="カートを見る" onclick="location.href='Cart.html'">
                <input type="button" value="ログイン">
            </div>
        </div>
        <hr>
        <div align="center">
<<<<<<< HEAD:html/Region.php

            <form action="Result.html" method="post">
=======
            <form action="Result.php" method="post">
>>>>>>> 432758e1d48b5cefa8e77668743aa77254aa9b29:php/Region.php
                <select name="" id="">
                    <option value="">書籍</option>
                    <option value="">作者</option>
                </select>
                <input type="text" name="" id="">
                <input type="submit" value="🔍">
                <input type="button" value="詳細検索" onclick="location.href=''">
            </form>
        </div>
        <hr>
    </header>
    <main>
        <h2>店舗選択</h2>
        <p>該当店舗</p>
        <?php
        try {
            $s_region=$_GET['s_region'];
            $sql3 = "SELECT s_name,s_region FROM store  where s_region = ?";
            // SQL 文を準備
            $stmt = $dbh->prepare($sql3);
            // SQL 文を実行
            $stmt->execute(array($s_region));
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
        } catch (PDOException $e) {
            print "接続エラー!: " . $e->getMessage();
            exit();
        }
        ?>
        <div class="flbox">
            <?php
            // s_regionのデータが入っていた場合
            if (isset($_GET['s_region'])) {
                foreach ($array as $value) {


            ?>

                <div class="fl"><a href="../html/verification.php" class="btn"><?= $value['s_name']; ?></a></div>

            <?php
                }
            } else {
                echo 's_regionのデータが入っていません';
            }

            ?>
        </div>
    </main>
</body>

</html>