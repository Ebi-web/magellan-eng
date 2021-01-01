<?php
session_start();
require_once("./functions.php");
// 大会データを削除する機構
try {
    $sql = 'delete from t_abst_local WHERE id=?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_SESSION['abst_id']));
    header("Location:./newschool_matches.php");
} catch (PDOException $e) {
    echo $e->getMessage();
    exit('削除に失敗しました。ネットワークをご確認の上，再度試みてください。再びこのエラーメッセージが表示された場合，お手数ですがメインページのお問い合わせからお知らせください。');
}
