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

<body>
    <header>
        <div id="top">
            <h1 id="title"><a href="top.php">BOOK ON</a></h1>
            <p id="subtitle">It's a book but it's not a book!</p>
            <div id="right">
                <input type="button" value="カートを見る" onclick="location.href='buycart.php'">
                <input type="button" value="マイページ" onclick="location.href='Mypage.php' ">
            </div>
        </div>
        <hr>
        <div align="center">
            <form method="get" action="./Result.php">
                <select name="searchCondition">
                    <option value="b_title">書籍</option>
                    <option value="author">作者</option>
                </select>
                <input type="text" name="searchWord">
                <input type="submit" value="🔍">
            </form>
        </div>
        <hr>
    </header>
    <main>
        <h2>注文が完了しました</h2>
        <p>ご注文ありがとうございます。</p>
        <a href="../html/top.php">topに戻る</a>
    </main>
</body>

</html>