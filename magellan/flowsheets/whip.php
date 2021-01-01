<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="../assets/css/academic.css" rel="stylesheet">
    <title>フローシート</title>
</head>

<body>
    <table class="table">
        <tr>
            <td colspan="3" class="title" nowrap><span>Parliamentary Style(Whipあり)</span></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Motion:</td>
            <td><?php if (isset($_SESSION['topic'])) : echo $_SESSION['topic'];
                else : echo 'Unregistered';
                endif; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Win</td>
            <td <?php if ($_SESSION['winner'] === $_SESSION['prop']) : echo 'class="winner"';
                endif; ?>>Gov.</td>
            <td>/</td>
            <td <?php if ($_SESSION['winner'] === $_SESSION['opp']) : echo 'class="winner"';
                endif; ?>>Opp.</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Date:</td>
            <td><?= $_SESSION['date'] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Gov.</td>
            <td nowrap><?php if ($_SESSION['prop'] == 0) : $_SESSION['username'];
                        else : thirdparty($_SESSION["prop"]);
                        endif; ?></td>
            <td>vs.</td>
            <td>Opp.</td>
            <td nowrap><?php if ($_SESSION['opp'] == 0) : h($_SESSION['username']);
                        else : thirdparty($_SESSION["opp"]);
                        endif; ?></td>
            <td></td>
            <td>Judges:</td>
            <td nowrap><?php if (isset($_SESSION['judges'])) : echo $_SESSION['judges'];
                        else : echo 'Unregistered';
                        endif; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3">Prime Minister</td>
            <td colspan="3">Member of the Government</td>
            <td colspan="3">the Government's Whip</td>
            <td colspan="3">the Opposition's Reply</td>
        </tr>
        <tr>
            <td colspan="3" rowspan="10"><?= h($match[$j + 1]['char_info']) ?> <?php if (isset($match[$j + 1]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 1]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
            <td colspan="3" rowspan="10"><?= h($match[$j + 3]['char_info']) ?> <?php if (isset($match[$j + 3]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 3]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
            <td colspan="3" rowspan="10"><?= h($match[$j + 5]['char_info']) ?> <?php if (isset($match[$j + 5]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 5]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
            <td colspan="3" rowspan="10"><?= h($match[$j + 7]['char_info']) ?> <?php if (isset($match[$j + 7]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 7]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
            <td colspan="3">Leader of the Opposition</td>
            <td colspan="3">Member of the Opposition</td>
            <td colspan="3">the Opposition's Whip</td>
            <td colspan="3">the Government's Reply</td>
        </tr>
        <tr>
            <td colspan="3" rowspan="11"><?= h($match[$j + 2]['char_info']) ?> <?php if (isset($match[$j + 2]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 2]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
            <td colspan="3" rowspan="11"><?= h($match[$j + 4]['char_info']) ?> <?php if (isset($match[$j + 4]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 4]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
            <td colspan="3" rowspan="11"><?= h($match[$j + 6]['char_info']) ?> <?php if (isset($match[$j + 6]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 6]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
            <td colspan="3" rowspan="11"><?= h($match[$j + 8]['char_info']) ?> <?php if (isset($match[$j + 8]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 8]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
            <td colspan="9">POI&amp;MEMO</td>
        </tr>
        <tr>
            <td colspan="9" rowspan="5"><?= h($match[$j]['char_info']) ?> <?php if (isset($match[$j]['audio'])) : ?><a href="../assets/audio/<?= $match[$j]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>
        <tr>
        </tr>

    </table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>