<?php
try {
    $server_name = "10.42.129.3"; //サーバー名
    $db_name = "20grb1"; //データベース名
    $user_name = "20grb1";
    $user_pass = "20grb1";

    //データソース名設定
    $dsn = "sqlsrv:server=$server_name;database=$db_name";

    //PDOオブジェクトのインスタンス作成
    $pdo = new PDO($dsn, $user_name, $user_pass);

    //$PDOオブジェクトの属性の指定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print "接続エラー!:" . $e->getMessage();
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
    <link href="../css/mypage.css" rel="stylesheet" type="text/css">
    <title>マイページ</title>
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
            <form action="Result.php" method="GET">
                <select name="serchCondition">
                    <option value="b_title" selected>書籍</option>
                    <option value="autohr">作者</option>
                </select>
                <input type="text" name="serchWord">
                <input type="submit" value="🔍">
                <input type="button" value="詳細検索" onclick="location.href=''">
            </form>
        </div>
        <hr>
    </header>

    <main>
        <div class="float">
            <h3>レンタルライブラリ</h3>
            <select name="" id="" onchange="location.href=value;">
                <option value="" selected>フィルタを選択</option>
                <?php
                $c_code = 1;
                $sql1 = "SELECT DISTINCT rentaldate FROM rental WHERE c_code=? ORDER BY rentaldate DESC";
                try {
                    $stmt1 = $pdo->prepare($sql1);
                    $stmt1->execute(array($c_code));
                    $array1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                    $stmt1 = null;
                } catch (PDOException $e) {
                    print "SQL実行エラー！:" . $e->getMessage();
                    exit();
                }
                foreach ($array as $value) {
                    print "<option value=\".$value[rental_date].\"</option>";
                }
                ?>
            </select>
        </div>
        <table border="2" align="center" style="border-collapse: collapse">
            <?php
            $sql = "SELECT b_name,b_retalprice,rental_date,r_expiry";
            ?>
            <tr>
                <td>
                    <div class="item">
                        <img src="../image/ダウンロード.jpg" alt="賢者の石" width="200px" height="300px" class="bookPhoto" onclick="location.href='Detail.html'">
                        <div class="description">
                            <div class="btitle">
                                <p><b><a href="Detail.html">ハリーポッターと賢者の石</a></b></p>
                            </div>
                            <div class="mainInfo">
                                <p>レンタル購入日<br>xxxx/xx/xx</p>
                                <p>レンタル期限<br>~XXXX/XX/XX</p>
                                <p>レンタル価格<br>XXXX円</p>
                                <input type="button" value="読む">
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="item">
                        <img src="../image/ダウンロード.jpg" alt="賢者の石" width="200px" height="300px" class="bookPhoto" onclick="location.href='Detail.html'">
                        <div class="description">
                            <div class="btitle">
                                <p><b><a href="Detail.html">ハリーポッターと賢者の石</a></b></p>
                            </div>
                            <div class="mainInfo">
                                <p>レンタル購入日<br>xxxx/xx/xx</p>
                                <p>レンタル期限<br>~XXXX/XX/XX</p>
                                <p>レンタル価格<br>XXXX円</p>
                                <input type="button" value="読む">
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <!--同じページ遷移でレンタル履歴だけをすべての分表示？-->
        <div class="mottomiru">
            <p><a href="">もっと見る</a></p>
        </div>
        <hr>
        <div class="float">
            <h3>購入履歴</h3>
            <select name="" onchange="location.href=value;">
                <option value="" selected>フィルタを選択</option>
                <option value="/XXXX_xx_xx.html">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
            </select>
        </div>
        <table border="2" align="center" style="border-collapse: collapse">
            <tr>
                <td>
                    <div class="item">
                        <img src="../image/511X2B00B0L.jpg" alt="秘密の部屋" width="200px" height="300px" class="bookPhoto" onclick="location.href='Detail.html'">
                        <div class="description">
                            <div class="btitle">
                                <p><b><a href="Detail.html">ハリーポッターと秘密の部屋</a></b></p>
                            </div>
                            <div class="mainInfo">
                                <p>購入日<br>XXXX/XX/XX</p>
                                <p>受取日<br>XXXX/xX/xx</p>
                                <p>購入価格<br>XXXX円</p>
                                <input type="button" value="読む">
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="item">
                        <img src="../image/511X2B00B0L.jpg" alt="秘密の部屋" width="200px" height="300px" class="bookPhoto" onclick="location.href='Detail.html'">
                        <div class="description">
                            <div class="btitle">
                                <p><b><a href="Detail.html">ハリーポッターと秘密の部屋</a></b></p>
                            </div>
                            <div class="mainInfo">
                                <p>購入日<br>XXXX/XX/XX</p>
                                <p>受取日<br>XXXX/xX/xx</p>
                                <p>購入価格<br>XXXX円</p>
                                <input type="button" value="読む">
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="mottomiru">
            <p><a href="">もっと見る</a></p>
        </div>
    </main>
</body>

</html>