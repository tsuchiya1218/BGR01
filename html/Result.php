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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/result.css" rel="stylesheet" type="text/css">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <div id="top">
            <h1 id="title">BOOK ON</h1>
            <p id="subtitle">It's a book but it's not a book!</p>
            <div id="right">
                <input type="button" value="カートを見る">
                <input type="button" value="ログイン">
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
        $searchCondition = htmlspecialchars($_GET['searchCondition']);
        $searchWord = htmlspecialchars($_GET['searchWord']);
        $rank = htmlspecialchars($_GET['rank']); //top.phpでnameが確定次第変更
        $rank = htmlspecialchars($_GET['new']); //top.phpでnameが確定次第変更
        if (isset($searchWord)) {
            if ($searchCondition == "b_title") {
                $sql = 'SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice
                                   FROM book WHERE b_title like %?%';
                try {
                    // SQL 文を準備
                    $stmt = $pdo->prepare($sql);
                    // SQL 文を実行
                    $stmt->execute(array($b_title));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $pdo = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                echo "<h3>'" . $searchCondition . "," . $searchWord . "'で検索</h3>";
            } elseif ($searchCondition == "author") {
                $sql = 'SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice
                                   FROM book WHERE b_author like %?%';
                try {
                    // SQL 文を準備
                    $stmt = $pdo->prepare($sql);
                    // SQL 文を実行
                    $stmt->execute(array($b_author));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $pdo = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                echo "<h3>'" . $searchCondition . "," . $searchWord . "'で検索</h3>";
            }
        } elseif (isset($rank)) {
            $sql = 'SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice
                               FROM book ORDER BY b_boughtQty DESC';
            try {
                // SQL 文を準備
                $stmt = $pdo->prepare($sql);
                // SQL 文を実行
                $stmt->execute();
                // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = null;
                $pdo = null;
            } catch (PDOException $e) {
                print "SQL 実行エラー!: " . $e->getMessage();
                exit();
            }
            echo "<h3>" . $rank . "<h3>";
        } elseif (isset($new)) {
            $sql = 'SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice
                               FROM book ORDER BY b_release DESC';
            try {
                // SQL 文を準備
                $stmt = $pdo->prepare($sql);
                // SQL 文を実行
                $stmt->execute();
                // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = null;
                $pdo = null;
            } catch (PDOException $e) {
                print "SQL 実行エラー!: " . $e->getMessage();
                exit();
            }
            echo "<h3>" . $new . "<h3>";
        }
        ?>
        <?php
        foreach ($array as $value) {
        ?>
            <div class="result">
                <div class="list1">
                    <div class="img">
                        <img class="thum" src="<?php $value['b_thum'] ?>" alt="<?php $value['b_name'] ?>">
                    </div>
                </div>
                <div class="list2">
                    <div class=" b_name">
                        <a href="Detail.php?b_code=<?php $value['b_code'] ?>" class="title"><?php $value['b_name'] ?></a>
                    </div>
                    <div class="other">
                        <div class="author ">
                            <a><?php $value['b_name'] ?></a>
                        </div>
                        <div class="pub ">
                            <a><?php $value['b_publisher'] ?></a>
                        </div>
                        <div class="date ">
                            <a><?php $value['b_release'] ?></a>
                        </div>
                    </div>
                    <div class="bi">
                        <form method="GET" action="./addCart.php">
                            <div class="tab">
                                <!--b_code=name-->
                                <a href="Cart.php?b_code=<?php $value['b_code'] ?>">購入</a>
                                <input type="hidden" name="b" value="buy">
                                <p class="tax">税込</p>
                                <p class="price">&yen;<?php $value['b_purchaseprice'] ?></p>
                                <p class="cart">カートに入れる</p>
                                <!--php出来たら上のリンク変更-->
                                <!--在庫がある場合購入表示、ない場合予約表示-->
                            </div>
                        </form>
                        <form method="GET" action="./addCart.php">
                            <div class="tab">
                                <!--b_code=name-->
                                <a href="Cart.php?b_code=<?php $value['b_code'] ?>">レンタル</a>
                                <input type="hidden" name="b" value="rent">
                                <p class="tax">税込</p>
                                <p class="price">&yen;<?php $value['b_rentalprice'] ?></p>
                                <p class="cart">カートに入れる</p>
                                <!--php出来たら上のリンク変更-->
                                <!--レンタル出来ない場合リンクを消す-->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </main>
    <footer>

    </footer>
</body>

</html>