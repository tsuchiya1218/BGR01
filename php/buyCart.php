<?php
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

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/cart.css" rel="stylesheet" type="text/css">
    <title>カート内容確認</title>
</head>
<?php

//$変数 = $_GET[''];
//$b_code = $_GET['b_code'];

?>

<body>
    <header>
        <div id="top">
            <h1 id="title"><a href="Top.html">BOOK ON</a></h1>
            <p id="subtitle">It's a book but it's not a book!</p>
            <div id="right">
                <input type="button" value="カートを見る" onclick="location.href='Cart.php'">
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
                <input type="text" name="serchWord">
                <input type="submit" value="🔍">
                <input type="button" value="詳細検索" onclick="location.href=''">
            </form>
        </div>
        <hr>
    </header>
    <main>
        <?php

        //サンプルデータ
        $c_code = 1;

        //"SELECT b_name,b_author,b_publisher,b_release
        //      ,b_purchaseprice,b_thum" FROM book WHERE $b_code = b_code

        $sql = "SELECT book.b_code,b_name,b_author,b_publisher,b_release,b_rentalprice,b_thum
                            FROM book 
                            inner join rentalcart
                            ON book.b_code = rentalcart.b_code
                            WHERE c_code = ?";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($c_code));
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $sql = null;
            $stmt = null;
        } catch (PDOException $e) {
            print "SQL 実行エラー!: " . $e->getMessage();
            exit();
        }
        if (empty($array)) {
            echo "カートの中に商品がありません。<br>";
        }
        foreach ($array as $value) {
        ?>
            <div class="product">
                <!--書籍のDB化-->
                <!-- checkbox value price -->
                <div class="checkbox">
                    <input type="checkbox" id="check" onclick="calcTotal(<?= $value['b_purchaseprice'] ?>)">
                    <!--$value['b_purchaseprice']-->
                </div>
                <!--value="500"-->
                <form method="get" action="./Detail.php">
                    <div class="img">
                        <a href="./Detail.php?b_code=<?= $value['b_code'] ?>"><img src="../image/<?= $value['b_thum'] ?>" alt="地底旅行" height="250" width="200"></a>
                    </div>
                </form>
                <div class="main">
                    <a href="./Detail.php?b_code=<?= $value['b_code'] ?>"><?= $value['b_name'] ?></a>
                    <!--著者-->
                    <div class="description">
                        <a><?= $value['b_author'] ?></a>
                        <!--出版社-->
                        <a><?= $value['b_publisher'] ?></a>
                        <!--発行年月-->
                        <a><?= $value['b_release'] ?></a>
                    </div>
                    <div class="price">
                        <a>価格（税込）</a>
                        <a>&yen;<?= $value['b_rentalprice'] ?></a>
                    </div>
                    <div class="qty">
                        <a>数量<input type="number" id="qty" value="1" class="counter"></a>
                    </div>
                </div>
                <div class="delete">
                    <form action="./deleteCart.php" method="GET">
                        <!--<input type="hidden" name="" value=""-->
                        <input type="reset" value="削除">
                        <!--購入した商品一つをカートから削除-->
                    </form>
                </div>
            </div>
            <hr>
        <?php
        }
        ?>
        <div class="receive">
            <form method="get" action="Receiving.php">
                <input type="submit" value="支払い手続きへ">
            </form>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>