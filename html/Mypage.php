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
            <form action="Result.html" method="GET">
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
            $rentalLimit;
            if ($_GET["rentalmotto"] = 1) {
                $sql2 = "SELECT b_code,b_name,b_thum,b_rentalprice,rental_date,r_expiry
                            FROM book 
                            RIGHT JOIN renatlcart ON book.b_code=rentalcart.b_code
                            RIGHT JOIN rental ON rentalcart.rentalcartcode=rental.rentalcartcode
                            WHERE c_code=?";
            } else {
                $sql2 = "SELECT b_code,b_name,b_thum,b_rentalprice,rental_date,r_expiry
                            FROM book 
                            RIGHT JOIN renatlcart ON book.b_code=rentalcart.b_code
                            RIGHT JOIN rental ON rentalcart.rentalcartcode=rental.rentalcartcode
                            WHERE c_code=? LIMIT 5";
            }
            try {
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute(array($c_code));
                $array2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                $stmt2 = null;
            } catch (PDOException $e) {
                print "SQL実行エラー！:" . $e->getMessage();
                exit();
            }
            foreach ($array as $key => $value) {
                print "<tr>";
                print "<td>";
                print "<div class=\"item\">";
                print "<img src=\"../image/{$value['d_thum']}.jpg\" alt=\"{$value['b_name']}\" width=\"200px\" height=\"300px\" class=\"bookPhoto\" onclick=\"location.href='Detail.html?b_code={$value['b_code']}'\">";
                print "<div class=\"description\">";
                print "<div class=\"btitle\">";
                print "<p><b><a href=\"Detail.html\">{$value['b_name']}</a></b></p>";
                print "</div>";
                print "<div class=\"mainInfo\">";
                print "<p>レンタル購入日<br>{$value['rental_date']}</p>";
                print "<p>レンタル期限<br>~{$value['r_expiry']}</p>";
                print "<p>レンタル価格<br>{$value['b_rentalprice']}円</p>";
                print "<input type=\"button\" value=\"読む\">";
                print "</div>";
                print "</div>";
                print "</div>";
                print "</td>";
                print "</tr>";
            }
            ?>
        </table>
        <!--同じページ遷移でレンタル履歴だけをすべての分表示？-->
        <div class="mottomiru">
            <p><a href="Mypage.php?rentalmotto=1">もっと見る</a></p>
        </div>
        <hr>
        <div class="float">
            <h3>購入履歴</h3>
            <select name="" onchange="location.href=value;">
                <option value="" selected>フィルタを選択</option>
                <?php
                    $sql3 = "SELECT DISTINCT buydate FROM buydetail WHERE c_code=? ORDER BY buydate DESC";
                    try {
                        $stmt3 = $pdo->prepare($sql3);
                        $stmt3->execute(array($c_code));
                        $array3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                        $stmt3 = null;
                    } catch (PDOException $e) {
                        print "SQL実行エラー！:" . $e->getMessage();
                        exit();
                    }
                    foreach ($array as $value) {
                        print "<option value=\".$value[buy_date].\"</option>";
                    }
                ?>
            </select>
        </div>
        <table border="2" align="center" style="border-collapse: collapse">
            <?php
                $buyLimit;
                if ($_GET["buymotto"] = 1) {
                    $sql2 = "SELECT b_code,b_name,b_thum,b_buyprice,b_buydate,b_getdate
                            FROM book
                            RIGHT JOIN buycart ON book.b_code=buycart.b_code
                            RIGHT JOIN buydetail ON buycart.buycartcode=buydetail.buycartcode
                            WHERE c_code=?";
                } else {
                    $sql2 = "SELECT b_code,b_name,b_thum,b_buyprice,b_buydate,b_getdate
                            FROM book
                            RIGHT JOIN buycart ON book.b_code=buycart.b_code
                            RIGHT JOIN buydetail ON buycart.buycartcode=buydetail.buycartcode
                            WHERE c_code=? LIMIT 5";
                }
                try {
                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->execute(array($c_code));
                    $array2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    $stmt2 = null;
                } catch (PDOException $e) {
                    print "SQL実行エラー！:" . $e->getMessage();
                    exit();
                }
                foreach ($array as $key => $value) {
                    print "<tr>";
                    print "<td>";
                    print "<div class=\"item\">";
                    print "<img src=\"../image/{$value['d_thum']}.jpg\" alt=\"{$value['b_name']}\" width=\"200px\" height=\"300px\" class=\"bookPhoto\" onclick=\"location.href='Detail.html?b_code={$value['b_code']}'\">";
                    print "<div class=\"description\">";
                    print "<div class=\"btitle\">";
                    print "<p><b><a href=\"Detail.html\">{$value['b_name']}</a></b></p>";
                    print "</div>";
                    print "<div class=\"mainInfo\">";
                    print "<p>購入日<br>{$value['b_buydate']}</p>";
                    print "<p>受取日<br>~{$value['b_getdate']}</p>";
                    print "<p>購入価格<br>{$value['b_purchaseprice']}円</p>";
                    print "</div>";
                    print "</div>";
                    print "</div>";
                    print "</td>";
                    print "</tr>";
                }
            ?>
        </table>
        <div class="mottomiru">
            <p><a href="Mypage.php?buymotto=1">もっと見る</a></p>
        </div>
    </main>
</body>

</html>