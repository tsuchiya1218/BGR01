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
$b_code = $_GET['b_code'];


?>
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

        <form action="../html/Receiving.html" name="receiving" method="GET">


            <div class="tab">
                <!--idでbuy,reserve,rental各自に飛べるように-->

                <input id="buy" type="radio" name="tab_item">
                <label class="tab_item" for="buy">購入</label>
                <input id="reserve" type="radio" name="tab_item">
                <label class="tab_item" for="reserve">予約</label>
                <input id="rental" type="radio" name="tab_item">
                <label class="tab_item" for="rental">レンタル</label>


                <div class="tab_content" id="buy_content">
                    <table border="2" class="test" align="center" style="border-collapse: collapse">
                        <tr>
                            <td>
                                <div class="product">
                                    
                                    <!--書籍のDB化-->
                                    <div class="checkbox">
                                        <input type="checkbox" name="check">
                                    </div>

                                    <img src="../image/chitei.jpg" alt="地底旅行"  height="250" width="200" onclick="location.href='Detail.html'">

                                    <div class="mainlight">
                                        <p class="btitle"><a href="Detail.html">地底旅行</a></p>
                                        <div class="description">
                                            <div class="info">
                                                <p>ジュール・ヴェルヌ</p>
                                                <p>東京創元社</p>
                                                <p>1968年11月29日</p>
                                            </div>

                                            <div class="info2">
                                                <p>価格（税込）</p>
                                                <p name="price">&yen;847</p>
                                                <p align="right">
                                                    数量
                                                    <select name="qty">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <input type="reset" value="削除">
                                                    <!--購入した商品一つをカートから削除-->
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product">
                                    <div class="checkbox">
                                        <input type="checkbox" name="check">
                                    </div>
                                    <img src="../image/chikyuu.jpg" alt="地球の歩き方　インド" height="250" width="200" onclick="location.href='Detail.html'">

                                    <div class="mainlight">
                                        <p class="btitle"><a href="Detail.html">地球の歩き方 インド</a></p>
                                        <div class="description">
                                            <div class="info">
                                                <p>ダイアモンド・ビッグ社</p>
                                                <p>2020年3月12日</p>
                                            </div>

                                            <div class="info2">
                                                <p>価格（税込）</p>
                                                <p name="price">&yen;2090</p>
                                                <p align="right">
                                                    数量
                                                    <select name="qty">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <input type="reset" value="削除">

                                                    <!--購入した商品一つをカートから削除-->
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="tab_content" id="reserve_content">
                    <table border="2" class="test" align="center" style="border-collapse: collapse">
                        <tr>
                            <td>
                                <div class="product">
                                    
                                    <div class="checkbox">
                                        <input type="checkbox" id="check" name="check">
                                    </div>

                                    <img src="../image/chitei.jpg" alt="地底旅行"  height="250" width="200" onclick="location.href='Detail.html'">

                                    <div class="mainlight">
                                        <p class="btitle"><a href="Detail.html">地底旅行</a></p>
                                        <div class="description">
                                            <div class="info">
                                                <p>ジュール・ヴェルヌ</p>
                                                <p>東京創元社</p>
                                                <p>1968年11月29日</p>
                                            </div>

                                            <div class="info2">
                                                <p>価格（税込）</p>
                                                <p name="price">&yen;847</p>
                                                <p align="right">
                                                    数量
                                                    <select name="qty">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <input type="reset" value="削除">
                                                    <!--購入した商品一つをカートから削除-->
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product">
                                    
                                    <div class="checkbox">
                                        <input type="checkbox" name="check">
                                    </div>
                                    <img src="../image/chikyuu.jpg" alt="地球の歩き方　インド" height="250" width="200" onclick="location.href='Detail.html'">

                                    <div class="mainlight">
                                        <p class="btitle"><a href="Detail.html">地球の歩き方 インド</a></p>
                                        <div class="description">
                                            <div class="info">
                                                <p>ダイアモンド・ビッグ社</p>
                                                <p>2020年3月12日</p>
                                            </div>

                                            <div class="info2">
                                                <p>価格（税込）</p>
                                                <p name="price">&yen;2090</p>
                                                <p align="right">
                                                    数量
                                                    <select name="qty">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <input type="reset" value="削除">
                                                    <!--購入した商品一つをカートから削除-->
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="tab_content" id="rental_content">
                    <table border="2" class="test" align="center" style="border-collapse: collapse">
                        <tr>
                            <td>
                                <div class="product">
                                    
                                    <div class="checkbox">
                                        <input type="checkbox" name="check">
                                    </div>

                                    <img src="../image/chitei.jpg" alt="地底旅行"  height="250" width="200" onclick="location.href='Detail.html'">

                                    <div class="mainlight">
                                        <p class="btitle"><a href="Detail.html">地底旅行</a></p>
                                        <div class="description">
                                            <div class="info">
                                                <p>ジュール・ヴェルヌ</p>
                                                <p>東京創元社</p>
                                                <p>1968年11月29日</p>
                                            </div>

                                            <div class="info2">
                                                <p>価格（税込）</p>
                                                <p name="price">&yen;847</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product">
                                    
                                    <div class="checkbox">
                                        <input type="checkbox" name="check">
                                    </div>
                                    <img src="../image/chikyuu.jpg" alt="地球の歩き方　インド" height="250" width="200" onclick="location.href='Detail.html'">

                                    <div class="mainlight">
                                        <p class="btitle"><a href="Detail.html">地球の歩き方 インド</a></p>
                                        <div class="description">
                                            <div class="info">
                                                <p>ダイアモンド・ビッグ社</p>
                                                <p>2020年3月12日</p>
                                            </div>

                                            <div class="info2">
                                                <p>価格（税込）</p>
                                                <p name="price">&yen;2090</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <p class="gokei" name="total">小計 ----\</p>
                <p class="gokei"><input type="submit" name="" value="確認へ進む"></p>
                <footer>
                    &copy;It's a book but it's not a book!
                </footer>
            </div>
        </form>
    </main>
</body>

</html>