<?php
session_start();
require_once("./functions.php");
//ログイン処理
try {
  if (isset($_POST['id']) && isset($_POST['password'])) :
    $id = $_POST['id'];
    $password = $_POST['password'];
    if (!preg_match("/^[a-zA-Z0-9]{5,30}$/", $id) || !preg_match("/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/", $password)) : throw new Exception("IDまたはパスワードが不正です。");
    endif;
    $sql = "select * from users where checker=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($id));
    $uda = $stmt->fetchAll();
    if (empty($uda) || !$password = password_verify($password, $uda[0]["password"])) :
      throw new Exception("データベースに入力されたレコードがありません");
    endif;
    $userdata = $uda[0];
    $name = $userdata['name'];
    $userid = $userdata['id'];
    //fetchColumn();は特定のcolumnを取得
    if ($name != "") :
      $_SESSION['userid'] = $userid;
      $_SESSION['username'] = h($name);
      header('Location:./magellan_mainpage.php');
    endif;
  endif;
} catch (Exception | PDOException $e) {
  print('Error:' . $e->getMessage());
  exit('ログインに失敗しました。');
}
//新規ユーザー登録
try {
  if (isset($_POST["register_id"]) && isset($_POST["register_email"])) :
    if (!preg_match("/^[a-zA-Z0-9]{5,30}$/", $_POST["register_id"]) || mb_strwidth($_POST["name"]) > 20) : throw new Exception("IDは半角5~30文字，ユーザー名は半角20文字以内で入力してください");
    endif;
    if (!filter_var($_POST["register_email"], FILTER_VALIDATE_EMAIL)) : throw new Exception("登録されたメールアドレスの形式が不正です");
    endif;
    if (!preg_match("/^(?=.*\d)(?=.*[a-zA-Z]).{8,}$/", $_POST["register_password"])) : throw new Exception("パスワードは半角英数字(大文字可),半角記号($,@など)から8桁以上で登録してください");
    endif;
    $sql = "SELECT * from users where checker=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_POST["register_id"]));
    $multipule = $stmt->fetchAll();
    if (!empty($multipule)) : throw new Exception("IDが既に使用されています。");
    endif;
    $password = password_hash($_POST["register_password"], PASSWORD_DEFAULT);
    $sql1 = "INSERT INTO users VALUES(null,?,?,?,?)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute(array($_POST["register_id"], $_POST["name"], $_POST["register_email"], $password));
    $new_userid = $pdo->lastInsertId();
    $_SESSION['userid'] = $new_userid;
    $_SESSION['username'] = h($_POST["name"]);
    header("Location:./magellan_mainpage.php");
  endif;
} catch (Exception | PDOException $e) {
  echo $e->getMessage();
  exit("会員登録に失敗しました。");
}
//パスワード忘れた人用の処理
// try {
//   if (isset($_POST["forget"])) :
//     if (!filter_var($email = $_POST["forget"], FILTER_VALIDATE_EMAIL)) : throw new Exception("メールアドレスの形式が不正です");
//     endif;
//     $sql = "select * from users where mailaddress=?";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute(array($email));
//     $is_exist = $stmt->fetchAll();
//     $to = $is_exist[0]["mailaddress"];
//     $subject = "【Magellan】ID/パスワード変更のお手続き";
//     $url = "";
//     $message = "こちらは英語ディベーター支援アプリMagellanです。ID・パスワードの変更手続きはこちらのリンクからお願いします。" . $url . "なお，このメールが身に覚えのない方はそのまま破棄して頂くか，開発者のTwitter(@eng_toshiaki)までご一報ください。";
//     mb_language("Japanese");
//     mb_internal_encoding("UTF-8");
//     mb_send_mail($to, $subject, $message);
//     exit("このメールアドレスがMagellanのデータベース内にある場合は、メールでリンクをお送りします");

//   endif;
// } catch (\Throwable $e) {
//   $e->getMessage();
//   echo "もう一度お試し頂くか，開発者のTwitter(@eng_toshiaki)までご連絡ください";
// }

?>
<!doctype html>
<html lang="ja">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="./assets/css/login.css" rel="stylesheet">
  <link href="./assets/css/erase.css" rel="stylesheet">
  <link rel="apple-touch-icon" type="image/png" href="assets/img/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="assets/img/icon-192x192.png">
  <title>Magellan</title>
