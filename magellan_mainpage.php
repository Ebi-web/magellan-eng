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
  <link href="./assets/css/mainpage.css" rel="stylesheet">
  <link href="./assets/css/toggle.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link href="./assets/css/tournaments.css" rel="stylesheet">
  <link href="./assets/css/font.css" rel="stylesheet">
  <link rel="apple-touch-icon" type="image/png" href="assets/img/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="assets/img/icon-192x192.png">
  <title>Magellan</title>
</head>

<body>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="./magellan_mainpage.php">Magellan</a>
    <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="./assets/img/望遠鏡.jpg" alt='望遠鏡' width='40' height='40'>
      </button>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        <!-- <a class="dropdown-item" href="#">Settings</a> -->
        <a class="dropdown-item" onclick="location.href='./Logout.php'">Log out</a>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">
                <span data-feather="home"></span>
                メインページ
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#!">
                <span data-feather="file"></span>
                お気に入りのフロー
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#!">
                <span data-feather="shopping-cart"></span>
                Trash
              </a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="./magellan_tournaments.php">
                <span data-feather="users"></span>
                大会別フロー管理
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./schools.php">
                <span data-feather="bar-chart-2"></span>
                学校別フロー管理
              </a>
            </li>
            <!-- <li class="nav-item">
                  <a class="nav-link" href="./registration_input.php">
                    <span data-feather="layers"></span>
                    Identification Renewal
                  </a>
                </li> -->
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">メインページ</h1>
        </div>
        <div class="kakomi-box12"><span class="title-box12">実装予定の機能(予告なく変更されます)</span>
          <ul>
            <li>大会などの予定を管理できるカレンダー機能</li>
          </ul>
        </div>
        <input type="checkbox" id="toggle">
        <div class="toggle-outer"><label for="toggle">
            <h4>使い方ガイド・アプリ使用上の注意▼(クリックで開く)</h4>
          </label>
          <hr>
        </div>
        <div class="toggle-inner">
          <h5>ご覧になりたいガイド情報を選択してください</h5><br>
          <select>
            <option value="0">選択してください</option>
            <option value="1">本アプリの概要</option>
            <option value="2">大会・試合・フローを登録・閲覧する方法</option>
            <option value="3">フローを修正する方法</option>
            <option value="4">大会・試合・フローを削除する方法</option>
            <option value="5">お問い合わせ・ご意見・ご感想</option>
          </select>
          <section id="1">
            <h6><span class="red">基本機能</span></h6>
            <hr>
            <p>本アプリMagellanは従来，管理が煩雑であった紙媒体の<span class="blue">フローシートをデジタル化</span>することを基本機能としております。<br>
              Magellanに登録された大会や試合についてのデータは部・同好会などのコミュニティ内で<span class="blue">いつでも閲覧・編集</span>が可能です。<br>
              また，フローシートは登録されると<span class="blue">自動で大会別・学校別</span>に整理されます。
            </p>
            <h6><span class="red">使用イメージ</span></h6>
            <hr>
            <p>
              <ul>
                <li>試合中は紙のフローシートを使って，終了後に内容を登録する</li>
                <li>試合中はスピーチを録音して，終了後に音声データを登録する</li>
                <li>特定の学校が出ている試合のみを集中して分析</li>
                <li>部員全員が同じフローシートを見ながら戦略会議</li>
              </ul>
            </p>
            <h6><span class="red">開発者より</span></h6>
            <hr>
            <p>Magellanは開発者が埼玉県の大宮高校英語部に在籍していた頃の体験を基に作られております。<br>
              当時，大会後の紙のフローシートが私のバインダーにパンパンに挟まれ，過去の試合の内容を振り返るのは大変でした。<br>
              「あの試合で良いアタックを聞いたけど何だっけ」「近所の強豪が出てる試合だけ集めたい」などといった時，時間がかかったものです。<br>
              もちろんファイルで管理すれば良かったのですが単純に面倒でした。<br>
              また，Gmailで部員たちのフローシートの内容が共有されてもそれぞれがオリジナルの書式を使うため情報の整理には手間がかかりました。<br>
              Magellanはこうした問題の解決のため<span class="blue">「ディベートコミュニティを便利にする」</span>を理念として，上記「基本機能」を軸に開発されました。<br>
              現在(2021年1月)黎明期にあるMagellanにとってユーザーである全国のEnglish Debatersの皆様からのフィードバック・ご感想はとても貴重なものです。<br>
              もっとこういう機能がほしい・ここが使いにくいなど何かお気づきの点があれば使い方ガイドの「お問い合わせ・ご意見・ご感想」からお寄せください。<br>
            </p>
          </section>
          <section id="2">
            <h6>大会・試合・フローを登録・フローを閲覧する方法をご説明します。</h6>
            <hr>
            <ul>
              <li><span class="red">大会を登録する方法</span> <br>①画面左のメニューから大会別フロー管理をクリック<br>
                ②画面右上の新規大会追加ボタンをクリックして必要事項を入力(登録ボタンは1度だけ押してください)</li>
              <hr>
              <li><span class="red">試合を登録する方法その1(一般的な方法)</span><br>①画面左のメニューから大会別フロー管理をクリック<br>
                ②登録したい試合が行われた大会をクリック(なければ大会を登録)<br>
                ③画面右上の試合登録ボタンをクリックして必要事項を入力(登録ボタンは1度だけ押してください)<br>
                <span class="blue">自校が出た試合を登録するのには必ず「自校vs.他校」のボタンを使い，「他校vs.他校」のボタンは使わないでください</span></li>
              <hr>
              <li><span class="red">試合を登録する方法その2(特定の学校が出た試合を登録する場合におすすめ)</span><br>①画面左のメニューから学校別フロー管理をクリック<br>
                ②学校名・大会を選択(ない場合は画面右上のボタンからそれぞれ登録)<br> ③画面右上の試合登録ボタンをクリックして必要事項を入力(登録ボタンは1度だけ押してください)<br>
                <span class="blue">自校が出た試合を登録するのには必ず「vs.自校」のボタンを使い，「vs.他校」のボタンは使わないでください</span>
              </li>
              <hr>
              <li>
                <span class="red">フローシートを登録・閲覧する方法</span><br>①画面左のメニューの大会別フロー管理または学校別フロー管理から大会ページへアクセス<br>
                ②フローシートを登録したい試合をクリック(なければ登録)<br> ③画面右上のフローを登録ボタンをクリックして必要事項を入力(登録ボタンは1度だけ押してください)<br>
                <span class="blue">大会ページでは横の1行が1試合を表し，同じ横の行にある校名であればどれをクリックしても同じ試合のフローシート閲覧ページにアクセスできます</span>
              </li>
            </ul>
            <div class="box8">
              <p><span class="blue">参照(例)：この例では3つの校名の内，どれをクリックしても同じ「Omiya H.S. vs. 千葉高校」のフローシートに飛べます。</span><img src="assets/img/match.png"></p>
            </div>
          </section>
          <section id="3">
            <h6>フローを修正・削除する方法をご説明します。</h6>
            <hr>
            <ul>
              <li><span class="red">フローを修正する方法</span>
                ①フロー閲覧画面で登録されているフローを表示<br>
                ②画面右上のフローを修正ボタンをクリックして必要事項を入力(修正ボタンは1度だけ押してください)<br>
                <span class="blue">アプリの設計上，複数のユーザーが同時に修正を行うと最後に修正ボタンを押したユーザーの修正データのみが反映され，<br>それ以外のユーザーの修正データは上書きされます。恐れ入りますが，十分にご注意ください。</span>
              </li>
            </ul>
          </section>
          <section id="4">
            <h6>大会・試合・フローを削除する方法をご説明します。</h6>
            <hr>
            <ul>
              <li><span class="red">大会を削除する方法</span> <br>①大会ページで削除する大会を表示<br>
                ②画面右上のゴミ箱ボタンをクリック(確認メッセージが表示されます)<br>
                <span class="blue">一度削除した大会データは，そこに登録されている試合・フローシートのデータも含めて復元できません。十分にご注意ください。</span>
              </li>
              <hr>
              <li><span class="red">試合を削除する方法</span> <br>①フローシートページで削除する試合のフローシートを表示<br>
                ②画面右上のゴミ箱ボタンをクリック(確認メッセージが表示されます)<br>
                <span class="blue">一度削除した試合データは，そこに登録されているフローシートのデータも含めて復元できません。十分にご注意ください。</span>
              </li>
              <hr>
              <li><span class="red">フローシートを削除する方法</span> <br>①削除するフローシートを表示<br>
                ②画面右上の「フローを修正」ボタンをクリック<br> ③「文字・音声データの修正・削除」から「〇枚目を削除」をクリック<br>
                <span class="blue">一度削除したフローシートのデータは復元できません。十分にご注意ください。</span>
              </li>
              <hr>
              <div class="box8">
                <p>大会・試合・フローの各登録内容はこのように階層分けされており，外側の登録内容が削除されると，それより内側の登録内容も自動的に削除されます。<img src="./assets/img/layer.png"></p>
              </div>
            </ul>
          </section>
          <section id="5">お問い合わせ・ご意見・ご感想はこちらのメールフォーム(開発者へ直通)からお寄せください。<br>特に改善点についてのご意見はMagellanの質向上のために役立てられます。<a href="#mailgo" data-address="conamn1185" data-domain="gmail.com" data-subject="Magellanホットライン">こちらをクリック</a></section>
        </div>
      </main>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/mailgo@0.11.1/dist/mailgo.min.js"></script>
  <script>
    "use strict";
    $('select').change(function() {
      var val = $('select option:selected').val();
      if (val == 0) {
        $('section').fadeOut(1000);
      } else {
        $('section').fadeOut(1000);
        $('section#' + val).fadeIn(1000);
      }
    });
  </script>
</body>

</html>