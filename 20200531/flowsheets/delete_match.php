<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=samurai;charset=utf8', 'Toshiaki', 'ume1027');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 試合データを削除する機構
    $sql = 'delete from m_ab_local WHERE id=?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_SESSION['m_id']));
    header("Location:../local_matches.php");
} catch (PDOException $e) {
    echo $e->getMessage();
    echo '削除に失敗しました。再度試みてください。';
}
