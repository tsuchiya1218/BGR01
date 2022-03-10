<?php

session_start();
if (!empty($_SESSION['cart'])) {
    $_SESSION['cart'] = null;
}
if (!empty($_SESSION['url'])) {
    $_SESSION['url'] = null;
}
$_SESSION['cart'] = 'reservecart';
$_SESSION['url'] = 'reservecart.php';
$c_code = $_SESSION['c_code'];

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

$sql = "SELECT b_name,b_author,b_publisher
         ,b_release,b_thum,b_purchaseprice FROM book  ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$array = $stmt->fetchAll();

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

$c_code = 1;

?>

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
            <select name="searchCondition">
                <option value="b_title">書籍</option>
                <option value="author">作者</option>
            </select>
            <input type="text" name="searchWord">
            <input type="submit" value="🔍">
        </div>
        <hr>
    </header>
    <main>
        <ul id="tab">
            <li><a href="./buyCart.php">購入</a>
            </li>
            <li><a href="./reserveCart.php">予約</a>
            </li>
            <li><a href="./rentalCart.php">レンタル</a>
            </li>
        </ul>
        <hr>
        <?php
        //"SELECT b_name,b_author,b_publisher,b_release
        //      ,b_purchaseprice,b_thum" FROM book WHERE $b_code = b_code

        $sql = "SELECT book.b_code,b_name,rc_reserveCartCode,b_author,b_publisher,b_release,b_purchaseprice,b_thum
                            FROM book 
                            INNER JOIN reservecart
                            ON book.b_code = reservecart.b_code 
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
            echo "カートの中に商品がありません。";
        } else {
            if (!empty($_SESSION['emsg'])) {
                //deleteCart.phpに接続できない場合
                //addCart.phpに接続できない場合
                //updateCart.phpに接続できない場合
                echo $_SESSION['emsg'];
            }
        ?>
            <form method="get" action="Receiving.php">
                <table class="product">
                    <?php
                    foreach ($array as $value) {
                    ?>
                        <tr>
                            <!--書籍のDB化-->
                            <!--value="500"-->
                            <td class="img">
                                <a href="Detail.php?b_code=<?= $value['b_code'] ?>"><img src="../image/<?= $value['b_thum'] ?>" alt="<? $value['b_name'] ?>" height="250" width="200"></a>
                            </td>
                            <td class="main">
                                <a href="Detail.php?b_code=<?= $value['b_code'] ?>"><?= $value['b_name'] ?></a>
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
                                    <a>&yen;<?= $value['b_purchaseprice'] ?></a>
                                </div>
                                <div class="qty">
                                    <a>数量<input type="number" id="qty" value="1" name="<?= $value['rc_reserveCartCode'] ?>"></a>
                                    <button type="button"><a href="updateCart.php?rc_reserveCartCode=<?= $value['rc_reserveCartCode'] ?>">変更</a></button>
                                </div>
                            </td>
                            <td class="delete">
                                <button type="button"><a href="deleteCart.php?rc_reserveCartCode=<?= $value['rc_reserveCartCode'] ?>">削除</a></button>
                            </td>
                        </tr>
                        <hr>
                    <?php
                    }
                    ?>
                </table>
                <input type="submit" value="支払い手続きへ">
            </form>
        <?php
        }
        ?>
    </main>
    <footer>

    </footer>
</body>

</html>