<?php
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

<!DOCTYPE html>
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
            <h1 id="title">BOOK ON</h1>
            <p id="subtitle">It's a book but it's not a book!</p>
            <div id="right">
                <input type="button" value="カートを見る">
                <input type="button" value="ログイン">
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
    <?php
        
    ?>
    <main>
        <h3>購入内容</h3>
        <div class="list">
            <div class="b_thum">
                <img class="thum" src="../image/chitei.jpg" alt="地底旅行">
            </div>
            <div class="other">
                <div class="b_name">
                    <a href="Detail.php?book_id=1" class="title">地底旅行</a>
                </div>
                <div class="b_price">
                    <a class="price">価格(税込)　&yen;847</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="list">
            <div class="b_thum">
                <img class="thum" src="../image/chikyuu.jpg" alt="地球の歩き方(インド)">
            </div>
            <div class="other">
                <div class="b_name">
                    <a href="Detail.php?book_id=2" class="title">地球の歩き方(インド)</a>
                </div>
                <div class="b_price">
                    <a class="price">価格(税込)　&yen;1900</a>
                </div>
            </div>
        </div>

        <hr>

        <div class="sp">
            <div class="amount">
                <div class="ap">
                    <a>合計金額</a>
                </div>
                <div class="a_price">
                    <a id="price">&yen;1670</a>
                </div>
            </div>
        </div>
        <div class="cp">
            <form method="post" aciton="">
                <input type="submit" value="支払い">
            </form>
        </div>
    </main>
</body>

</html>