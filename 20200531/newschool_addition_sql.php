<?php
session_start();
require_once("./functions.php");
try {
    other($_POST["school_name"]);
    header("Location:./schools.php");
} catch (Exception | PDOException $e) {
    echo $e->getMessage();
    exit("データ送信時にエラーが発生しました。ネットワーク接続をご確認の上，再度お試しください。再びこのエラーメッセージが表示された場合，お手数ですがメインページのお問い合わせからお知らせください。");
}
