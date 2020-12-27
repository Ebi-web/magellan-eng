<?php session_start();
if (empty($_SESSION['username'])) {
    header("Location:./Login.php");
}
try {
    require_once("./functions.php");
    if (isset($_GET['id']) && isset($_GET['name']) && isset($_GET['date'])) :
        $_SESSION['abst_id'] = $_GET['id'];
        $_SESSION['tName'] = $_GET['name'];
        $_SESSION['date'] = $_GET['date'];
        $_SESSION['flowstyle'] = $_GET['flow'];
        $_SESSION['topic'] = $_GET['topic'];
    endif;
    checksession("tournaments");
    $sql = 'select * from m_ab_local WHERE abst_id=?';
    $stmt0 = $pdo->prepare($sql);
    $stmt0->execute(array($_SESSION['abst_id']));
    $match = $stmt0->fetchAll();
    sort_match($match);
} catch (Exception | PDOException $e) {
    echo $e->getMessage();
    exit("ERROR!ネットワーク接続をご確認の上再度お試しください。再びこのエラーが表示された場合にはお手数ですがメインページのお問い合わせからお知らせください。");
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
    <link href="./assets/css/mainpage.css" rel="stylesheet">
    <link href='./assets/css/tab.css' rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="./assets/css/font.css" rel="stylesheet">
    <link rel="apple-touch-icon" type="image/png" href="assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="assets/img/icon-192x192.png">
    <title><?= $_SESSION['tName'] ?></title>
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
                            <a class="nav-link" href="./magellan_mainpage.php">
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
                            <a class="nav-link active" href="./magellan_tournaments.php">
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"'>
                    <h1 class="h2"><?= h($_SESSION['date']) ?>の<?= h($_SESSION['tName']) ?></h1>
                    <div nowrap>
                        <button style="border: dashed 2px; margin-right:4px;" onclick="deleteCheck()" class="btn btn-light"><img src="assets/img/ごみ箱のフリーアイコン.png"></button><button type="button" class="btn btn-success buttonleft" onclick="location.href=' ./tournaments_jikoutakou.php'">自校vs.他校の試合登録 </button> <button type="button" class="btn btn-info buttonright" onclick="location.href='./tournaments_takoutakou.php'">他校vs.他校の試合登録</button>
                </div>
        </div>
    </div>
    </div>
    <div class="tab_wrap">
        <input id="tab1" type="radio" name="tab_btn" checked>
        <input id="tab2" type="radio" name="tab_btn">
        <input id="tab3" type="radio" name="tab_btn">
        <input id="tab4" type="radio" name="tab_btn">

        <div class="tab_area">
            <label class="tab1_label" for="tab1">Round1</label>
            <label class="tab2_label" for="tab2">Round2</label>
            <label class="tab3_label" for="tab3">Round3</label>
            <label class="tab4_label" for="tab4">Round4</label>
        </div>
        <div class="panel_area">
            <div id="panel1" class="tab_panel" style="text-align: center;">
                <?php if (empty($matches1)) : ?><img src='assets/img/データベースの無料アイコン2.png'><br><span style="font-weight:bold">試合データがありません</span>
                <?php else : ?>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>肯定側</th>
                                <th>否定側</th>
                                <th>勝者</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matches1 as $round1) :
                                if ($round1['round_no'] != 1) {
                                    continue;
                                } else { ?>
                                    <tr>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round1['id'] ?>&prop=<?= $round1['proposition'] ?>&opp=<?= $round1['opposition'] ?>&winner=<?= $round1['winner'] ?>&judges=<?= $round1['judges'] ?>'>
                                                <?php if ($round1['proposition'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round1['proposition']);
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round1['id'] ?>&prop=<?= $round1['proposition'] ?>&opp=<?= $round1['opposition'] ?>&winner=<?= $round1['winner'] ?>&judges=<?= $round1['judges'] ?>'>
                                                <?php if ($round1['opposition'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round1['opposition']);
                                                } ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round1['id'] ?>&prop=<?= $round1['proposition'] ?>&opp=<?= $round1['opposition'] ?>&winner=<?= $round1['winner'] ?>&judges=<?= $round1['judges'] ?>'>
                                                <?php if (is_null($round1['winner'])) {
                                                    echo '引き分けまたは勝敗不明';
                                                } elseif ($round1['winner'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round1['winner']);
                                                } ?>
                                            </a>
                                        </td>
                                    </tr>
                        <?php }
                            endforeach;
                        endif;
                        ?>
                        </tbody>
                    </table>
            </div>
            <div id="panel2" class="tab_panel" style="text-align: center;">
                <?php if (empty($matches2)) : ?><img src='assets/img/データベースの無料アイコン2.png'><br><span style="font-weight:bold">試合データがありません</span>
                <?php else : ?>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>肯定側</th>
                                <th>否定側</th>
                                <th>勝者</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matches2 as $round2) :
                                if ($round2['round_no'] != 2) {
                                    continue;
                                } else { ?>
                                    <tr>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round2['id'] ?>&prop=<?= $round2['proposition'] ?>&opp=<?= $round2['opposition'] ?>&winner=<?= $round2['winner'] ?>&judges=<?= $round2['judges'] ?>'>
                                                <?php if ($round2['proposition'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round2['proposition']);
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round2['id'] ?>&prop=<?= $round2['proposition'] ?>&opp=<?= $round2['opposition'] ?>&winner=<?= $round2['winner'] ?>&judges=<?= $round2['judges'] ?>'>
                                                <?php if ($round2['opposition'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round2['opposition']);
                                                } ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round2['id'] ?>&prop=<?= $round2['proposition'] ?>&opp=<?= $round2['opposition'] ?>&winner=<?= $round2['winner'] ?>&judges=<?= $round2['judges'] ?>'>
                                                <?php if (is_null($round2['winner'])) {
                                                    echo '引き分けまたは勝敗不明';
                                                } elseif ($round2['winner'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round2['winner']);
                                                } ?>
                                            </a>
                                        </td>
                                    </tr>
                            <?php }
                            endforeach; ?>
                        </tbody>
                    </table>
                <?php endif;
                ?>

            </div>
            <div id="panel3" class="tab_panel" style="text-align: center;">
                <?php if (empty($matches3)) : ?><img src='assets/img/データベースの無料アイコン2.png'><br><span style="font-weight:bold">試合データがありません</span>
                <?php else : ?>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>肯定側</th>
                                <th>否定側</th>
                                <th>勝者</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matches3 as $round3) :
                                if ($round3['round_no'] != 3) {
                                    continue;
                                } else { ?>
                                    <tr>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round3['id'] ?>&prop=<?= $round3['proposition'] ?>&opp=<?= $round3['opposition'] ?>&winner=<?= $round3['winner'] ?>&judges=<?= $round3['judges'] ?>'>
                                                <?php if ($round3['proposition'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round3['proposition']);
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round3['id'] ?>&prop=<?= $round3['proposition'] ?>&opp=<?= $round3['opposition'] ?>&winner=<?= $round3['winner'] ?>&judges=<?= $round3['judges'] ?>'>
                                                <?php if ($round3['opposition'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round3['opposition']);
                                                } ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round3['id'] ?>&prop=<?= $round3['proposition'] ?>&opp=<?= $round3['opposition'] ?>&winner=<?= $round3['winner'] ?>&judges=<?= $round3['judges'] ?>'>
                                                <?php if (is_null($round3['winner'])) {
                                                    echo '引き分けまたは勝敗不明';
                                                } elseif ($round3['winner'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round3['winner']);
                                                } ?>
                                            </a>
                                        </td>
                                    </tr>
                            <?php }
                            endforeach; ?></tbody>
                    </table>
                <?php endif;
                ?>
            </div>
            <div id="panel4" class="tab_panel" style="text-align: center;">
                <?php if (empty($matches4)) : ?><img src='assets/img/データベースの無料アイコン2.png'><br><span style="font-weight:bold">試合データがありません</span>
                <?php else : ?>
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>肯定側</th>
                                <th>否定側</th>
                                <th>勝者</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($matches4 as $round4) :
                                if ($round4['round_no'] != 4) {
                                    continue;
                                } else { ?>
                                    <tr>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round4['id'] ?>&prop=<?= $round4['proposition'] ?>&opp=<?= $round4['opposition'] ?>&winner=<?= $round4['winner'] ?>&judges=<?= $round4['judges'] ?>'>
                                                <?php if ($round4['proposition'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round4['proposition']);
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round4['id'] ?>&prop=<?= $round4['proposition'] ?>&opp=<?= $round4['opposition'] ?>&winner=<?= $round4['winner'] ?>&judges=<?= $round4['judges'] ?>'>
                                                <?php if ($round4['opposition'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round4['opposition']);
                                                } ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href='flowsheets/flowsheet.php?id=<?= $round4['id'] ?>&prop=<?= $round4['proposition'] ?>&opp=<?= $round4['opposition'] ?>&winner=<?= $round4['winner'] ?>&judges=<?= $round4['judges'] ?>'>
                                                <?php if (is_null($round4['winner'])) {
                                                    echo '引き分けまたは勝敗不明';
                                                }
                                                if ($round4['winner'] == 0) {
                                                    echo h($_SESSION['username']);
                                                } else {
                                                    thirdparty($round4['winner']);
                                                } ?>
                                            </a>
                                        </td>
                                    </tr>
                            <?php }
                            endforeach; ?></tbody>
                    </table>
                <?php endif;
                ?>

            </div>


        </div>
    </div>
    </main>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
        function deleteCheck() {
            if (window.confirm('この大会データを削除します。削除後の復元はできません。本当に削除しますか？')) {
                location.href = "./delete_tournament.php"
            }
        }
    </script>
</body>

</html>