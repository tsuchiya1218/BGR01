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
//cartが購入だった場合
if ($_SESSION['cart'] == 'buy') {
    try {
        $c_code = $_GET['c_code'];
        $buy_code = $_SESSION['buy_code'];
        $sql = "SELECT bc_qty,bc_totalamount FROM buycart  WHERE c_code = ? AND buy_code = ?";
        // SQL 文を準備
        $stmt = $dbh->prepare($sql);
        // SQL 文を実行
        $stmt->execute(array($c_code, $buy_code));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
    } catch (PDOException $e) {
        print "接続エラー!: " . $e->getMessage();
        exit();
    }
}
//cartがレンタルだった場合
if ($_SESSION['cart'] == 'retal') {
    try {
        $c_code = $_GET['c_code'];

        $rental = $_SESSION['rental'];
        $sql = "SELECT rtc_code,rtc_totalamount FROM rentalcart  WHERE c_code = ? AND rtc_code = ?";
        // SQL 文を準備
        $stmt = $dbh->prepare($sql);
        // SQL 文を実行
        $stmt->execute(array($c_code, $rental));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
    } catch (PDOException $e) {
        print "接続エラー!: " . $e->getMessage();
        exit();
    }
}
//cartがレンタルだった場合
if ($_SESSION['cart'] == 'reserve') {
    try {
        $c_code = $_GET['c_code'];

        $reserve = $_SESSION['reserve'];
        $sql = "SELECT rc_reserveCartCode,rc_totalamount FROM reservecart WHERE c_code = ? AND rc_reserveCartCode = ?";
        // SQL 文を準備
        $stmt = $dbh->prepare($sql);
        // SQL 文を実行
        $stmt->execute(array($c_code, $reserve));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
    } catch (PDOException $e) {
        print "接続エラー!: " . $e->getMessage();
        exit();
    }
}

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
            <form action="Result.php" method="post">
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

        if ($_GET['Acceptance'] == '郵送') {

            try {
                $s_region = $_GET['s_region'];
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

                        <div class="fl"><a href="../verification.php" class="btn"><?= $value['s_name']; ?></a></div>

                <?php
                    }
                } else {
                    print 's_regionのデータが入っていません';
                }
            } else {
                ?>
            <?php
                header('Location:payment.php');
            }
            ?>
            </div>
        <?php

        try {
            $s_region = $_GET['s_region'];
            $sql3 = "SELECT s_name,s_code FROM store  where s_region = ?";
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

                    <div class="fl"><a href="Verification.php?<?=$value['s_code']?>" class="btn"><?= $value['s_name']; ?></a></div>

            <?php
                }
            } else {
                header('Location:payment.php');
            }

            ?>
        </div>
    </main>
</body>

</html>