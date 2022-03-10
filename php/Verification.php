<?php

session_start();
$cart = $_SESSION['cart'];
$c_code = $_SESSION['c_code'];

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
?>

<html lang="ja">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/verification.css" rel="stylesheet" type="text/css">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <div id="top">
            <h1 id="title"><a href="top.php">BOOK ON</a></h1>
            <p id="subtitle">It's a book but it's not a book!</p>
            <div id="right">
                <input type="button" value="カートを見る" onclick="location.href='buycart.php'">
                <input type="button" value="マイページ" onclick="location.href='Mypage.php' ">
            </div>
        </div>
        <hr>
        <div align="center">
            <form method="get" action="./Result.php">
                <select name="searchCondition">
                    <option value="b_title">書籍</option>
                    <option value="author">作者</option>
                </select>
                <input type="text" name="searchWord">
                <input type="submit" value="🔍">
            </form>
        </div>
        <hr>
    </header>
    <main>
        <?php
        if (!empty($cart)) {
            if ($cart == 'buycart') {
                $sql = "SELECT * FROM buycart INNER JOIN book  ON buycart.b_code = book.b_code
                        WHERE buycart.c_code = ?";
                try {
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute(array($c_code));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $sql = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
            } elseif ($cart == 'reservecart') {
                $sql = "SELECT * FROM reservecart INNER JOIN book ON reservecart.b_code = book.b_code
                            WHERE reservecart.c_code = ?";
                try {
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute(array($c_code));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $sql = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
            } elseif ($cart == 'rental') {
                $sql = "SELECT * FROM rentalcart INNER JOIN book ON rentalcart.b_code = book.b_code 
                            WHERE rentalcart.c_code = ?";
                try {
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute(array($c_code));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $sql = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
            }
            //サムネイルのみ取り出し
            /*$sql = "SELECT b_thum FROM book WHERE b_code = ?";
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array($b_code));
                // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = null;
                $sql = null;
            } catch (PDOException $e) {
                print "SQL 実行エラー!: " . $e->getMessage();
                exit();
            }*/
        ?>
            <h3>購入内容</h3>
            <table border="2" align="center" style="border-collapse: collapse">
                <?php
                foreach ($array as $value) {
                ?>
                    <tr>
                        <td class="list">
                            <img class="thum" src="../image/<?= $value['b_thum'] ?>" alt="<?= $value['b_name'] ?>">
                            <div class="other">
                                <div class="b_name">
                                    <p class="title"><?= $value['b_name'] ?></p>
                                </div>
                                <div class="b_price">
                                    <?php if ($cart == 'buycart') { ?>
                                        <p class="qty">購入個数：<?= $value['bc_qty'] ?></p>
                                        <p class="price">金額：&yen;<?= $value['b_purchaseprice'] ?></p>
                                        <p class="amountprice">小計：&yen;<?= $value['bc_totalamount'] ?></p>
                                    <?php } else if ($cart == 'reservecart') { ?>
                                        <p class="qty">購入個数:<?= $value['rc_qty'] ?></a>
                                        <p class="price">金額：&yen;<?= $value['b_purchaseprice'] ?></a>
                                        <p class="amountprice">小計：&yen;<?= $value['rc_totalamount'] ?></p>
                                    <?php } else { ?>
                                        <p class="price">レンタル金額：<?= $value['b_rentalprice'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
        }
        ?>
        <div class="sp">
            <div class="amount">
                <div class="ap">
                    <a>合計金額</a>
                </div>
                <div class="a_price">
                    <a id="price">&yen;<input type="text" name="totalprice"></a>
                </div>
            </div>
        </div>
        <div class="cp">
            <form method="GET" action="./insert_detail.php">
                <input type="submit" value="購入">
            </form>
        </div>
    </main>
</body>

</html>