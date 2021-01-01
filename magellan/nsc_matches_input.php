<?php session_start();
require_once("./functions.php");
checksession("global");
?>
<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>大会データ追加</title>
    <link rel="stylesheet" href="assets/css/forms.css">
    <link rel="apple-touch-icon" type="image/png" href="assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="assets/img/icon-192x192.png">
</head>

<body>
    <!-- ローカル管理の新規大会と日程の入力フォーム -->
    <div align='center'>
        <big>新規大会データ追加</big>
    </div>
    <strong>登録ボタンは一度だけ押してください。登録後にブラウザの戻るボタンを押さないでください。</strong>
    <form method="post" action="./tournament_sql.php">
        <fieldset>
            <legend>登録する大会データ</legend>
            <p class="box11"><label for="gidai">議題</label><input style="width:100%" type='text' name='gidai' id="gidai" required autofocus maxlength="140"></p>
            <p class="box11"><label for="taikaimei">大会名</label><input type='text' name='taikaimei' id="taikaimei" required maxlength="20"></p>
            <p class="box11"><label for="nittei">大会日程</label><input type='date' name='nittei' pattern="^\d{4}-\d\d-\d\d$" title="西暦-月-日の形式で入力してください" required></p>
            <p class="box11"><label for="flowstyle">ディベート方式</label><select name='flowstyle' id="flowstyle" required>
                    <option value='1'>アカデミック</option>
                    <option value='2'>パーラ(Whipなし)</option>
                    <option value='3'>パーラ(Whipあり)</option>
                    <option value='4'>JWSDCまたはWSDC</option>
                </select></p>
            <p><button type="submit" class="btn btn-primary">確定</button></p>
        </fieldset>
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="./assets/js/submission_optimizer.js"></script>
</body>

</html>