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
    <title>検索結果</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/result.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        <?php
        /* テスト用 
        52行目の部分を任意のテスト文に変更
        */
        /*
        Top.phpから新刊本表示 $new = 'new';
        top.phpから購入数ランキング表示 $rank = 'rank';

        書籍名検索 -> $searchCondition = 'b_title';
                     $searchWord = '適当なワード'; 
        著者名 -> $searchCondition = 'author';
                 $searchWord = '適当なワード'; 
        64行目のifを(!empty($searchCondition))に変更して
        */

        if (!empty($_GET['searchCondition'])) {
            $searchCondition = $_GET['searchCondition'];
            $searchWord = $_GET['searchWord'];
            if ($searchCondition == 'b_title') {
                $sql = 'SELECT b_code,b_name,b_thum,b_author,b_publisher,b_release,b_purchaseprice,b_rentalprice,b_stock,b_rental
                                   FROM book WHERE b_name LIKE ?';
                try {
                    // SQL 文を準備
                    $stmt = $dbh->prepare($sql);
                    // SQL 文を実行
                    $stmt->execute(array('%' . $searchWord . '%'));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                echo "<h3>書籍名 : ," . $searchWord . "で検索</h3>";
            } elseif ($searchCondition == 'author') {
                $sql = 'SELECT b_code,b_name,b_thum,b_author,b_publisher,b_release,b_purchaseprice,b_rentalprice,b_stock,b_rental
                                   FROM book WHERE b_author LIKE ?';
                try {
                    // SQL 文を準備
                    $stmt = $dbh->prepare($sql);
                    // SQL 文を実行
                    $stmt->execute(array('%' . $searchWord . '%'));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                echo "<h3>作者名 : " . $searchWord . "で検索</h3>";
            }
            if (!empty($_GET['new'])) {
                $sql = 'SELECT b_code,b_name,b_thum,b_author,b_publisher,b_release,b_purchaseprice,b_rentalprice,b_stock,b_rental
                               FROM book ORDER BY b_boughtQty DESC';
                try {
                    // SQL 文を準備
                    $stmt = $dbh->prepare($sql);
                    // SQL 文を実行
                    $stmt->execute();
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $dbh = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                echo "<h3>売上順<h3>";
            } elseif (!empty($_GET['rank'])) {
                $sql = 'SELECT b_code,b_name,b_thum,b_author,b_publisher,b_release,b_purchaseprice,b_rentalprice,b_stock,b_rental
                               FROM book ORDER BY b_release DESC';
                try {
                    // SQL 文を準備
                    $stmt = $dbh->prepare($sql);
                    // SQL 文を実行
                    $stmt->execute();
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $dbh = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                echo "<h3>新刊本<h3>";
            }
            foreach ($array as $value) {
        ?>
                <div class="result">
                    <div class="list1">
                        <div class="img">
                            <img class="thum" src="../image/<?= $value['b_thum'] ?>" alt="<?= $value['b_name'] ?>">
                        </div>
                    </div>
                    <div class="list2">
                        <form method="GET" action="Detail.php">
                            <div class="b_name">
                                <a href="Detail.php?b_code=<?= $value['b_code'] ?>" class="title" name="b_code"><?= $value['b_name'] ?></a>
                            </div>
                        </form>
                        <div class="other">
                            <div class="author">
                                <a><?= $value['b_author'] ?></a>
                            </div>
                            <div class="pub">
                                <a><?= $value['b_publisher'] ?></a>
                            </div>
                            <div class="date">
                                <a><?= $value['b_release'] ?></a>
                            </div>
                        </div>
                        <div class="bi">
                            <?php
                            if ($value['b_stock'] != null) {
                                if ($value['b_stock'] >= 1) {
                            ?>
                                    <form method="GET" action="./addCart.php">
                                        <div class="tab">
                                            <!--b_code=name-->
                                            <a href="addCart.php?b_code=<?= $value['b_code'] ?>">購入</a>
                                            <input type="hidden" name="b" value="buy">
                                            <p class="tax">税込</p>
                                            <p class="price">&yen;<?= $value['b_purchaseprice'] ?></p>
                                            <p class="cart">カートに入れる</p>
                                            <!--php出来たら上のリンク変更-->
                                            <!--在庫がある場合購入表示、ない場合予約表示-->
                                        </div>
                                    </form>
                                <?php
                                } elseif ($value['b_stock'] == 0) {
                                ?>
                                    <form method="GET" action="./addCart.php">
                                        <div class="tab">
                                            <!--b_code=name-->
                                            <a href="addCart.php?b_code=<?= $value['b_code'] ?>">予約</a>
                                            <input type="hidden" name="b" value="buy">
                                            <p class="tax">税込</p>
                                            <p class="price">&yen;<?= $value['b_purchaseprice'] ?></p>
                                            <p class="cart">カートに入れる</p>
                                            <!--php出来たら上のリンク変更-->
                                            <!--在庫がある場合購入表示、ない場合予約表示-->
                                        </div>
                                    </form>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="tab">
                                    <a class="s_none">取扱無し</a>
                                </div>
                            <?php
                            }
                            if ($value['b_rental'] == 1) {
                            ?>
                                <form method="GET" action="./addCart.php">
                                    <div class="tab">
                                        <!--b_code=name-->
                                        <a href="addCart.php?b_code=<?= $value['b_code'] ?>">レンタル</a>
                                        <input type="hidden" name="b" value="rent">
                                        <p class="tax">税込</p>
                                        <p class="price">&yen;<?= $value['b_rentalprice'] ?></p>
                                        <p class="cart">カートに入れる</p>
                                        <!--php出来たら上のリンク変更-->
                                        <!--レンタル出来ない場合リンクを消す-->
                                    </div>
                                </form>
                            <?php
                            } else {
                            ?>
                                <div class="tab">
                                    <!--b_code=name-->
                                    <a class="s_none">レンタル不可</a>
                                    <!--php出来たら上のリンク変更-->
                                    <!--レンタル出来ない場合リンクを消す-->
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <hr>
        <?php
            }
        }
        ?>
    </main>
    <footer>

    </footer>
</body>

</html>