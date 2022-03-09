<html lang="ja">
<?php

session_start();

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


<head>
    <title></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/verification.css" rel="stylesheet" type="text/css">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
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
            <form action="Result.php" method="GET">
                <select name="serchCondition">
                    <option value="b_title" selected>書籍</option>
                    <option value="author">作者</option>
                </select>
                <input type="text" name="serchWord">
                <input type="submit" value="🔍">
                
            </form>
        </div>
        <hr>
    </header>
    <main>
<<<<<<< HEAD
<?php
$how_cart = $_SESSION['cart'];
if(!empty($how_cart)){
    if($how_cart == 'buy'){
        
    }elseif($how_cart == 'reserve'){
        
    }elseif($how_cart =='rental'){

    }else{

    }
?>
        <h3>購入内容</h3>
        <div class="list">
            <div class="b_thum">
                <img class="thum" src="../image/chitei.jpg" alt="地底旅行">
            </div>
            <div class="other">
                <div class="b_name">
                    <a href="Detail.php?book_id=1" class="title">地底旅行</a>
                </div>
                <div class="b_price">
                    <a class="price">価格(税込)　&yen;847</a>
                </div>

<?php
        $how_cart = $_SESSION['cart'];
        $c_code = $_SESSION['c_code'];

        if (!empty($how_cart)) {
            if ($how_cart == 'buy') {

                $sql = "SELECT * FROM buycart INNER JOIN customers ON buycart.b_name = customers.b_name 
                WHERE buycart.c_code = ?";
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array($c_code));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $sql = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
            } elseif ($how_cart == 'reserve') {
                $sql = "SELECT * FROM reservecart INNER JOIN customers ON reservecart.b_name = customers.b_name
                WHERE reservecart.c_code = ?";
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array($c_code));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $sql = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
            } elseif ($how_cart == 'rental') {
                $sql = "SELECT * FROM rentalcart INNER JOIN customers ON rentalcart.c_code = customers.c_code 
                WHERE rentalcart.c_code = ?";
                try {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array($c_code));
                    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null;
                    $sql = null;
                } catch (PDOException $e) {
                    print "SQL 実行エラー!: " . $e->getMessage();
                    exit();
                }
            }
            $sql = "SELECT b_thum FROM book WHERE b_code = ?";
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array($b_code));
                // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)
                $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = null;
                $sql = null;
            } catch (PDOException $e) {
                print "SQL 実行エラー!: " . $e->getMessage();
                exit();
            }

            foreach ($array as $value) {
        ?>
                <h3>購入内容</h3>
                <div class="list">
                    <div class="b_thum">
                        <img class="thum" src="../image/<?= $value['']?>" alt="<?= $value['b_name']?>">
                    </div>
                    <div class="other">
                        <div class="b_name">
                            <a class="title"><?= $value['b_name']?></a>
                        </div>
                        <div class="b_price">
                            <a class="price">価格(税込)&yen;<?= $value['c_qty']?></a><!--変更予定-->
                        </div>
                    </div>
                </div>
                <hr>

                <div class="sp">
                    <div class="amount">
                        <div class="ap">
                            <a>合計金額</a>
                        </div>
                        <div class="a_price">
                            <a id="price">&yen;<?= $value['']?></a><!--変更予定-->
                            <!--処理方法がわからん-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="list">
            <div class="b_thum">
                <img class="thum" src="../image/chikyuu.jpg" alt="地球の歩き方(インド)">
            </div>
            <div class="other">
                <div class="b_name">
                    <a href="Detail.php?book_id=2" class="title">地球の歩き方(インド)</a>
                </div>
                <div class="b_price">
                    <a class="price">価格(税込)　&yen;1900</a>
                </div>
            </div>
        </div>

        <hr>

        <div class="sp">
            <div class="amount">
                <div class="ap">
                    <a>合計金額</a>
                </div>
                <div class="a_price">
                    <a id="price">&yen;2747</a>
                </div>
            </div>
        </div>
        <div class="cp">
            <form method="post" aciton="">
                <input type="submit" value="支払い">
            </form>
        </div>
        <div>
            <!--記述内容-->
            <!--受け取り方法-->
            <!--予約だったら1週間後位の日にち-->
            <!--レンタルだったら1か月後くらいの日にち-->
            
        </div>
        <div class="cp">
            <form method="post" aciton="Order_completion.php">
                <input type="submit" value="購入">
            </form>
        </div>
        <?
            }
        } else {
        }
        ?>


    </main>
</body>

</html>