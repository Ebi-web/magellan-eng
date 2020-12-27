<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location:../Login.php");
}
require_once("../functions.php");
try {
    //必要なsessionが揃っているか検査
    checksession("matches");
    // フローシートへ代入するスピーチ群をfetch
    fetch_speech();
    // 特定の試合に登録された画像群をfetch 
    fetch_photo();
    // フロー様式によって役数$cと役名$roleを設定
    flowstyle();
} catch (Exception | PDOException | RuntimeException $e) {
    echo $e->getMessage();
    exit();
}

try {
    $k = 0; // 変数$kは1枚分の表示が回ると0に戻って役名表示に使用
    $l = 0; // 変数$lはループごとに++されaudio削除ボタンのidに使用
    $m = 1;  // 変数$mは1枚分の表示が回ると++され枚数表示に使用
    // 入力フォームから文字または音声データが入力された後の処理(ユーザーの入力に応じて)
    update_flow();
    // 画像データの削除(ユーザーの入力に応じて)
    delete_photo();
    // 勝者・ジャッジ・議題の変更(ユーザーの入力に応じて)
    modify_minor();
    // フローの削除(ユーザーの入力に応じて)
    if (isset($_POST["delete"])) :
        delete_flow($_POST["delete"]);
    endif;
} catch (RuntimeException | PDOException $e) {
    echo $e->getMessage();
    echo 'フローシートの登録に失敗しました。ネットワーク接続をご確認の上，再度お試しください。このエラーが再度表示された場合にはお手数ですが，メインページのお問い合わせからお知らせください。';
    exit();
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
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="../assets/css/mainpage.css" rel="stylesheet">
    <link href="../assets/css/font.css" rel="stylesheet">
    <link href="../assets/css/erase.css" rel="stylesheet">
    <link rel="apple-touch-icon" type="image/png" href="../assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="../assets/img/icon-192x192.png">
    <title>Create New Flowsheet</title>
</head>

<body>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div>
                <h1 class="h2">フロー修正</h1>
                <strong>修正ボタンは一度だけ押してください。修正後にブラウザの戻るボタンを押さないでください。</strong>
            </div>
        </div>
        <p id="description">行う操作を選択してください</p>
        <button <?php if (empty($match)) : echo "disabled";
                endif; ?> type="button" class="btn btn-primary btn-lg btn-block" onclick="switchform(0);">文字・音声データの修正・削除</button>
        <button <?php if (empty($photo)) : echo "disabled";
                endif; ?> type="button" class="btn btn-secondary btn-lg btn-block" onclick="switchform(1);">画像の削除(追加は「フローを追加登録」から行ってください)</button>
        <button type="button" class="btn btn-success btn-lg btn-block" onclick="switchform(2);">勝利したサイド・議題・Judgesの修正</button>
        <form enctype="multipart/form-data" method="post" class="erase" id="chars">
            <?php
            if (!empty($match)) : ?>
                入力例：<textarea class="form-control" rows="7" readonly>AD1 Less Air Pollution
       PS Air pollution has been the unpending issue...=>https://example/evidence.com 
       EF 1:~~, 2:~~, 3:~~ 
       IM 1:~~
       ---------
       1st case (if the parliamentary style chosen)
       Status Quo...Social infrastructure should be bailed out.
       ex.:Postal services
      </textarea>
                <?php foreach ($match as $matches) : if ($k == 0) : ?><big><?= $m ?>枚目</big>
                        <button type="submit" form="delete" name="delete" value=<?= $m ?> class="btn btn-info"><?= $m ?>枚目を削除する</button>
                    <?php endif; ?>
                    <div class='form-group'>
                        <label><?= $role[$k] ?></label>
                        <textarea name="chars[]" rows="7" maxlength="500" class="form-control"><?= $matches['char_info'] ?></textarea>
                    </div>
                    <div class="input-group">
                        <div class="custom-file">
                            <input name="audio[]" type="file" multiple accept='audio/*' class="custom-file-input" id="inputGroupFile<?= $l ?>" aria-describedby="inputGroupFileAddon04">
                            <label class="custom-file-label" for="inputGroupFile04">音声ファイル貼り付け(mp3形式のみ可)</label>
                        </div>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset<?= $l ?>" onClick="clearAudio(<?= $l ?>);">取消</button>
                        </div>
                    </div>
            <?php $k++;
                    $l++;
                    if ($k == $c) : $k = 0;
                        $m++;

                    endif;
                endforeach;
            endif; ?>
            <div align="right">
                <button type="submit" class="btn btn-outline-dark">フローを修正する</button>
            </div>
        </form>
        <form method="post" id="delete"></form>
        <form enctype="multipart/form-data" class="erase" method="post" id="photo">
            <?php
            if (!empty($photo)) : $a = 0;
                foreach ($photo as $photos) : ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="inputphoto[]" type="checkbox" id="inlineCheckbox<?= $a ?>" value="<?= $photos["id"] ?>">
                        <label class="form-check-label" for="inlineCheckbox<?= $a ?>">
                            <img src="../assets/img/<?= $photos["path"] ?>" class="width-100">
                        </label>
                    </div>
            <?php $a++;
                endforeach;
            endif; ?>
            <div align="right">
                <button type="submit" class="btn btn-outline-dark">選択した画像を削除する</button>
            </div>
        </form>

        <form method='post' enctype="multipart/form-data" class="erase" id="minor">
            <legend>勝利サイド修正
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox1" value="<?= $_SESSION['prop'] ?>" name="winner" <?php if ($_SESSION['prop'] === $_SESSION['winner']) : echo 'checked';
                                                                                                                                        endif; ?>>
                    <label class="form-check-label" for="inlineCheckbox1"><?= $aff ?></label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="inlineCheckbox2" value="<?= $_SESSION['opp'] ?>" name="winner" <?php if ($_SESSION['opp'] === $_SESSION['winner']) : echo 'checked';
                                                                                                                                    endif; ?>>
                    <label class="form-check-label" for="inlineCheckbox2"><?= $neg ?></label>
                </div>
            </legend>
            <label for="resolved">Resolved(議題)の修正</label>
            <input type='text' name='resolved' id='resolved' value="<?= $_SESSION['topic'] ?>" maxlength="500">
            <label for="judges">Judgesの修正</label><input type="text" id="judges" name="judges" value="<?= $_SESSION['judges'] ?>" maxlength="20"><br>
            <div align="right">
                <button type="submit" class="btn btn-outline-dark">フローを修正する</button>
            </div>
        </form>
    </main>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- Bootstrap core JavaScript
      ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
    <script>
        bsCustomFileInput.init();

        function clearAudio(id) {
            let resetName = 'inputGroupFile' + id;
            let elem = document.getElementById(resetName);
            elem.value = '';
            elem.dispatchEvent(new Event('change'));
        }

        function switchform(form) {
            let chars = document.getElementById("chars");
            let photo = document.getElementById("photo");
            let minor = document.getElementById("minor");
            let desc = document.getElementById("description");
            if (form == 0) {
                chars.classList.remove("erase");
                photo.classList.add("erase");
                minor.classList.add("erase");
                desc.textContent = "修正する文字・音声を入力してください";
            } else if (form == 1) {
                chars.classList.add("erase");
                photo.classList.remove("erase");
                minor.classList.add("erase");
                desc.textContent = "削除する画像を選択してください";
            } else if (form == 2) {
                chars.classList.add("erase");
                photo.classList.add("erase");
                minor.classList.remove("erase");
                desc.textContent = "修正する議題・ジャッジ・勝者の情報を入力してください";
            }
        }
    </script>
    <script src="./assets/js/double_submit.js"></script>
</body>

</html>