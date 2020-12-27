<?php session_start();
require_once("./functions.php");
if (empty($_SESSION['username'])) {
    header("Location:./Login.php");
}
try {
    if (isset($_GET['name']) && isset($_GET['id'])) :
        $_SESSION['name'] = h($_GET['name']);
        $_SESSION['id'] = h($_GET['id']);
    endif;
    //必要なsessionが揃っているか検査。だめなら1つ前のページへ戻す。
    checksession("schools");
    // 特定相手校が関係する大会のみを取得する機構
    $sql = 'select * from m_ab_local WHERE proposition=? OR opposition=?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_SESSION['id'], $_SESSION['id']));
    $inputTour0 = $stmt->fetchAll();
    $inputTour1 = array();
    foreach ($inputTour0 as $inputTours0) :
        array_push($inputTour1, $inputTours0['abst_id']);
    endforeach;
    $inputTour = array_unique($inputTour1);
    $outputTour = array();
    $sql1 = "select * from t_abst_local WHERE id=?";
    $stmt1 = $pdo->prepare($sql1);
    foreach ($inputTour as $inputs) :
        $stmt1->execute(array($inputs));
        $output = $stmt1->fetchAll();
        array_push($outputTour, $output[0]);
    endforeach;
    // コメント取得機構
    $sql2 = 'select * from comment WHERE school_id=?';
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array($_SESSION['id']));
    $comment = $stmt2->fetchAll();
    // コメント追加機構    
    if (isset($_POST['comment'])) :
        $newcomment = $_POST["comment"]; //POSTされたコメントは変数へ代入
        if (!mb_strwidth($newcomment, "UTF-8") > 50) : throw new Exception("コメントが長すぎます。1つのコメントはスペースを含めて半角100字以内に収めてください");
        endif; //バリデーション
        $sql3 = 'insert into comment values(?,?,?)';
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute(array(null, $_SESSION['id'], $newcomment));
        header("Location:./newschool_matches.php"); //DB格納後に再読み込み
    endif;
    // コメント削除機構
    if (isset($_POST['delete'])) :
        $sql4 = 'delete from comment WHERE id=?';
        $stmt4 = $pdo->prepare($sql4);
        $stmt4->execute(array($_POST['delete']));
        header("Location:./newschool_matches.php");
    endif;
} catch (Exception | PDOException $e) {
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
    <link href="./assets/css/mainpage.css" rel="stylesheet">
    <link href="assets/css/newschool_matches.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="./assets/css/tournaments.css" rel="stylesheet">
    <link href="./assets/css/font.css" rel="stylesheet">
    <link rel="apple-touch-icon" type="image/png" href="assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="assets/img/icon-192x192.png">
    <title><?= $_SESSION['name'] ?></title>
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
                            <a class="nav-link" href="./magellan_tournaments.php">
                                <span data-feather="users"></span>
                                大会別フロー管理
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./schools.php">
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
                    <h1 class="h2"><?= $_SESSION['name'] ?>のデータ</h1>
                </div>
                <?php $i = 0;
                foreach ($outputTour as $outputTours) : ?>
                    <a href="./local_matches.php?id=<?= $outputTours['id'] ?>&name=<?= $outputTours['t_name'] ?>&date=<?= $outputTours['t_date'] ?>&flow=<?= $outputTours['flowstyle'] ?>&topic=<?= $outputTours['topic'] ?>">
                        <?= h($outputTours['t_date']) ?>開催の <?= h($outputTours['t_name']) ?>の詳細
                    </a>
                    <br><br>
                <?php $i++;
                endforeach; ?>
                <div class='comment'><span class='thick'> Comment about This School</span>
                    <?php if (empty($comment)) :;
                    else : foreach ($comment as $comments) : ?><p class='maincomment'><?= h($comments['comment']) ?></p>
                            <form method="post"><button class="btn btn-light" type="submit" name="delete" value="<?= $comments['id'] ?>">コメント削除</button></form>
                    <?php endforeach;
                    endif; ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">コメント入力欄</label>
                            <textarea name="comment" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="この相手校に関わる練習試合日程・戦略・残したい連絡など"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">確認</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <!-- Bootstrap core JavaScript
      ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>