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

$sql = "SELECT b_name,b_author,b_publisher
         ,b_release,b_thum,b_purchaseprice FROM book  ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$array = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/cart.css" rel="stylesheet" type="text/css">
    <title>カート内容確認</title>
</head>
<?php

//$変数 = $_GET[''];
//$b_code = $_GET['b_code'];

$c_code = 1;

?>
<script src="../JavaScript/update.js"></script>
<script type="text/javascript">

</script>

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
                <input type="text" name="serchWord">
                <input type="submit" value="🔍">
                <input type="button" value="詳細検索" onclick="location.href=''">
            </form>
        </div>
        <hr>
    </header>
    <main>
        <!--受け取り方法選択-->
        <form action="../html/Receiving.php" name="receiving" method="GET">


            <div class="tab">

                <!--購入タブ-->
                <input id="buy" type="radio" name="tab_item">
                <label class="tab_item" for="buy">購入</label>

                <!--予約タブ-->
                <input id="reserve" type="radio" name="tab_item">
                <label class="tab_item" for="reserve">予約</label>

                <!--レンタルタブ-->
                <input id="rental" type="radio" name="tab_item">
                <label class="tab_item" for="rental">レンタル</label>

                <div class="tab_content" id="buy_content">
                    <table border="2" class="test" align="center" style="border-collapse: collapse">
                        <div class="product">

                            <?php
                            //"SELECT b_name,b_author,b_publisher,b_release
                            //      ,b_purchaseprice,b_thum" FROM book WHERE $b_code = b_code
                            $sql = "SELECT b_name,b_author,b_publisher,b_release,b_purchaseprice,b_thum
                                        FROM book 
                                        RIGHT JOIN buycart
                                        ON book.b_code = buycart.b_code
                                        WHERE c_code = ?";
                            try {
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute(array($c_code));
                                $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } catch (PDOException $e) {
                                print "SQL実行エラー！:" . $e->getMessage();
                                exit();
                            }
                            if (empty($array)) {
                                echo "カートの中に商品がありません。<br>";
                            }
                            ?>

                            <!--書籍のDB化-->
                            <!-- checkbox value price -->

                            <div class="checkbox">
                                <input type="checkbox" id="check" value="500" onclick="calcTotal()">
                                <!--$value['b_purchaseprice']-->
                            </div>

                            <div class="mainlight">
                                <p class="btitle"><a href="Detail.html">地底旅行</a></p>
                                <div class="description">
                                    <div class="info">
                                        <?php
                                        //foreach($array as $row){  
                                        //echo "{$row["b_author"]}";
                                        //echo "{$row["b_publisher"]}";
                                        //echo "{$row["b_release"]}";
                                        ?>
                                        <!--著者-->
                                        <p><?= $value['b_author'] ?></p>
                                        <!--出版社-->
                                        <p><?= $value['b_publisher'] ?></p>
                                        <!--発行年月-->
                                        <p><?= $value['b_release'] ?></p>
                                    </div>

                                    <div class="info2">
                                        <p>価格（税込）</p>
                                        <p name="price">&yen;<?= $value['b_purchaseprice'] ?></p>
                                        <p align="right">
                                            数量
                                            <select name="qty">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        <form action="../html/addCart.php" method="GET">
                                            <!--<input type="hidden" name="" value=""-->
                                            <input type="reset" value="削除">
                                            <!--購入した商品一つをカートから削除-->
                                        </form>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--foreachでカートに追加したものを表示-->

                            <!--foreach ($array as $row) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<img class='thum' src='../image/<?= $value['b_thum'] ?>' onclick=location.href='Detail.html'>";
                                    echo "<p class='btitle'><a href='Detail.html'>{$row["b_name"]}</a></p>";
                                    echo "<div class='description'>";
                                    echo "<div class='info'>";
                                    echo "<p>{$row["b_author"]}</p>";
                                    echo "<p>{$row["b_publisher"]}</p>";
                                    echo "<p>{$row["b_release"]}</p>";
                                    echo "</div>";
                                    echo "<div class='info2'>";
                                    echo "<p>価格(税込)</p>";
                                    echo "<p name='price'>&yen;{$row["b_purchaseprice"]}</p>";
                                    echo "</tr>";
                                    echo "</td>";
                                    // break;
                                }


                                echo "<p align='right'>";
                                echo "数量";
                                //DBから書籍のStockに応じてプルダウンの中身を変える

                                $countsql = "SELECT b_stock FROM book";
                                $countsql = $pdo->prepare($countsql);
                                $countsql->execute();
                                echo "<select name='qty'>";
                                foreach ($count as $qty) {
                                    echo '<option value="', $qty, '">', $qty, '</option>';
                                }
                                echo "</select>";-->

                        </div>
                </div>
                </table>
            </div>

            <!--予約-->
            <div class="tab_content" id="reserve_content">
                <table border="2" class="test" align="center" style="border-collapse: collapse">
                    <tr>
                        <td>
                            <div class="product">

                                <?php
                                $sql = "SELECT b_name,b_author,b_publisher,b_release,b_purchaseprice,b_thum
                                        FROM book 
                                        RIGHT JOIN reservecart
                                        ON book.b_code = reservecart.b_code
                                        WHERE c_code = ? ";
                                try {
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute(array($c_code));
                                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    print "SQL実行エラー！:" . $e->getMessage();
                                    exit();
                                }
                                if (empty($array)) {
                                    echo "カートの中に商品がありません。<br>";
                                }
                                ?>

                                <div class="checkbox">
                                    <input type="checkbox" id="check" value="300" onclick="calcTotal()">
                                    <!--$value['b_purchaseprice']-->
                                </div>

                                <img class="thum" src="../image/<?= $value['b_thum'] ?>" onclick="location.href='Detail.html'">

                                <div class="mainlight">
                                    <p class="btitle"><a href="Detail.html">地底旅行</a></p>
                                    <div class="description">
                                        <div class="info">
                                            <?php
                                            //foreach($array as $row){  
                                            //echo "{$row["b_author"]}";
                                            //echo "{$row["b_publisher"]}";
                                            //echo "{$row["b_release"]}";
                                            ?>
                                            <!--著者-->
                                            <p><?= $value['b_author'] ?></p>
                                            <!--出版社-->
                                            <p><?= $value['b_publisher'] ?></p>
                                            <!--発行年月-->
                                            <p><?= $value['b_release'] ?></p>
                                        </div>

                                        <div class="info2">
                                            <p>価格（税込）</p>
                                            <p name="price">&yen;<?= $value['b_purchaseprice'] ?></p>
                                            <p align="right">
                                                数量
                                                <select name="qty">
                                                    <option value="1" selected>1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            <form action="../html/addCart.php" method="GET">
                                                <!--<input type="hidden" name="" value=""-->
                                                <input type="reset" value="削除">
                                                <!--購入した商品一つをカートから削除-->
                                            </form>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>


            <!--レンタル-->
            <div class="tab_content" id="rental_content">
                <table border="2" class="test" align="center" style="border-collapse: collapse">
                    <tr>
                        <td>
                            <div class="product">
                                <?php
                                $sql = "SELECT b_name,b_author,b_publisher,b_release,b_rentalprice,b_thum
                                            FROM book 
                                            RIGHT JOIN rentalcart
                                            ON book.b_code = rentalcart.b_code
                                            WHERE c_code= ?";
                                try {
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute(array($c_code));
                                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    print "SQL実行エラー！:" . $e->getMessage();
                                    exit();
                                }
                                if (empty($array)) {
                                    echo "カートの中に商品がありません。<br>";
                                }
                                ?>
                                <div class="checkbox">
                                    <input type="checkbox" id="check" value="800" onclick="calcTotal()">
                                    <!--$value['b_rentalprice']-->
                                </div>

                                <img class="thum" src="../image/<?= $value['b_thum'] ?>" onclick="location.href='Detail.html'">

                                <div class="mainlight">
                                    <p class="btitle"><a href="Detail.html">地底旅行</a></p>
                                    <div class="description">
                                        <div class="info">
                                            <?php
                                            //foreach($array as $row){  
                                            //echo "{$row["b_author"]}";
                                            //echo "{$row["b_publisher"]}";
                                            //echo "{$row["b_release"]}";
                                            ?>
                                            <p><?= $value['b_author'] ?></p>
                                            <!--出版社-->
                                            <p><?= $value['b_publisher'] ?></p>
                                            <!--発行年月-->
                                            <p><?= $value['b_release'] ?></p>
                                        </div>

                                        <div class="info2">
                                            <p>価格（税込）</p>
                                            <p name="price">&yen;<?= $value['b_rentalprice'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 小計 -->
            <?php

            ?>
            <p class="gokei" name="total">小計&yen;<input type="text" value="0" id="amount"></p>
            <p class="gokei"><input type="submit" name="" value="確認へ進む"></p>
            <footer>
                &copy;It's a book but it's not a book!
            </footer>
            </div>
        </form>
    </main>
</body>

</html>

<input type="button" value="-" onclick="subOne(0)">
<input type="number" value="0" class="counter">
<input type="button" value="+" onclick="addOne(0)">