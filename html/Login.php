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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/login.css" rel="stylesheet" type="text/css">
    <title>ログイン</title>
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
        <div class="top">
            <h4>ログイン</h4>
            <!--ログイン時はcustomersからメールアドレスとパスワードを参照-->
        </div>
        <div class="check">
            <div class="ip_check">
                <!--JavaScriptでIDとパスワードの英数字チェック-->
                <div class="i_check">
                    <a>ユーザID：</a>
                    <input type="email" maxlength="200" id="m_address">
                </div>
                <div class="p_check">
                    <a>パスワード：</a>
                    <input type="password" maxlength="10" id="pass">
                </div>
                <div class="l_check">
                    <input type="button" value="ログイン">
                    <!--ログイン前のページに戻る時はセッション情報にログイン前のページを保存-->
                </div>
            </div>
        </div>
    </main>
</body>

</html>