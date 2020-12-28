<?php session_start();
require_once("../functions.php");
//必要なsessionが揃っているか検査
checksession("matches");
header('X-Content-Type-Options: nosniff');
try {
  // フローシートの様式に合わせて変数を設定
  flowstyle();
  // 入力フォームから文字・音声データが入力された後の処理
  insert_flow();
  // 入力フォームから画像が入力された後の処理
  photo();
} catch (PDOException | Exception | RuntimeException $e) {
  echo $e->getMessage();
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
  <link href="../assets/css/progress.css" rel="stylesheet">
  <link href="../assets/css/erase.css" rel="stylesheet">
  <link rel="apple-touch-icon" type="image/png" href="../assets/img/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="../assets/img/icon-192x192.png">
  <title>Create New Flowsheet</title>
</head>

<body>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">新規フロー登録</h1>
      <strong>登録ボタンは一度だけ押してください。また，登録後にブラウザの戻るボタンを押さないでください。</strong>
    </div>
    <ol class="progress-bar0">
      <li id="active-now" class="is-active"><span>登録方法を選択</span></li>
      <li id="post-active"><span>登録データを入力</span></li>
      <li><span>確認</span></li>
    </ol>
    <button onclick="formswitch(0)" class="btn btn-primary btn-lg btn-block">テキストで入力する</button>
    <button onclick="formswitch(1)" type="button" class="btn btn-secondary btn-lg btn-block">写真をアップロードする</button>

    <div id="photo" class="erase">
      <br>
      <strong>同時に3枚までアップロードできます。(拡張子は.jpg,.jpeg,.pngのみ可能)</strong>
      <form method='post' enctype="multipart/form-data">
        <?php for ($i = 1; $i <= 3; $i++) : ?>
          <div class="input-group">
            <div class="custom-file">
              <input name="photo[]" type="file" multiple accept='image/*' class="custom-file-input" id="inputGroupFile<?= $i ?>" aria-describedby="inputGroupFileAddon04">
              <label class="custom-file-label" for="inputGroupFile04">画像ファイル貼り付け</label>
            </div>
            <div class="input-group-append">
              <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset<?= $i ?>" onClick="clearAudio(<?= $i ?>);">取消</button>
            </div>
          </div>
        <?php endfor; ?>
        <button type="submit" class="btn btn-outline-dark">写真をアップロードする</button>
      </form>
    </div>
    <div id="text" class="erase">
      入力例：
      <textarea class="form-control" rows="7" readonly>AD1 Less Air Pollution
       PS Air pollution has been the unpending issue...=>https://example/evidence 
       EF 1:~~, 2:~~, 3:~~ 
       IM 1:~~
       ---------
       1st case (if the parliamentary style chosen)
       Status Quo...Social infrastructure should be bailed out.
       ex.:Postal services
      </textarea>
      <form method='post' enctype="multipart/form-data">
        <?php
        $k = 1;
        foreach ($role as $roles) : ?>
          <div class='form-group'>
            <label><?= $roles ?></label>
            <textarea name=" chars[]" rows="7" class="form-control" maxlength="500"></textarea>
          </div>
          <div class="input-group">
            <div class="custom-file">
              <input name="audio[]" type="file" multiple accept='audio/*' class="custom-file-input" id="inputGroupFile<?= $k ?>" aria-describedby="inputGroupFileAddon04">
              <label class="custom-file-label" for="inputGroupFile04">音声ファイル貼り付け(mp3形式のみ可能)</label>
            </div>
            <div class="input-group-append">
              <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset<?= $k ?>" onClick="clearAudio(<?= $k ?>);">取消</button>
            </div>
          </div>
        <?php $k++;
        endforeach;
        ?>
        <div align="right">
          <button type="submit" class="btn btn-outline-dark">フローを登録する</button>
        </div>
      </form>
    </div>
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
    "use strict";

    bsCustomFileInput.init();

    function clearAudio(id) {
      var resetName = 'inputGroupFile' + id;
      var elem = document.getElementById(resetName);
      elem.value = '';
      elem.dispatchEvent(new Event('change'));
    }

    function formswitch(checker) {
      let text = document.getElementById("text");
      let photo = document.getElementById("photo");
      let progress = document.getElementById("active-now");
      let next = document.getElementById("post-active");
      if (checker == 0) {
        text.classList.remove("erase");
        photo.classList.add("erase");
      } else if (checker == 1) {
        text.classList.add("erase");
        photo.classList.remove("erase");
      }
      progress.classList.remove("is-active");
      next.classList.add("is-active");
    }
  </script>
  <script src="../assets/js/double_submit.js"></script>
</body>

</html>