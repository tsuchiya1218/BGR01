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
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/top.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/receiving_get.css" type="text/css">
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
            <form action="Result.html" method="post">
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
        <?php
        /*
        session_start();

        $how_cart = $_SESSION['cart'];
        //$how_cartはnullじゃなかったら
        if (!($how_cart == null)) {
            // $how_cartがレンタルだったら
            if ($how_cart == 'rental') {
                // Verification.phpに遷移する
                header("../html/Verification.php");
                exit;
            } 
            */
        ?>

        <?php

        
        // データがある場合
        if (isset($_GET['select'])) {

            // 中身が店舗だった場合
            if ($_GET['select'] == '店舗') {
        ?>

                <!-- 自宅と店舗受け取りを前のページの選択で表示を変える -->
                <h2>店舗受け取り</h2>
                <p>地域選択</p>
                <form action="../html/Region.php" method="get">
                    <div class="flbox">
                        <div class="fl"><a href="../html/Region.php?s_region=北海道" class="btn">北海道</a></div>
                        <div class="fl"><a href="../html/Region.php?s_region=東北" class="btn">東北</a></div>
                        <div class="fl"><a href="../html/Region.php?s_region=関東" class="btn">関東</a></div>
                        <div class="fl"><a href="../html/Region.php?s_region=関西" class="btn">関西</a></div>
                        <div class="fl"><a href="../html/Region.php?s_region=中部" class="btn">中部</a></div>
                        <div class="fl"><a href="../html/Region.php?s_region=四国" class="btn">四国</a></div>
                        <div class="fl"><a href="../html/Region.php?s_region=中国" class="btn">中国</a></div>
                        <div class="fl"><a href="../html/Region.php?s_region=九州/沖縄" class="btn">九州/沖縄</a></div>
                    </div>
                </form>
            <?php
            } else {
                // 違う場合
            ?>

                <h2>自宅受け取り</h2>
                <p>住所選択</p>
                <form action="Verification.html" method="POST">
                    <input type="radio" name="memberaddress" value="会員情報の住所の表示">会員情報の住所を表示
                    <input type="radio" name="memberaddress" 　onClick="setr()">
                    <input type="text" name="1" size="50" placeholder="住所を入力" disabled></p>
                    <input type="submit" value="次へ">
                </form>
        <?php
            }
        } else {
            echo "selectのデータが入っていません";
        }
        //} 
        ?>
    </main>
</body>
<script>
    function setr() {
        activ = document.myFROM;
        if (activ['select'].checked) {
            activ['1'].disabled = false;
        } else {
            activ['1'].disabled = true;
        }
    }
</script>

</html>