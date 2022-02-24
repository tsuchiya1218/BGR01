<?php
//データベースに接続する
try {
	$server_name = "10.42.129.3";	// サーバ名
	$db_name = "20grb1";	// データベース名(自分の学籍番号を入力)

	$user_name = "20grb1";	// ユーザ名(自分の学籍番号を入力)
	$user_pass = "20grb1";	// パスワード(自分の学籍番号を入力)

	// データソース名設定
	$dsn = "sqlsrv:server=$server_name;database=$db_name";

	// PDOオブジェクトのインスタンス作成
	$pdo = new PDO ($dsn, $user_name, $user_pass);

	// PDOオブジェクトの属性の指定
	$pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch ( PDOException $e ) {
	print "接続エラー!: " . $e->getMessage ();
	exit();
}

?>

<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/top.css" rel="stylesheet" type="text/css">
    <link href="../css/detal.css" rel="stylesheet" type="text/css">
    <title>商品詳細</title>
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
                    <option value="author">作者</option>
                </select>
                <input type="text" name="serchWord">
                <input type="submit" value="🔍">
                <input type="button" value="詳細検索" onclick="location.href=''">
            </form>
        </div>
        <hr>
    </header>
    <main>
        
<?php
    //Result.phpから送られてきたデータを取得
    $b_code1=$_GET["b_code"];
    //SQL文の実行
    $sql = "SELECT b_code,b_name,b_thum,b_author,b_release,b_purchaseprice,b_rentalprice,b_rental FROM book Where b_code == ?";
    $stmt = $pdo->prepare($spl);
    $stmt->execute($b_code1);
    $array  = $stmt->fetchAll(pdo::FETCH_ASSOC);
    // 実行結果をまとめて取り出し(カラム名で添字を付けた配列)

?>
        <h2>書籍情報</h2>
        <div class="dbox">
            <div class="image">
                <img src="../image/chitei.jpg" alt="" align="left" width="200" height="250">
            </div>
            <div class="bdate">
            <?php
                foreach ($array as $value) {
            ?>
                <div class="tdate">
                    <p><a href="../html/Detail.php"><?=$b_name?></a></p>
                    <!--タイトルをphpでnameを表示-->
                </div>
                <table class="tablesize">
                    <div class="but">
                        <p>著者 <?=$author?></p>
                        <p>出版社名 <?=$pub?></p>
                        <p>発行年月 <?=$date?></p>
                        <p>カテゴリー <?=$b_category?></p>
                        <!--著者　出版社名 発行年月-->
                    </div>
                </table>
                <div class="bi">
                <form method="GET" action="Cart.php">
                        <?php if($value['b_stock']<=1){ ?>
                        <!--購入-->
                        <div class="buy_tab">
                            <a href="Cart.php?b_code=<?php $value['b_code'] ?>">購入</a>
                            <input type="hidden" name="h_cart" value="buy">
                            <p class="tax">税込</p>
                            <p class="price">&yen;<?php $value['b_purchaseprice'] ?></p>
                            <p class="cart">カートに入れる</p>
                        </div>
                        <?php }elseif($value['b_stock']=0){ ?>
                        <!--予約-->
                        <div class="reserve_tab">
                            <a href="Cart.php?b_code=<?php $value['b_code'] ?>">予約</a>
                            <input type="hidden" name="h_cart" value="reserve">
                            <p class="tax">税込</p>
                            <p class="price">&yen;<?php $value['b_purchaseprice'] ?></p>
                            <p class="cart">カートに入れる</p>
                        </div>
                        <?php }elseif(!isset($value['b_stock'])){ ?>
                            <!--取扱無し-->
                        <div class="notbuy_tab">
                            <a>取扱無し</a>
                        </div>
                        <?php if($value['b_rental']==1){ ?>
                        <!--レンタル可能-->
                        <div class="tab">
                            <a href="Cart.php?b_code=<?php $value['b_code'] ?>">レンタル</a>
                            <input type="hidden" name="h_cart" value="buy">
                            <p class="tax">税込</p>
                            <p class="price">&yen;<?php $value['b_rentalprice'] ?></p>
                            <p class="cart">カートに入れる</p>
                            <!--php出来たら上のリンク変更-->
                            <!--レンタル出来ない場合リンクを消す-->
                        </div>
                        <?php }elseif($value['b_rental']==0){ ?>
                        <!--レンタル不可-->
                        <div class="notrental_tab">
                            <a>取扱無し</a>
                            <!--在庫がある場合購入表示、ない場合予約表示-->
                        </div>
                    </form>
                </div>
                <div class="bookd">
                    <h2>あらすじ</h2>
                    <!--あらすじデータを表示-->
                    <p><?=$b_synopsis?></p>
                </div>
            </div>
        </div>

        <?php
        }
        ?>
        <h2>この商品の関係する本</h2>
        <div class="divbox1">

            <?PHP
                
                $sql2 = "SELECT * FROM book Where author == book.author order by rand() Limit 5";
                $stmt = $pdo->prepare($spl2);
                $stmt->execute(array());
                $array  = $stmt->fetchAll(pdo::FETCH_ASSOC);

                foreach($array as $value){                
                echo "<div class=\"divr\">";
                    echo "<div class=\"divimage\">";
                        echo"<img src=\"../image/chikyuu.jpg\" alt=\"\">";
                    echo "</div>";

                    echo"<div class=\"divinfo\">";
                        echo "<p><a href=\"\">インド</a></p>";
                        echo "<p>税込 &yen;847</p>";
                        echo "<p>カテゴリー:<a href=\"\">旅行</a></p>";
                    echo"</div>";
                echo "</div>";
                }
            ?>
    </main>
</body>

</html>

