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
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="./assets/css/tournaments.css" rel="stylesheet">
    <link href="./assets/css/font.css" rel="stylesheet">
    <link rel="apple-touch-icon" type="image/png" href="assets/img/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="assets/img/icon-192x192.png">
    <title>Magellan</title>
    <style>
        .box28 {
            position: relative;
            margin: 2em 0;
            padding: 25px 10px 7px;
            border: solid 2px #FFC107;
        }

        .box28 .box-title {
            position: absolute;
            display: inline-block;
            top: -2px;
            left: -2px;
            padding: 0 9px;
            height: 25px;
            line-height: 25px;
            font-size: 17px;
            background: #FFC107;
            color: #ffffff;
            font-weight: bold;
        }

        .box28 p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Magellan</a>
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
                            <a class="nav-link" href="./magellan_mainage.php">
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
                    <h1 class="h2">新規相手校登録</h1>
                </div>
                <div class="container" class="row">
                    <form method="post">
                        <fieldset>
                            <p><label>相手校名<input name='school_name' maxlength="30" required></label></p>
                            <div class="frame frame-red">
                                <div class="box28">
                                    <span class="box-title">注意</span>
                                    <p>新規相手校を登録する前に、既に同じ名前の相手校が登録されていないか確認してください</p>
                                </div>
                                <p><button type="submit" class="btn btn-outline-primary" formaction="./newschool_addition_sql.php">登録</button></p>
                        </fieldset>
                    </form>
                </div>

            </main>


        </div>
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
    <script src="./assets/js/submission_optimizer.js"></script>

</body>

</html>