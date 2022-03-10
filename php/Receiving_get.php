<?php

session_start();
$c_code = $_SESSION['c_code']; //顧客コード

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

// カートの種類
$cart = $_SESSION['cart'];

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
    <link href="../js/inputtext.js" type="text/js">
    <title>受取方法選択</title>
</head>

<body>
    <header>
        <div id="top">
            <h1 id="title"><a href="top.php">BOOK ON</a></h1>
            <p id="subtitle">It's a book but it's not a book!</p>
            <div id="right">
                <input type="button" value="カートを見る" onclick="location.href='Cart.php'">
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
        <?php
        // cartがレンタルだったら
        // データがある場合
        if (isset($_GET['select'])) {
            // 中身が店舗だった場合
            if ($_GET['select'] == '店舗') {
        ?>
                <!-- 自宅と店舗受け取りを前のページの選択で表示を変える -->
                <h2>店舗受け取り</h2>
                <p>地域選択</p>
                <form action="Region.php" name="Acceptance" method="get" value="店舗">
                    <div class="flbox">
                        <div class="fl"><a href="Region.php?s_region=北海道" class="btn">北海道</a></div>
                        <div class="fl"><a href="Region.php?s_region=東北" class="btn">東北</a></div>
                        <div class="fl"><a href="Region.php?s_region=関東" class="btn">関東</a></div>
                        <div class="fl"><a href="Region.php?s_region=関西" class="btn">関西</a></div>
                        <div class="fl"><a href="Region.php?s_region=中部" class="btn">中部</a></div>
                        <div class="fl"><a href="Region.php?s_region=四国" class="btn">四国</a></div>
                        <div class="fl"><a href="Region.php?s_region=中国" class="btn">中国</a></div>
                        <div class="fl"><a href="Region.php?s_region=九州/沖縄" class="btn">九州/沖縄</a></div>
                    </div>
                </form>
            <?php

            } else {
                // 違う場合
            ?>
                <h2>自宅受け取り</h2>
                <?php
                // $sql = "SELECT * FROM customers WHERE c_code = ?";
                // Sample
                $sql = "SELECT * FROM customers WHERE c_code = ?";
                try {
                    // SQL 文を準備
                    $stmt = $pdo->prepare($sql);
                    // SQL 文を実行
                    $stmt->execute(array($c_code));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $sql = null;
                    $stmt = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                ?>

                <p>住所選択</p>

                <?php
                foreach ($array as $value) {
                ?>
                    <form action="Region.php" name="Acceptance" method="get" value="郵送">
                    <?php
                }
                    ?>
                    <input type="hidden" value="<?= $value['c_code'] ?>">
                    <input type="radio" name="address" id="add1" onclick="changeDisabled()" checked="checked">
                    <?= $value['c_address1'] ?><?= $value['c_address2'] ?><br>
                    <p>上記以外の住所を入力してください</p>
                    <input type="radio" name="address" id="add2" onclick="changeDisabled()">
                    <input type="text" id="inputtext" size="50" placeholder="住所を入力"></p>
                    <input type="hidden" name="Acceptance" value="郵送">
                    <input type="submit" value="次へ">
                    </form>
                <?php
            }
        } else {
                ?>
                <a>エラーが発生しました。最初からやり直してください。</a>
            <?php
        }
            ?>
    </main>
</body>
<script type="text/javascript">
    var text = document.getElementById("inputtext");
    text.disabled = true;

    var add1 = document.getElementById("add1");
    add1.addEventListener("click", function() {
        if (add1.checked) {
            text.disabled = true;
        }
    })
    var add2 = document.getElementById("add2");
    add2.addEventListener("click", function() {
        if (add2.checked) {
            text.disabled = false;
        }
    })
</script>

</html>