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
        <form action="Receiving.php" method="get">
            <?php
            $select = $_POST['select'];
            if ($select == 'store') {

                echo "<h2>店舗選択</h2>";
                echo "<div class=\"flbox\">";
                echo "<div class=\"fl\"><a href=\"../html/Verification.html\" class=\"btn\">北海道</a></div>";
                echo "<div class=\"fl\"><a href=\"../html/Verification.html\" class=\"btn\">東北</a></div>";
                echo "<div class=\"fl\"><a href=\"../html/Verification.html\" class=\"btn\">関西</a></div>";
                echo  "<div class=\"fl\"><a href=\"../html/Verification.html\" class=\"btn\">中部</a></div>";
                echo "<div class=\"fl\"><a href=\"../html/Verification.html\" class=\"btn\">四国</a></div>";
                echo "<div class=\"fl\"><a href=\"../html/Verification.html\" class=\"btn\">中国</a></div>";
                echo "<div class=\"fl\"><a href=\"../html/Verification.html\" class=\"btn\">九州/沖縄</a></div>";
                echo "</div>";
            } else {
                echo "<h2>住所選択</h2>";
                echo "<form action=\"Verification.html\" method=\"POST\">";
                echo "<input type=\"radio\" name=\"memberaddress\" value=\"会員情報の住所の表示\">会員情報の住所を表示";
                echo "<input type=\"radio\" name=\"memberaddress\">";
                echo "<input type=\"text\" name=\"memberaddress\" size=\"8\" placeholder=\"住所を入力\"></p>";
                echo "<input type=\"submit\" value=\"次へ\">";
                echo "</form>";
            }
            ?>

        </form>

    </main>
</body>

</html>