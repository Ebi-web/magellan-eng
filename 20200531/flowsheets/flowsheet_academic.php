<!doctype html>
<html lang="ja">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="../assets/css/mainpage.css" rel="stylesheet">
    <link href="../assets/css/academic.css" rel="stylesheet">
</head>

<body>
    <main>
        <table class='table'>
            <tr>
                <td colspan="2" class="title" nowrap><span>ACADEMIC STYLE</span></td>
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
                <td>Resolved:</td>
                <td colspan="8"><?php if (isset($_SESSION['topic'])) : echo h($_SESSION['topic']);
                                else : echo 'Unregistered';
                                endif; ?></td>
                <td>Win.</td>
                <td></td>
                <td <?php if ($_SESSION['winner'] === $_SESSION['prop']) : echo 'class="winner"';
                    endif; ?>>Aff.</td>
                <td>/</td>
                <td <?php if ($_SESSION['winner'] === $_SESSION['opp']) : echo 'class="winner"';
                    endif; ?>>Neg.</td>
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
                <td>Date: <?= h($_SESSION['date']) ?></td>
                <td colspan="4"></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td nowrap>Aff.<?php if ($_SESSION['prop'] == 0) : echo h($_SESSION['username']);
                                else : thirdparty($_SESSION["prop"]);
                                endif; ?></td>
                <td colspan="3"></td>
                <td>vs.</td>
                <td nowrap>Neg.<?php if ($_SESSION['opp'] == 0) : echo h($_SESSION['username']);
                                else : thirdparty($_SESSION["opp"]);
                                endif; ?></td>
                <td colspan="3"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Judges:</td>
                <td nowrap><?php if (isset($_SESSION['judges'])) : echo h($_SESSION['judges']);
                            else : echo 'Unregistered';
                            endif; ?></td>
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
                <td colspan="4">Affirmative Constructive Speech</td>
                <td colspan="3">QA N→A</td>
                <td colspan="4">Negative Attack Speech</td>
                <td colspan="3">QA A→N</td>
                <td colspan="4">Affirmative Defense Speech</td>
                <td colspan="4">Affirmative Summary Speech</td>
            </tr>
            <tr>
                <td colspan="4" rowspan="7"><?= h($match[$j + 1]['char_info']) ?> <?php if (isset($match[$j + 1]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 1]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="3" rowspan="7"><?= h($match[$j + 2]['char_info']) ?> <?php if (isset($match[$j + 2]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 2]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="4" rowspan="7"><?= h($match[$j + 5]['char_info']) ?> <?php if (isset($match[$j + 5]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 5]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="3" rowspan="7"><?= h($match[$j + 6]['char_info']) ?> <?php if (isset($match[$j + 6]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 6]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="4" rowspan="7"><?= h($match[$j + 9]['char_info']) ?> <?php if (isset($match[$j + 9]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 9]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="4" rowspan="7"><?= h($match[$j + 11]['char_info']) ?> <?php if (isset($match[$j + 11]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 11]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
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
                <td colspan="4">Negative Constructive Speech</td>
                <td colspan="3">QA A→N</td>
                <td colspan="4">Affirmative Attack Speech</td>
                <td colspan="3">QA N→A</td>
                <td colspan="4">Negative Defense Speech</td>
                <td colspan="4">Negative Summary Speech</td>
            </tr>
            <tr>
                <td colspan="4" rowspan="7"><?= h($match[$j + 3]['char_info']) ?> <?php if (isset($match[$j + 3]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 3]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="3" rowspan="7"><?= h($match[$j + 4]['char_info']) ?> <?php if (isset($match[$j + 4]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 4]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="4" rowspan="7"><?= h($match[$j + 7]['char_info']) ?> <?php if (isset($match[$j + 7]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 7]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="3" rowspan="7"><?= h($match[$j + 8]['char_info']) ?> <?php if (isset($match[$j + 8]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 8]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="4" rowspan="7"><?= h($match[$j + 10]['char_info']) ?> <?php if (isset($match[$j + 10]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 10]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
                <td colspan="4" rowspan="7"><?= h($match[$j + 12]['char_info']) ?> <?php if (isset($match[$j + 12]['audio'])) : ?><a href="../assets/audio/<?= $match[$j + 12]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
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
                <td colspan="22">Memo</td>
            </tr>
            <tr>
                <td colspan="22" rowspan="7"><?= h($match[$j]['char_info']) ?> <?php if (isset($match[$j]['audio'])) : ?><a href="../assets/audio/<?= $match[$j]['audio'] ?>"><img src='../assets/img/music.jpeg'></a><?php endif; ?></td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
        </table>

    </main>

</body>

</html>