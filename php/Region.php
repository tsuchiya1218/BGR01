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
        <h2>店舗選択</h2>
        <p>該当店舗</p>
        <?php
        $s_region = $_GET['s_region'];
        $sql = "SELECT s_name,s_region FROM store where s_region = ?";
        // SQL 文を準備
        try {
            $stmt = $dbh->prepare($sql);
            // SQL 文を実行
            $stmt->execute(array($s_region));
            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $sql = null;
            $stmt = null;
        } catch (PDOException $e) {
            print "接続エラー!: " . $e->getMessage();
            exit();
        }
        ?>

        <div class="flbox">
            <?php
            // s_regionのデータが入っていた場合
            if (isset($s_region)) {
                foreach ($array as $value) {
            ?>
                    <div class="fl"><a href="verification.php" class="btn"><?= $value['s_name']; ?></a></div>
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