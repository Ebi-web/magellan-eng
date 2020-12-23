<?php session_start();
if (empty($_SESSION['username'])) {
    header("Location:../Login.php");
}
if (isset($_GET['id'])) :
    $_SESSION['m_id'] = $_GET['id'];
    $_SESSION['prop'] = $_GET['prop'];
    $_SESSION['opp'] = $_GET['opp'];
    $_SESSION['winner'] = $_GET['winner'];
    $_SESSION['judges'] = $_GET['judges'];
endif;
require_once("../functions.php");
try {
    // DBから表示するスピーチと画像をfetchしてくる
    fetch_speech();
    fetch_photo();
    // 役数の変数$cを設定する
    flowstyle();
    // 文字形式フローの読み込み回数を設定する
    $count = count($match);
    $loop = $count / $c;
    if (!is_int($loop)) : throw new Exception("フロー読み込み中にエラーが発生しました。恐れ入りますが，大会を再登録してください");
    endif;
} catch (Exception | PDOException $e) {
    echo $e->getMessage();
    echo "ERROR!ネットワーク接続をご確認の上，再度お試しください。再度このエラーが表示された場合はお手数ですがメインページのお問い合わせからお知らせください。";
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
    <link href="../assets/css/mainpage.css" rel="stylesheet">
    <link href='../assets/css/flowsheet.css' rel="stylesheet">
    <link href="../assets/css/font.css" rel="stylesheet">
    <link rel="apple-touch-icon" type="image/png" href="../assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="../assets/img/icon-192x192.png">
    <title>フローシート表示</title>
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../magellan_mainpage.php">Magellan</a>
        <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="../assets/img/望遠鏡.jpg" alt='望遠鏡' width='40' height='40'>
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
                            <a class="nav-link" href="../magellan_mainpage.php">
                                <span data-feather="home"></span>
                                メインページ
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#!">
                                <span data-feather="file"></span>
                                Favorites
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!">
                                <span data-feather="shopping-cart"></span>
                                Trash
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="../magellan_tournaments.php">
                                <span data-feather="users"></span>
                                大会別フロー管理
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../schools.php">
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
                <?php
                if (empty($match) && empty($photo)) : ?>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2"><?= h($_SESSION['tName']) ?></h1>
                        <div>
                            <button style="border: dashed 2px; margin-right:4px;" onclick="deleteCheck()" class="btn btn-light"><img src="../assets/img/ごみ箱のフリーアイコン.png"></button>
                            <button onclick="location.href='./register_newflow.php'" class="btn btn-outline-info">フローを登録</button>
                        </div>
                    </div>
                    <div class='memo'>

                        <img src='../assets/img/メモアイコン.jpeg'>


                        <p class="flowchar"><span>フローデータを登録しましょう!</span></p><br>

                    </div>
                <?php else : ?>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2"><?= h($_SESSION['tName']) ?></h1>
                        <div>
                            <button style="border: dashed 2px; margin-right:4px;" onclick="deleteCheck()" class="btn btn-light"><img src="../assets/img/ごみ箱のフリーアイコン.png"></button>
                            <button onclick="location.href='./flowsheet_modify.php'" class="btn btn-outline-info">フローを修正</button>
                            <button onclick="location.href='./register_newflow.php'" class="btn btn-outline-info">フローを追加登録</button>
                        </div>
                    </div>
                    <?php
                    $m = 1; // 何枚目かカウントする変数$m
                    // 画像の読み込み
                    if (!empty($photo)) :
                        foreach ($photo as $photos) : ?>
                            <strong><?= $m ?>枚目</strong>
                            <img src="../assets/img/<?= $photos['path'] ?>" class="width-100">
                            <?php $m++;
                        endforeach;
                    endif;
                    // 文字・音声形式で登録されたフローを読み込み
                    try {
                        if (!empty($match)) :
                            for ($i = 1, $j = 0; $i <= $loop; $i++, $m++, $j = $j + $c) : ?>
                                <strong> <?= $m ?>枚目</strong>
                <?php
                                switch ($_SESSION['flowstyle']):
                                    case 1:
                                        require "./flowsheet_academic.php";
                                        break;
                                    case 2:
                                        require "./flowsheet_nowhip.php";
                                        break;
                                    case 3:
                                        require "./whip.php";
                                        break;
                                    case 4:
                                        require "./wsdc.php";
                                        break;
                                    default:
                                        throw new Exception("フロー様式を取得できません。恐れ入りますが，もう一度大会を登録し直してください。");
                                endswitch;
                            endfor;
                        endif;
                    } catch (Exception $e) {
                        echo $e->getMessage();
                        exit();
                    }
                endif; ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
      ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
        function deleteCheck() {
            if (window.confirm('この試合のフロー・画像・音声を全て削除します。削除後の復元はできません。本当に削除しますか？')) {
                location.href = "./delete_match.php"
            }
        }
    </script>
</body>

</html>