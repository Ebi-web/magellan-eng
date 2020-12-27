<?php
session_start();
require_once("./functions.php");
checksession("global");
try {
  fetch_tour();
} catch (PDOException $e) {
  echo $e->getMessage();
  exit('ERROR!お手数ですが，メインページのお問い合わせからお知らせください。');
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
  <link href="./assets/css/tournaments.css" rel="stylesheet">
  <link href="./assets/css/mainpage.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link href="./assets/css/font.css" rel="stylesheet">
  <link rel="apple-touch-icon" type="image/png" href="assets/img/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="assets/img/icon-192x192.png">
  <title>大会別一覧</title>
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
        <!--  <a class="dropdown-item" href="#">Settings</a> -->
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
                <span></span>
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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">大会別一覧</h1>
          <!-- <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
              <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                New Flowsheet
              </button>
              <button type="button" class="btn btn-outline-primary" onclick="location.href='./newschool_addition_input.php'">新規相手校追加</button>
            </div>
          </div> -->
          <button class="btn btn-outline-primary" onclick="location.href='./nsc_matches_input.php'">新規大会追加</button>
        </div>
        <div align="center">
          <h2><?= h($_SESSION['username']) ?>の大会別一覧</h2>
          <h3>大会別のフロー登録・管理はここから行えます</h3>
        </div>

        <div class="container">
          <div class="row">
            <?php foreach ($tournament as $tournaments) : ?>
              <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                  <img class="card-img-top" src="./assets/img/debate.jpg" alt="Card image cap">
                  <div class="card-body">
                    <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
                    <p class="card-text"><?= h($tournaments['t_name']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                      <!-- <div class="btn-group"> -->
                      <!-- <button type="button" class="btn btn-sm btn-outline-secondary">View</button> -->
                      <!-- <button type="button" class="btn btn-sm btn-outline-secondary">見る</button> -->
                      <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> -->
                      <input type='button' class="btn btn-sm btn-outline-secondary" onclick="location.href='./tournaments_match.php?id=<?= $tournaments['id'] ?>&name=<?= $tournaments['t_name'] ?>&date=<?= $tournaments['t_date'] ?>&flow=<?= $tournaments['flowstyle'] ?>&topic=<?= $tournaments['topic'] ?>'" value="編集">
                      <!-- </div> -->
                      <!-- <small class="text-muted">9 mins</small> -->
                      <!-- <small class="text-muted">9分</small> -->
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
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

      </main>
    </div>
  </div>
</body>

</html>