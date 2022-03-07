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
            <select name="" onchange="location.href=value">
                <option value="" selected>フィルタを選択</option>
                <?php
                $c_code = 1;
                $sql1 = "SELECT DISTINCT renral_date FROM rental WHERE c_code=? ORDER BY renral_date DESC";
                try {
                    $stmt1 = $pdo->prepare($sql1);
                    $stmt1->execute(array($c_code));
                    $array1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                    $stmt1 = null;

                } catch (PDOException $e) {
                    print "SQL実行エラー！:" . $e->getMessage();
                    exit();
                }
                foreach ($array1 as $value) {
                    print "<option value=\"Mypage.php?rentaldate={$value['renral_date']}\">{$value['renral_date']}</option>";
                }
                ?>
            </select>
        </div>
        <table border="2" align="center" style="border-collapse: collapse">
            <?php
            try {
                if (isset($_POST['mottomiru'])) {
                    $sql2 = "SELECT book.b_code,b_name,b_author,b_publisher,b_release,b_rentalprice,b_code,b_thum,b_synopsis1,b_synopsis2,b_synopsis3,renral_date,r_expiry
                            FROM book
                            INNER JOIN rental ON book.c_code=rental.c_code
                            WHERE c_code=?";
                } else if (isset($_POST['rentaldate'])) {
                    $rentaldate = $_POST['rentaldate'];
                    $sql2 = "SELECT book.b_code,b_name,b_author,b_publisher,b_release,b_rentalprice,b_code,b_thum,b_synopsis1,b_synopsis2,b_synopsis3,renral_date,r_expiry
                            FROM book
                            INNER JOIN rental ON book.c_code=rental.c_code
                            WHERE c_code=? AND rentaldate={$rentaldate} DESC";
                } else {
                    $sql2 = "SELECT book.b_code,b_name,b_author,b_publisher,b_release,b_rentalprice,b_code,b_thum,b_synopsis1,b_synopsis2,b_synopsis3,renral_date,r_expiry
                            FROM book
                            INNER JOIN rental ON book.c_code=rental.c_code
                            WHERE c_code=?
                            LIMIT 5";
                }
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute(array($c_code));
                $array2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                $stmt2 = null;
            } catch (PDOException $e) {
                print "SQL実行エラー！:" . $e->getMessage();
                exit();
            }
            foreach ($array as $key => $value) {
                print "<tr>\n";
                print "<td>\n";
                print "<div class=\"item\">\n";
                print "<img src=\"../image/{$value['b_thum']}.jpg\" alt=\"{$value['b_name']}\" width=\"200px\" height=\"300px\" class=\"bookPhoto\" onclick=\"location.href='Detail.html?b_code={$value['b_code']}'\">\n";
                print "<div class=\"description\">\n";
                print "<div class=\"btitle\">\n";
                print "<p><b><a href=\"Detail.html?b_code={$value['b_code']}\">{$value['b_name']}</a></b></p>\n";
                print "</div>\n";
                print "<div class=\"mainInfo\">\n";
                print "<p>レンタル購入日<br>{$value['renral_date']}</p>\n";
                print "<p>レンタル期限<br>~{$value['r_expiry']}</p>\n";
                print "<p>レンタル価格<br>{$value['b_rentalprice']}円</p>\n";
                print "<input type=\"button\" value=\"読む\">\n";
                print "</div>\n";
                print "</div>\n";
                print "</div>\n";
                print "</td>\n";
                print "</tr>\n";
            }
            ?>
        </table>
        <div class="mottomiru">
            <p><a href="Mypage.php?mottomiru=1">すべて見る</a></p>
        </div>
        <hr>
        <div class="float">
            <h3>購入履歴</h3>
            <select name="" onchange="location.href=value">
                <option value="" selected>フィルタを選択</option>
                <?php
                $sql3 = "SELECT DISTINCT bd_buydate FROM buydetail WHERE c_code=? ORDER BY rentaldate DESC";
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
                    print "<option value=\"Mypage.php?buydate={$value['bd_buydate']}\">{$value['bd_buydate']}</option>";
                }
                ?>
            </select>
        </div>
        <table border="2" align="center" style="border-collapse: collapse">
            <?php
            if (isset($_POST['mottomirubuy'])) {
                $sql2 = "SELECT book.b_code,b_name,b_author,b_publisher,b_release,b_purchaseprice,b_code,b_thum,b_synopsis1,b_synopsis2,b_synopsis3,bd_buydate,bd_deliverydate,get_method,get_date
                        FROM book
                        INNER JOIN buydetail ON book.c_code=buydetail.c_code
                        WHERE c_code=?";
            } else if (isset($_POST['buydate'])) {
                $buydate = $_POST['buydate'];
                $sql2 = "SELECT book.b_code,b_name,b_author,b_publisher,b_release,b_purchaseprice,b_code,b_thum,b_synopsis1,b_synopsis2,b_synopsis3,bd_buydate,bd_deliverydate,get_method,get_date
                        FROM book
                        INNER JOIN rental ON book.c_code=rental.c_code
                        WHERE c_code=? AND bd_buydate={$buydate} DESC";
            } else {
                $sql2 = "SELECT book.b_code,b_name,b_author,b_publisher,b_release,b_purchaseprice,b_code,b_thum,b_synopsis1,b_synopsis2,b_synopsis3,bd_buydate,bd_deliverydate,get_method,get_date
                        FROM book
                        INNER JOIN rental ON book.c_code=rental.c_code
                        WHERE c_code=?
                        LIMIT 5";
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
                print "<tr>\n";
                print "<td>\n";
                print "<div class=\"item\">\n";
                print "<img src=\"../image/{$value['b_thum']}.jpg\" alt=\"{$value['b_name']}\" width=\"200px\" height=\"300px\" class=\"bookPhoto\" onclick=\"location.href='Detail.html?b_code={$value['b_code']}'\">\n";
                print "<div class=\"description\">\n";
                print "<div class=\"btitle\">\n";
                print "<p><b><a href=\"Detail.html?b_code={$value['b_code']}\">{$value['b_name']}</a></b></p>\n";
                print "</div>\n";
                print "<div class=\"mainInfo\">\n";
                print "<p>レンタル購入日<br>{$value['renral_date']}</p>\n";
                print "<p>レンタル期限<br>~{$value['r_expiry']}</p>\n";
                print "<p>レンタル価格<br>{$value['b_rentalprice']}円</p>\n";
                print "<input type=\"button\" value=\"読む\">\n";
                print "</div>\n";
                print "</div>\n";
                print "</div>\n";
                print "</td>\n";
                print "</tr>\n";
            }
            ?>
        </table>
        <div class="mottomiru">
            <p><a href="Mypage.php?mottomirubuy=1">すべて見る</a></p>
        </div>
    </main>
</body>

</html>