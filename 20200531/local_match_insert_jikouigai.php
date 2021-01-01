<?php
session_start();
require_once("./functions.php");
try {
    //必要なsessionがあるか検査
    checksession("tournaments");
    // ターゲット校以外の高校をfetchしてプルダウンメニューへ送る
    $sql1 = "select * from others WHERE holder_id=? AND id not in (?)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute(array($_SESSION['userid'], $_SESSION['id']));
    $other = $stmt1->fetchAll();
    if (isset($_POST["propchecker"])) :
        // 1.チェッカーと勝者の値が0~2かチェック
        // だめなら例外を投げる
        $checker = new validate_checker(2);
        $checker->validate();
        validate_winner();
        // propとoppのバリデーションだめなら例外を投げる
        validate_schoolname();
        // m_ab_localに試合を挿入
        insert_match(1); //引数1で特定のinsertモードへと移行
        header('Location:./local_matches.php');
    endif;
} catch (Exception | PDOException $e) {
    echo $e->getMessage();
    exit('試合登録に失敗しました。ネットワーク接続をご確認の上，再度お試しください。再びこのエラーメッセージが表示された場合，お手数ですがメインページのお問い合わせからお知らせください。');
}
?>
<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>新規試合登録</title>
    <link rel="stylesheet" href="assets/css/forms.css">
    <link rel="apple-touch-icon" type="image/png" href="assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="assets/img/icon-192x192.png">
</head>

<body>
    <h1>新規試合登録</h1>
    <strong>登録ボタンは一度だけ押してください。登録後にブラウザの戻るボタンを押さないでください。</strong>
    <form method="post" name="register">
        <fieldset>
            <legend class="box11">ラウンド数
                <label>
                    <select name="round">
                        <?php for ($i = 1; $i < 5; $i++) : ?>
                            <option value=<?= $i ?>><?= $i ?></option>;
                        <?php endfor; ?>
                    </select>ラウンド目</label>
            </legend>
            <strong>入力欄は対応する左側のボタンを押すことで入力可能になります</strong>
            <legend class="box11">肯定側
                <div><input type="radio" name="propchecker" value="0" onclick="jikou0()" required><label id='target'><?= $_SESSION['name'] ?></label><br><input type="radio" name="propchecker" value="1"><select onchange="inputSchool0()" name="prop" id="prop0"><?php foreach ($other as $others) : ?><option value="<?= $others['id'] ?>"><?= $others['school_name'] ?></option><?php endforeach; ?></select><input type="radio" name="propchecker" value="2"><label for='prop1'>選択メニューに校名がない場合のみ入力：<input type="text" name="prop" id="prop1" onkeyup="inputCheck0();" placeholder="○○高校" maxlength="30" disabled></label></div>
            </legend>
            <legend class="box11">否定側
                <div><input type="radio" name="oppchecker" value="0" onclick="jikou1()" required><?= $_SESSION['name'] ?><br><input type="radio" name="oppchecker" value="1"><select onchange="inputSchool1()" name="opp" id="opp0"><?php foreach ($other as $others) : ?><option value="<?= $others['id'] ?>"><?= $others['school_name'] ?></option><?php endforeach; ?></select><input type="radio" name="oppchecker" value="2"><label for='opp1'>選択メニューに校名がない場合のみ入力：<input type="text" name="opp" id="opp1" onkeyup="inputCheck1();" placeholder='○○高校' maxlength="30" disabled></label></div>
            </legend>
            <legend class="box11">勝者
                <label for='win0'><input type='radio' id='win0' name='winner' value="0" required><span id="proposition">肯定側選択待ち</span></label>
                <label for='win1'><input type='radio' id='win1' name='winner' value="1"><span id="opponent">否定側選択待ち</span></label>
                <label for='win2'><input type='radio' id='win2' name='winner' value='2'>勝敗なしまたは引き分け</label>
            </legend>
            <label for="judges" class="box11">Judgesの登録(任意)<input type="text" name="judges" id="judges" placeholder="○○先生, Mr.XX,..." maxlength="20"></label> <button type="submit" class="btn btn-outline-success">確認</button>
        </fieldset>
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
        'use strict';
        // 選択されている<option>要素を取り出す

        var targetSchool = document.getElementById('target');


        function inputSchool0() {
            var selected0 = $("#prop0").children("option:selected");
            document.getElementById("proposition").textContent = selected0.text();
        }

        function inputSchool1() {
            var selected1 = $("#opp0").children("option:selected");
            document.getElementById("opponent").textContent = selected1.text();
        }

        function inputCheck0() {
            let inputValue = document.getElementById('prop1').value;
            document.getElementById('proposition').textContent = inputValue;
        }

        function inputCheck1() {
            let inputValue = document.getElementById('opp1').value;
            document.getElementById('opponent').textContent = inputValue;
        }

        $(function() {
            $('input[name="propchecker"]:radio').change(function() {
                var radioval1 = $(this).val();
                if (radioval1 == '1') {
                    $('#prop0').removeAttr('disabled');
                    $('#prop1').attr('disabled', 'disabled');
                } else {
                    $('#prop0').attr('disabled', 'disabled');
                    $('#prop1').removeAttr('disabled');
                }
            });
        });
        $(function() {
            $('input[name="oppchecker"]:radio').change(function() {
                var radioval2 = $(this).val();
                if (radioval2 == '1') {
                    $('#opp0').removeAttr('disabled');
                    $('#opp1').attr('disabled', 'disabled');
                } else {
                    $('#opp0').attr('disabled', 'disabled');
                    $('#opp1').removeAttr('disabled');
                }
            });
        });

        function jikou0() {
            document.getElementById("proposition").textContent = target.textContent;
        }

        function jikou1() {
            document.getElementById("opponent").textContent = target.textContent;
        }
    </script>
    <script src="./assets/js/submission_optimizer.js"></script>
</body>

</html>