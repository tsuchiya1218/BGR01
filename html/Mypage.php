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
                <!--ログインしているときはマイページボタンにする-->
                <input type="button" value="ログイン">
            </div>
        </div>
        <hr>
        <div align="center">
            <form action="Result.html" method="post">
                <select name="" id="">
                    <option value="">書籍</option>
                    <option value="">作者</option>
                </select>
                <input type="text" name="" id="">
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
                <!--PHPでforeach(購入日付が存在する分だけ)-->
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
                <option value="/xxxx_xx_xx">XXXX/XX/xx</option>
                <option value="/xxxx_xx_xx">XXXX/XX/xx</option>
                <option value="/xxxx_xx_xx">XXXX/XX/xx</option>
            </select>
        </div>
        <table border="2" align="center" style="border-collapse: collapse">
            <tr>
                <td>
                    <div class="item">
                        <img src="../image/ダウンロード.jpg" alt="賢者の石" width="200px" height="300px" class="bookPhoto" onclick="location.href='Detail.html'">
                        <div class="description">
                            <div class="btitle">
                                <p><b><a href="Detail.html">ハリーポッターと賢者の石</a></b></p>
                            </div>
                            <div class="mainInfo">
                                <p>レンタル期限<br>~XXXX/XX/XX</p>
                                <p>レンタル価格<br>XXXX円</p>
                                <input type="button" value="読む">
                            </div>
                            <div class="subInfo">
                                <p>著者<br>J.K.ローリング</p>
                                <p>出版社名<br>XXXX社</p>
                                <p>発行年月<br>XXXX/XX/XX</p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="item">
                        <img src="../image/ダウンロード.jpg" alt="賢者の石" width="200px" height="300px" class="bookPhoto" onclick="location.href='Detail.html'">
                        <div class="description">
                            <div class="btitle">
                                <p><b><a href="Detail.html">ハリーポッターと賢者の石</a></b></p>
                            </div>
                            <div class="mainInfo">
                                <p>レンタル期限<br>~XXXX/XX/XX</p>
                                <p>レンタル価格<br>XXXX円</p>
                                <input type="button" value="読む">
                            </div>
                            <div class="subInfo">
                                <p>著者<br>J.K.ローリング</p>
                                <p>出版社名<br>XXXX社</p>
                                <p>発行年月<br>XXXX/XX/XX</p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <!--同じページ遷移でレンタル履歴だけをすべての分表示？-->
        <div class="mottomiru"><p><a href="">もっと見る</a></p></div>
        <hr>
        <div class="float">
            <h3>購入履歴</h3>
            <select name="" id="" onchange="location.href=value;">
                <option value="" selected>フィルタを選択</option>
                <option value="/XXXX_xx_xx.html">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
                <option value="/XXXX_xx_xx">XXXX/XX/xx</option>
            </select>
        </div>
        <table border="2" align="center" style="border-collapse: collapse">
            <tr>
                <td>
                    <div class="item">
                        <img src="../image/511X2B00B0L.jpg" alt="秘密の部屋" width="200px" height="300px" class="bookPhoto" onclick="location.href='Detail.html'">
                        <div class="description">
                            <div class="btitle">
                                <p><b><a href="Detail.html">ハリーポッターと秘密の部屋</a></b></p>
                            </div>
                            <div class="mainInfo">
                                <p>購入日<br>XXXX/XX/XX</p>
                                <p>購入価格<br>XXXX円</p>
                                <input type="button" value="読む">
                            </div>
                            <div class="subInfo">
                                <p>著者<br>J.K.ローリング</p>
                                <p>出版社名<br>XXXX社</p>
                                <p>発行年月<br>XXXX/XX/XX</p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="item">
                        <img src="../image/511X2B00B0L.jpg" alt="秘密の部屋" width="200px" height="300px" class="bookPhoto" onclick="location.href='Detail.html'">
                        <div class="description">
                            <div class="btitle">
                                <p><b><a href="Detail.html">ハリーポッターと秘密の部屋</a></b></p>
                            </div>
                            <div class="mainInfo">
                                <p>購入日<br>XXXX/XX/XX</p>
                                <p>購入価格<br>XXXX円</p>
                                <input type="button" value="読む">
                            </div>
                            <div class="subInfo">
                                <p>著者<br>J.K.ローリング</p>
                                <p>出版社名<br>XXXX社</p>
                                <p>発行年月<br>XXXX/XX/XX</p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="mottomiru"><p><a href="">もっと見る</a></p></div>
    </main>
</body>

</html>