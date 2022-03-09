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


?>

<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/top.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/receiving_get.css" type="text/css">
    <title>支払選択</title>
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

        <h2>支払選択</h2>
        <form action="Verification.php" method="get">
            <?php
            try {
                // カートの種類
                $how_cart = $_SESSION['cart'];
                // お客様情報
                $c_code = $_GET['c_code'];
                // SQL 文を準備
                // $stmt = $pdo->prepare();
                // SQL 文を実行
                //$stmt->execute(array());
                // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                // $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // $stmt = null;
                // $pdo = null;
            } catch (PDOException $e) {
                print "接続エラー!: " . $e->getMessage();
                exit();
            }
            ?>
            <div>
                <input type="hidden"value="<?=$how_cart?>">
                <input type="hidden"value="<?=$c_code?>">
                <input type="radio" name="payment" value="コンビニ支払い" checked>コンビニ支払い
                <input type="radio" name="payment" value="クレジットカード払い">クレジットカード払い
                <input type="submit" value="次へ">
            </div>
        </form>
    </main>
</body>

</html>