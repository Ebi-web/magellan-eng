
<?php
session_start();
require_once("./functions.php");
try {
    if (isset($_POST['taikaimei'])) :
        // フロー様式と日付に対してバリデーション
        if (preg_match("/^[1-4]{1}$/", $_POST['flowstyle']) == false || date_create_from_format("Y-m-d", $_POST['nittei']) === false) :
            exit("フローシート様式選択または日付入力欄が不正です");
        endif;
        // 入力された議題・大会名に対して文字数制限バリデーション
        if (mb_strwidth($_POST['taikaimei']) > 30 || mb_strwidth($_POST['gidai']) > 150) : exit("入力された議題または大会名が長すぎます。文字数にスペースを含めて，議題は半角150字以内，大会名は全角15文字以内で入力してください。");
        endif;

        $sql = 'insert into t_abst_local values(null,?,?,?,?,?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($_POST["taikaimei"], $_POST["nittei"], $_POST["flowstyle"], $_POST["gidai"], $_SESSION["userid"]));
        header("Location:./magellan_tournaments.php");

    endif;
} catch (PDOException $e) {
    echo $e->getMessage();
    exit("ERROR!ネットワーク接続をご確認の上，再度お試しください。再びこのエラーが表示された場合には，お手数ですがメインページのお問い合わせからお知らせください。");
}

?>