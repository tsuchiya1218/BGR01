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
<html>

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


        //ワード検索
        if (isset($searchWord)) {
            //書籍名検索
            if ($searchCondition == "b_title") {
                $sql = 'SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice,
                                b_stock,b_rental
                                FROM book WHERE b_title like %?%';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array($b_title));
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $pdo = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                echo "<h3>'" . $searchCondition . "," . $searchWord . "'で検索</h3>";

            //著者名検索
            } elseif ($searchCondition == "author") {
                $sql = 'SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice,
                                b_stock,b_rental
                                FROM book WHERE b_author like %?%';
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array($b_author));
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $pdo = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
                echo "<h3>'" . $searchCondition . "," . $searchWord . "'で検索</h3>";
            }
        //ランキング
        } elseif (isset($rank)) {
            $sql = 'SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice,
                            b_stock,b_rantal
                            FROM book ORDER BY b_boughtQty DESC';
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = null;
                $pdo = null;
            } catch (PDOException $e) {
                print "SQL 実行エラー!: " . $e->getMessage();
                exit();
            }
            echo "<h3>" . $rank . "<h3>";
        //新刊本
        } elseif (isset($new)) {
            $sql = 'SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice
                            b_stock,b_rental
                            FROM book ORDER BY b_release DESC';
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
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
        <?php foreach ($array as $value) { ?>
            <div class="result">
                <div class="list1">
                    <div class="img">
                        <img class="thum" src="<?php $value['b_thum'] ?>" alt="<?php $value['b_name']; ?>">
                    </div>
                </div>
                <div class="list2">
                    <div class=" b_name">
                        <a href="Detail.php?b_code=<?php $value['b_code'] ?>" class="title"><?php $value['b_name']; ?></a>
                    </div>
                    <div class="other">
                        <div class="author ">
                            <a><?php $value['b_name']; ?></a>
                        </div>
                        <div class="pub ">
                            <a><?php $value['b_publisher']; ?></a>
                        </div>
                        <div class="date ">
                            <a><?php $value['b_release']; ?></a>
                        </div>
                    </div>
                    <div class="bi">
                        <form method="GET" action="Cart.php">
                            <?php if($value['b_stock']<=1){ ?>
                            <!--購入-->
                            <div class="tab">
                                <a href="Cart.php?b_code=<?php $value['b_code']; ?>">購入</a>
                                <input type="hidden" name="h_cart" value="buy">
                                <p class="tax">税込</p>
                                <p class="price">&yen;<?php $value['b_purchaseprice']; ?></p>
                                <p class="cart">カートに入れる</p>
                            </div>
                            <?php }elseif($value['b_stock']=0){ ?>
                            <!--予約-->
                            <div class="tab">
                                <a href="Cart.php?b_code=<?php $value['b_code']; ?>">予約</a>
                                <input type="hidden" name="h_cart" value="reserve">
                                <p class="tax">税込</p>
                                <p class="price">&yen;<?php $value['b_purchaseprice']; ?></p>
                                <p class="cart">カートに入れる</p>
                            </div>
                            <?php }elseif(!isset($value['b_stock'])){ ?>
                                <!--取扱無し-->
                            <div class="tab">
                                <a class="b_none">取り扱い無し</a>
                            </div>
                            <?php }
                            if($value['b_rental']==1){ ?>
                            <!--レンタル可能-->
                            <div class="tab">
                                <a href="Cart.php?b_code=<?php $value['b_code']; ?>">レンタル</a>
                                <input type="hidden" name="h_cart" value="buy">
                                <p class="tax">税込</p>
                                <p class="price">&yen;<?php $value['b_rentalprice']; ?></p>
                                <p class="cart">カートに入れる</p>
                            </div>
                            <?php }elseif($value['b_rental']==0){ ?>
                            <!--レンタル不可-->
                            <div class="tab">
                                <a class="b_none">取扱無し</a>
                                <!--在庫がある場合購入表示、ない場合予約表示-->
                            </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </main>
    <footer>

    </footer>
</body>
</html>