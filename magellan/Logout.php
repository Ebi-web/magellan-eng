<?php
session_start();
try {
    if (isset($_SESSION['username'])) {
        unset($_SESSION['username']);
    }
    header("Location:./Login.php");
} catch (Throwable $th) {
    echo $th->getMessage();
    exit('ERROR!お手数ですが，ネットワーク接続をご確認の上，再度お試しください。再びこのエラーメッセージが表示された場合，お手数ですがメインページのお問い合わせからお知らせください。');
}
