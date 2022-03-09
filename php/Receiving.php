<?php
session_start();
$c_code = $_SESSION['c_code'];//顧客コード
$cart = $_SESSION['cart'];//カート種別

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

<?php
    // お客様情報
    // 購入
    $Cart = array('buycart' => 0, 'reservecart' => 1, 'rentalcart' => 2);
    //サンプル $c_code = '1';
    // $sql = "SELECT * FROM store where c_code WHERE c_code = ?";

    $sql = "SELECT * FROM store where c_code WHERE c_code = ?";
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array($c_code));
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
    } catch (PDOException $e) {
        print "接続エラー!: " . $e->getMessage();
        exit();
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
    <title>受取方法選択</title>
</head>

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
                <input type="text" name="" id="">
                <input type="submit" value="🔍">
            </form>
        </div>
        <hr>
    </header>
    <main>
        <div align="center">
            <p>受取方法</p>
            <form action="Receiving_get.php" method="GET">
                <input type="hidden" value="<?= $cart?>">
                <input type="hidden" value="<?= $c_code?>">
                <input type="radio" name="select" value="店舗">店舗
                <input type="radio" name="select" value="郵送" checked>郵送
                <input type="submit" value="次へ">
            </form>
        </div>
    </main>
</body>

</html>