<?php
if(isset($_POST['email'])&&isset($_POST['password'])){
$email=$_POST['email'];
echo $email;
 $password=$_POST['password'];
echo $password;
$dsn = 'mysql:dbname=samurai;host=localhost';
$user = 'root';
$pass = '';

try{
  echo "一つ目";
    $dbh = new PDO($dsn, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'select name from users WHERE mailaddress=? AND password=?';
   // ?←何かを入れることができる。
   // 特定のユーザーを指定
   $stmt=$dbh->prepare($sql);
   // dbhのprepareという関数を指定　-> = of
   // $stmtに格納される
   // prepareは代入するもの
   $stmt->execute(array($email,$password));
   $stmt->debugDumpParams();
   // executeには配列で渡さなければいけない
   // arrayの後に変数を指定
   // 実行
   echo "2つ目";

    $name=$stmt->fetchColumn();
    echo "3つ目";
    echo $name;
   // fetchColumn();は特定のcolumnを取得
   if($name != ""){
     session_start();
     $_SESSION['username']=$name;
     header('Location: https://localhost/20200531/magellan_mainpage.php');
   }

}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
}
?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="login.css" rel="stylesheet">

    <title>Hello, world!</title>
  </head>
  <body  class="text-center" >
    <a id="skippy" class="sr-only sr-only-focusable" href="#content">
  <div class="container">
    <span class="skiplink-text">Skip to main content</span>
  </div>
</a>

    <form class="form-signin" action="Login.php" method="post">
  <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus name="email">
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  <p class="mt-5 mb-3 text-muted">&copy; Toshiaki Ebisawa 2020</p>
</form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
