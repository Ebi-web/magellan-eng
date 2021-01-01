<?php
session_start();
require_once("./functions.php");
try {
    if (isset($_POST["prop"]) && isset($_POST["opp"])) :
        insert_match(0); //引数0で特定のinsertモードへ切り替え
        header('Location:./local_matches.php');
    endif;
    checksession("tournaments");
} catch (PDOException $e) {
    echo $e->getMessage();
    exit('試合の登録に失敗しました。ネットワークをご確認の上，再度お試しください。再びこのエラーメッセージが表示された場合，お手数ですがメインページのお問い合わせからお知らせください。');
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
    <h1>新規試合登録(対自校のみ)</h1>
    <strong>登録ボタンは一度だけ押してください。登録後にブラウザの戻るボタンを押さないでください。</strong>
    <form method="post">
        <fieldset>
            <legend class="box11">ラウンド数
                <label>
                    <select name="round">
                        <?php for ($i = 1; $i < 5; $i++) {
                            echo '<option value="', $i, '">', $i, '</option>';
                        } ?>
                    </select>ラウンド目</label>
            </legend>
            <legend class="box11">肯定側
                <label for='prop0'><input type='radio' id='prop0' name='prop' value='0' onClick="prop0(this.checked);" required><?= $_SESSION['username'] ?></label>
                <label for='prop1'><input type='radio' id='prop1' name='prop' value="1" onClick="prop1(this.checked);"><?= $_SESSION['name'] ?></label>
            </legend>
            <legend class="box11">否定側
                <label for='opp0'><input type='radio' id='opp0' name='opp' value='0' required><?= $_SESSION['username'] ?></label>
                <label for='opp1'><input type='radio' id='opp1' name='opp' value="1"><?= $_SESSION['name'] ?></label>
            </legend>
            <legend class="box11">勝者
                <label for='win0'><input type='radio' id='win0' name='winner' value="0" required><?= $_SESSION['username'] ?></label>
                <label for='win1'><input type='radio' id='win1' name='winner' value="1"><?= $_SESSION['name'] ?></label>
                <label for='win2'><input type='radio' id='win2' name='winner' value='2'>勝敗なしまたは引き分け</label>
            </legend>
            <label class="box11" for="judges">Judgesの登録(任意)<input type="text" name="judges" id="judges" placeholder="○○先生, Mr.XX,..." maxlength="20"></label>
            <button type="submit" class="btn btn-outline-success">確認</button>
        </fieldset>
    </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $('input[name="prop"]:radio').change(function() {
                var radioval = $(this).val();
                if (radioval === "0") {
                    $('input:radio[name="opp"]').val(["1"]);
                } else {
                    $('input:radio[name="opp"]').val(["0"]);
                }
            });

            $('input[name="opp"]:radio').change(function() {
                var radioval2 = $(this).val();
                if (radioval2 === "0") {
                    $('input:radio[name="prop"]').val(["1"]);
                } else {
                    $('input:radio[name="prop"]').val(["0"]);
                }
            });
        });
    </script>
    <script src="./assets/js/submission_optimizer.js"></script>
</body>

</html>