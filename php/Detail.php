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


?>

<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/common.css" rel="stylesheet" type="text/css">
    <link href="../css/detail.css" rel="stylesheet" type="text/css">
    <title>商品詳細</title>
</head>

<body>
<header>
        <div id="top">
            <h1 id="title"><a href="top.php">BOOK ON</a></h1>
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
        //Result.phpから送られてきたデータを取得
        $b_code = $_GET['b_code'];
        //SQL文の実行
        $sql = "SELECT * FROM book Where b_code = ?";
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
            $author = $value["b_author"];
        ?>
            <h2>書籍情報</h2>
            <div class="dbox">
                <div class="image">
                    <img src="../image/<?= $value['b_thum'] ?>" alt="<?= $value['b_name']?>" align="left" width="300" height="375">
                </div>
                <div class="bdata">
                    <div class="tdata">
                        <p><a><?= $value['b_name'] ?></a></p>
                        <!--タイトルをphpでnameを表示-->
                    </div>
                    <table class="tablesize">
                        <div class="but">
                            <a class="author">著者 : <?= $value['b_author'] ?></a>
                            <a class="publisher">出版社名 : <?= $value['b_publisher'] ?></a>
                            <!--著者　出版社名 発行年月-->
                        </div>
                        <div>
                            <a class="release">発行年月 : <?= $value['b_release'] ?></a>
                        </div>
                    </table>
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
                                        <input type="hidden" name="b" value="reserve">
                                        <p class="tax">税込</p>
                                        <p class="price">&yen;<?= $value['b_purchaseprice'] ?></p>
                                        <p class="cart">カートに入れる</p>
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
                    <div class="bookd">
                        <h2>あらすじ</h2>
                        <!--あらすじデータを表示-->
                        <p>
                            <?= $value['b_synopsis1'] ?>
                            <?= $value['b_synopsis2'] ?>
                            <?= $value['b_synopsis3'] ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <h2>この商品の関係する本</h2>
        <div>
            <div>
                <?php

                $sql2 = "SELECT * FROM book WHERE b_author = ?";
                $stmt = $pdo->prepare($sql2);
                $stmt->execute(array($author));
                $array2 = $stmt->fetchAll(pdo::FETCH_ASSOC);

                ?>
                <div class="divr">
                    <?php foreach ($array2 as $value2) { ?>
                        <div class="sublist">
                            <div class="divimage">
                                <img src="../image/<?= $value2['b_thum'] ?>" alt="">
                            </div>
                            <div class="divinfo">
                                <p><a href="Detail.php?b_code=<?=$value2['b_code']?>"><?= $value2['b_name'] ?></a></p>
                                <p>税込&yen;<?= $value2['b_purchaseprice'] ?></p>
                                <p>カテゴリー:<a><?= $value2['b_category'] ?></a></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>