</head>

<body class="text-center">
  <a id="skippy" class="sr-only sr-only-focusable" href="#content">
    <div class="container">
      <span class="skiplink-text">Skip to main content</span>
    </div>
  </a>
  <!-- ここからログインフォーム -->
  <form class="form-signin" action="Login.php" method="post" id="login">
    <img class="mb-4" src="./assets/img/ペンギン.png" alt="ペンギン" width="30%" height="40%">
    <h1 class="h3 mb-3 font-weight-normal">Please Log in<br>to Magellan</h1>
    <label for="inputEmail" class="sr-only">ID</label>
    <input type="text" id="inputEmail" class="form-control" placeholder="ID" minlength="5" maxlength="30" required autofocus name="id">
    <label for="inputPassword0" class="sr-only">Password</label>
    <input type="password" id="inputPassword0" class="form-control" placeholder="Password" minlength="8" pattern="^(?=.*\d)(?=.*[a-zA-Z]).{8,}$" title="The password requires both alphabets and at least one digit" required name="password">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
    <button class="btn btn-lg btn-secondary btn-block" onclick="formswitch(0)">User Registration</button>
    <button class="btn btn-lg btn-success btn-block" onclick="formswitch(2)">Forget ID or Password?</button>
    <p class="mt-5 mb-3 text-muted">&copy; Toshiaki Ebisawa 2020</p>
  </form>


  <!-- ここまでログインフォーム -->
  <!-- ここから新規ユーザー登録 -->
  <form id="registration" class="form-signin erase" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Welcome to the Magellan!<br>Let's complete the user registration.</h1>
    <label for="inputEmail" class="sr-only">ID</label>
    <input type="text" id="inputEmail" class="form-control" placeholder="ID" minlength="5" maxlength="30" required autofocus name="register_id">
    <label for="inputEmail" class="sr-only">UserName</label>
    <input type="text" id="inputEmail" class="form-control" placeholder="your name in the Magellan" maxlength="20" required name="name">
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required name="register_email">
    <label for="inputPassword1" class="sr-only">Password</label>
    <input type="password" id="inputPassword1" class="form-control" placeholder="Password" minlength="8" pattern="^(?=.*\d)(?=.*[a-zA-Z]).{8,}$" title="The password requires both alphabets and at least one digit" required name="register_password">
    <span id="result"></span>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Register!</button>
    <button class="btn btn-lg btn-secondary btn-block" onclick="formswitch(1)">Switch to Login</button>
    <p class="mt-5 mb-3 text-muted">&copy; Toshiaki Ebisawa 2020</p>
  </form>
  <!-- ここまで新規ユーザー登録 -->
  <!-- ここからPW忘れたユーザーの対応ページ -->
  <!-- パスワード再設定用のページのurlに対応するページがないため未公開(20201227現在) -->
  <!-- <form class="form-signin erase" method="post" id="forget">
    <img class="mb-4" src="./assets/img/ペンギン.png" alt="ペンギン" width="30%" height="40%">
    <h1 class="h3 mb-3 font-weight-normal">Reset your Password</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required name="forget" title="メールアドレスを入力してください">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Confirm</button>
    <button class="btn btn-lg btn-secondary btn-block" onclick="formswitch(1)">Switch to Login</button>
    <p class="mt-5 mb-3 text-muted">&copy; Toshiaki Ebisawa 2020</p>
  </form> -->
  <!-- ここまでPW忘れたユーザーの対応ページ -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="./assets/js/password_strength.js"></script>
  <script>
    "use strict";

    function formswitch(checker) {
      let login = document.getElementById("login");
      let registration = document.getElementById("registration");
      // let forget = document.getElementById("forget")
      if (checker === 0) {
        login.classList.add("erase");
        // forget.classList.add("erase");
        registration.classList.remove("erase");
      }
      if (checker === 1) {
        login.classList.remove("erase");
        // forget.classList.add("erase");
        registration.classList.add("erase");
      }
      // if (checker === 2) {
      //   login.classList.add("erase");
      //   forget.classList.remove("erase");
      //   registration.classList.add("erase");
      // }
    }
  </script>
</body>

</html>