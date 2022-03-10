<?php

session_start();
$_SESSION['c_code'] = 1;

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
    <link href="../css/top.css" rel="stylesheet" type="text/css">
    <title>トップページ</title>
</head>

<body>
<header>
        <div id="top">

            <h1 id="title"><a href="Top.html">BOOK ON</a></h1>
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
        <div class="RankAndNew">
            <div class="Rank ">
                <h2>ランキング</h2>
                <ol class="ranking ">
                    <li>aaaaa</li>
                    <li>bbbbb</li>
                    <li>cc</li>
                    <li>dddddddddd</li>
                    <li>eeeee</li>
                    <!--購入数ランキング50位までの本を検索結果として表示する画面に遷移-->
                    <small><a href="Result.php?rank=rank" name="rank" class="mottomiru">もっと見る</a></small>
                </ol>
            </div>
            <div class="New">
                <h2>新刊本</h2>
                <ul>
                    <li>1111</li>
                    <li>22222222</li>
                    <li>33</li>
                    <li>44</li>
                    <li>55555</li>
                    <!--発行から2週間以内の本を検索結果として表示する画面に遷移-->
                    <small><a href="Result.php?new=new" name="new" class="mottomiru">もっと見る</a></small>
                </ul>
            </div>
        </div>
    </main>
</body>

</html>