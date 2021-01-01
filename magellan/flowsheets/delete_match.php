<?php
session_start();
require_once("../functions.php");
try {

    // 試合データを削除する機構
    $sql = 'delete from m_ab_local WHERE id=?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_SESSION['m_id']));
    header("Location:../magellan_tournaments.php");
} catch (PDOException $e) {
    echo $e->getMessage();
    echo '削除に失敗しました。再度試みてください。';
}
