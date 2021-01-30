       <?php
        require __DIR__ . '/vendor/autoload.php';
        require_once(__DIR__ . "/env.php");
        $dotenv = new Dotenv();
        $host = $dotenv->getenv("MYSQL_HOST");
        $dbname = $dotenv->getenv("MYSQL_DATABASE");
        $username = $dotenv->getenv("MYSQL_USER");
        $passwd = $dotenv->getenv("MYSQL_PASSWORD");
        // 主要な変数群
        //    PDOクラスのインスタンスを生成する(エラーモードも同時にセット)

        $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8";
        $user = $username;
        $password = $passwd;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );
        $pdo = new PDO($dsn, $user, $password, $options);


        // 複数回使用する各種関数をまとめた
        // 以下は関数群


        //必要なSESSIONデータがあるかどうか検査する関数
        function checksession($flag)
        {
            if ($flag == "global") : if (!isset($_SESSION["username"]) || !isset($_SESSION["userid"])) : header("Location:./Login.php");
                endif;
            elseif ($flag == "tournaments") :
                $arr = array(
                    $_SESSION['abst_id'],
                    $_SESSION['tName'],
                    $_SESSION['date'],
                    $_SESSION['flowstyle'],
                    $_SESSION['topic']
                );
                if (count($arr) != 5) : header("Location:./magellan_tournaments.php");
                endif;;
            elseif ($flag == "schools") :    if (!isset($_SESSION["name"]) || !isset($_SESSION["id"])) : header("Location:./schools.php");
                endif;
            elseif ($flag == "matches") : $arr = array($_SESSION["m_id"], $_SESSION["prop"], $_SESSION["opp"], $_SESSION["winner"], $_SESSION["judges"]);
                if (count($arr) != 5) : header("Location:../magellan_tournaments.php");
                endif;
            endif;
        }

        //HTTPヘッダインジェクションの原因となる%0d,%0aを禁止。リクエストボディ破壊の原因になるクォーテーションマークも禁止
        function httpHeaderInjection($subject)
        {
            $patterns = array("/.*\n.*/", '/.*".*/', "/.*'.*/");
            foreach ($patterns as $pattern) :
                if (preg_match($pattern, $subject) === 1) : throw new Exception("システムエラーの原因となるためクォーテーションマークと一部の特殊文字は登録できません");
                endif;
            endforeach;
        }

        // othersテーブルに未登録の学校名を登録するための関数
        function other($register)
        {
            global $pdo, $return;
            if (mb_strwidth($register) > 30) : throw new Exception("校名は半角30字以内で入力してください。");
            endif;
            httpHeaderInjection($register);
            $sql = 'insert into others values(null,?,?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($_SESSION['userid'], $register));
            $return = $pdo->lastInsertId();
            return $return;
        }

        // othersテーブルから特定ユーザーが登録した他校名を全て取って来る関数
        function fetch_others()
        {
            global $pdo, $other;
            $sql = "select * from others WHERE holder_id=?";
            $stmt1 = $pdo->prepare($sql);
            $stmt1->execute(array($_SESSION['userid']));
            $other = $stmt1->fetchAll();
            return $other;
        }

        // 特定の単一の他校名を表示する関数
        function thirdparty($thirdid)
        {
            global $pdo;
            $sql = 'select * from others WHERE id=?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($thirdid));
            $outputSchool = $stmt->fetchAll();
            echo h($outputSchool[0]['school_name']);
        }

        // m_ab_localテーブルに試合登録する関数
        function insert_match($flag)
        {
            $prop = null;
            $opp = null;
            $winner = null;
            validate_judge(); //ジャッジをバリデーション
            validate_round(); //ラウンド数をバリデーション
            httpHeaderInjection($_POST['judges']);
            switch ($flag):
                case 0:
                    switch ($_POST["prop"]):
                        case 0:
                            $prop = 0;
                            $opp = $_SESSION["id"];
                            break;
                        case 1:
                            $prop = $_SESSION["id"];
                            $opp = 0;
                            break;
                        default:
                            throw new Exception("入力フォームの値が不正に操作されたため処理を停止しました。");
                    endswitch;
                    switch ($_POST["winner"]):
                        case 0:
                            $winner = $prop;
                            break;
                        case 1:
                            $winner = $opp;
                            break;
                        case 2:
                            break;
                        default:
                            throw new Exception("勝者に関するデータが不正に操作されたため処理を停止しました。");
                    endswitch;
                    break;
                case 1:
                    switch ($_POST['propchecker']):
                        case 0:
                            $prop = 0;
                            break;
                        case 1:
                            $prop = $_POST['prop'];
                            break;
                        case 2:
                            httpHeaderInjection($_POST['prop']);
                            $prop = other($_POST['prop']);
                            break;
                        default:
                            security();
                            break;
                    endswitch;
                    switch ($_POST['oppchecker']):
                        case 0:
                            $opp = 0;
                            break;
                        case 1:
                            $opp = $_POST['opp'];
                            break;
                        case 2:
                            httpHeaderInjection($_POST['opp']);
                            $opp = other($_POST['opp']);
                            break;
                        default:
                            security();
                            break;
                    endswitch;
                    switch ($_POST['winner']):
                        case 0:
                            $winner = $prop;
                            break;
                        case 1:
                            $winner = $opp;
                            break;
                        case 2:
                            break;
                        default:
                            security();
                            break;
                    endswitch;
                    break;
                case 2:
                    switch ($_POST['propchecker']):
                        case 0:
                            $prop = $_POST['prop'];
                            break;
                        case 1:
                            httpHeaderInjection($_POST['prop']);
                            $prop = other($_POST['prop']);
                            break;
                        default:
                            security();
                    endswitch;
                    switch ($_POST['oppchecker']):
                        case 0:
                            $opp = $_POST['opp'];
                            break;
                        case 1:
                            httpHeaderInjection($_POST['opp']);
                            $opp = other($_POST['opp']);
                            break;
                        default:
                            security();
                    endswitch;
                    switch ($_POST['winner']):
                        case 0:
                            $winner = $prop;
                            break;
                        case 1:
                            $winner = $opp;
                            break;
                        case 2:
                            break;
                        default:
                            security();
                    endswitch;
                    break;
            endswitch;
            global $pdo;
            $sql = 'insert into m_ab_local values(null,?,?,?,?,?,?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($_SESSION['abst_id'], $prop, $opp, $winner, $_POST['judges'], $_POST['round']));
        }
        // データ出力時に特殊文字をエスケープするための関数
        function h($target)
        {
            $safe = mb_convert_encoding(htmlspecialchars($target, ENT_QUOTES, "UTF-8", false), "UTF-8");
            return $safe;
        }

        // 例外をスローするための関数
        function security()
        {
            throw new Exception("不正な入力を検知しました");
        }
        //   ジャッジを入力するフォームでバイト数をバリデート
        function validate_judge()
        {
            if (isset($_POST['judges'])) :
                if (mb_strwidth($_POST['judges']) > 20) : throw new Exception("入力されたジャッジ名が長すぎます。スペースを含め，半角20字以内で入力してください。");
                endif;
            endif;
        }
        // 入力フォームのラウンド数のバリデーション
        function validate_round()
        {
            // ラウンド数が1~4かチェック
            // だめなら例外を投げる
            if (!preg_match("/^[0-4]{1}$/", $_POST['round'])) : throw new Exception("入力フォームの不正な書き換えを検知しました。お心当たりのない場合，申し訳ございませんがメインページのお問い合わせからお知らせください。");
            endif;
        }

        // 勝者の値をバリデート
        function validate_winner()
        {
            if (!preg_match("/^[0-2]{1}$/", $_POST["winner"])) : throw new Exception("入力フォームの不正な書き換えを検知しました。お心当たりのない場合，申し訳ございませんがメインページのお問い合わせからお知らせください。");
            endif;
        }

        // チェッカーをバリデート
        class validate_checker
        {
            private $setter;
            public function __construct(int $max)
            {
                $this->initialize_setter($max);
            }
            private function initialize_setter($in)
            {
                if ($in === 1 || $in === 2) : $this->setter = $in;
                else : throw new Exception("Magellanへの攻撃を検知したため，処理を停止しました。");
                endif;
            }
            public function validate()
            {
                $subject = array($_POST['propchecker'], $_POST['oppchecker']);
                if (!empty(preg_grep("/^[0-" . $this->setter . "]{1}$/", $subject, PREG_GREP_INVERT))) : throw new Exception("入力フォームの不正な書き換えを検知しました。お心当たりのない場合，申し訳ございませんがメインページのお問い合わせからお知らせください。");
                endif;
            }
        }
        // 入力された校名をバリデート
        function validate_schoolname()
        {
            global $prop, $opp;
            $subject = array($prop, $opp);
            foreach ($subject as $subjects) :
                if (is_numeric($subjects)) :
                    if (!preg_match("/^[0-9]+$/", $subjects)) : throw new Exception("プルダウンメニューの値が不正に操作されています。");
                    endif;
                elseif (mb_strwidth($subjects) > 30) : throw new Exception("入力された校名が長すぎます。全角15文字以内で入力してください。");
                endif;
            endforeach;
        }

        // フローシートへ代入するスピーチ群をfetchする関数
        function fetch_speech()
        {
            global $pdo, $match;
            $sql = 'select * from flowsheet_local WHERE m_id=?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($_SESSION['m_id']));
            $match = $stmt->fetchAll();
            return $match;
        }
        //フローシートの様式に合わせて変数を最適化する関数
        function flowstyle()
        {
            global $c, $role, $aff, $neg;
            switch ($_SESSION['flowstyle']):
                case 1:
                    $c = 13;
                    global $aca_qa_input;
                    $role = $aca_qa_input;
                    $aff = "Aff.";
                    $neg = "Neg.";
                    break;
                case 2:
                    $c = 7;
                    global $parl_nowhip;
                    $role = $parl_nowhip;
                    $aff = "Gov.";
                    $neg = "Opp.";
                    break;
                case 3:
                    $c = 9;
                    global $hpdu_whip;
                    $role = $hpdu_whip;
                    $aff = "Gov.";
                    $neg = "Opp.";
                    break;
                case 4:
                    $c = 9;
                    global $jwsdc;
                    $role = $jwsdc;
                    $aff = "Prop.";
                    $neg = "Opp.";
                    break;
                default:
                    throw new Exception("フローシートの様式を確認できません。お手数ですが，大会を登録しなおしてください。");
            endswitch;
            return $c;
            return $role;
            return $aff;
            return $neg;
        }

        // フローを修正する関数
        function update_flow()
        {
            global $pdo;
            if (isset($_POST["chars"])) :
                $c = count($_POST["chars"]);
                $fileName = validate_chars_audio($c); //文字情報とaudioをバリデーション・audioはaudioディレクトリへ移動
                // DBで文字情報を修正する　
                $sql = 'update flowsheet_local set char_info=? WHERE m_id=? AND no=?';
                $stmt = $pdo->prepare($sql);
                $i = 1;
                foreach ($_POST['chars'] as $chars) :
                    if (empty($chars)) : $i++;
                        continue;
                    else :
                        $stmt->execute(array($chars, $_SESSION['m_id'], $i));
                        $i++;
                    endif;
                endforeach;
                $stmt->closeCursor();
                // DBで音声情報を修正する
                $sql = 'update flowsheet_local set audio=? WHERE m_id=? AND no=?';
                $stmt = $pdo->prepare($sql);
                $i = 1;
                foreach ($fileName as $audio) :
                    if (empty($audio)) : $i++;
                        continue;
                    else :
                        $stmt->execute(array($audio, $_SESSION['m_id'], $i));
                        $i++;
                    endif;
                endforeach;
                $stmt->closeCursor();
                header("Location:./flowsheet.php");
            endif;
        }
        // フローを新規登録する関数
        function insert_flow()
        {
            if (isset($_POST['chars'])) :
                global $pdo, $c;
                // 文字情報とaudioに対してバリデーション・audioはaudioディレクトリへ移動
                $fileName = validate_chars_audio($c);
                // DBを更新するSQL
                $match = fetch_speech(); //$match(登録されているフロー情報)を取得する
                if (empty($match)) : $j = 1; //登録する最初のnoを定義する
                else : $j = array_pop($match)["no"] + 1;
                endif;
                $sql = "insert into flowsheet_local values(null,?,?,?,?)";
                $stmt = $pdo->prepare($sql);
                foreach ($_POST["chars"] as $chars) :
                    $stmt->execute(array($_SESSION["m_id"], $j, $chars, null));
                    $j++;
                endforeach;
                $stmt->closeCursor();
                $j = $j - $c; //$jを登録すべき最初のnoに戻す
                $sql = 'update flowsheet_local set audio=? WHERE m_id=? AND no=?';
                $stmt = $pdo->prepare($sql);
                foreach ($fileName as $audio) :
                    if (empty($audio)) : $j++;
                        continue;
                    else :
                        $stmt->execute(array($audio, $_SESSION['m_id'], $j));
                        $j++;
                    endif;
                endforeach;
                $stmt->closeCursor();

                header('Location:./flowsheet.php');
            endif;
        }
        //文字情報とaudioをバリデーション・audioはaudioディレクトリへ移動する関数
        function validate_chars_audio($c)
        {
            // 文字情報への入力値へのバリデーション
            // 文字情報の字数が長すぎないかチェック
            foreach ($_POST["chars"] as $chars) :
                if (mb_strwidth($chars) > 1000) : throw new Exception("入力されたスピーチのいずれかが長すぎます。スペース含め，半角1000字以内に収めてください。");
                endif;
            endforeach;
            // 文字情報へのバリデーション終わり
            // 音声ファイルの入る配列を定義。変数$cは$_POST["chars"]の配列長。
            $fileName = array_fill(0, $c, null);
            // アップロードされたファイル件数を処理
            for ($j = 0; $j <= $c; $j++) :

                // アップロードされたファイルか検査
                if (is_uploaded_file($_FILES["audio"]["tmp_name"][$j])) :
                    // audioへのバリデーション開始
                    if (!is_int($_FILES["audio"]["error"][$j])) :
                        throw  new RuntimeException("送信されたaudioのパラメータが不正です。");
                    endif;
                    // $_FILES['audio']['error'] の値を確認
                    switch ($_FILES['audio']['error'][$j]):
                        case UPLOAD_ERR_OK: // OK
                            break;
                        case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                            continue 2;
                        default:
                            throw new RuntimeException('その他のエラーが発生しました');
                    endswitch;
                    // $_FILES['audio']['type']の値はブラウザ側で偽装可能なので
                    // MIMEタイプに対応する拡張子を自前で取得する
                    if (!$ext = array_search(
                        mime_content_type($_FILES['audio']['tmp_name'][$j]),
                        array(
                            "mp3" => "audio/mpeg"
                        ),
                        true
                    )) :
                        throw new RuntimeException('ファイル形式が不正です');
                    endif;
                    // audioへのバリデーション終了
                    // 乱数でパス名を生成
                    $fileName2 = md5(uniqid(rand()));
                    $fileName2 .= '.' . $ext;
                    $fileName[$j] = $fileName2;
                    // ファイルを移動
                    move_uploaded_file($_FILES["audio"]["tmp_name"][$j], "../assets/audio/" . $fileName[$j]);
                    // ファイルのパーミッションを確実に0644に設定する
                    chmod("../assets/audio/" . $fileName[$j], 0644);
                else :
                    continue;
                endif;
            endfor;
            return $fileName;
        }

        function modify_minor()
        {
            if (isset($_POST["winner"]) && isset($_POST["resolved"]) && isset($_POST["judges"])) :
                global $pdo;
                // ジャッジとトピックの字数が長すぎないかチェック
                if (mb_strwidth($_POST["judges"]) > 20 || mb_strwidth($_POST["resolved"]) > 150) : throw new Exception("それぞれ，ジャッジは半角20字，議題は半角150字以内で入力してください。(スペース含む)");
                endif;
                // 勝者の値がnullまたは0以上の整数であるかどうかチェック
                if (!is_null($_POST["winner"]) && !preg_match("/^[0-9][1-9]*$/", $_POST["winner"])) :
                    throw new Exception("勝利サイドに関する入力フォームが不正に操作されたため，処理を停止しました。");
                endif;
                // ジャッジとtopicに禁止表現が含まれていないかチェック
                httpHeaderInjection($_POST['judges']);
                httpHeaderInjection($_POST['topic']);
                $sql = 'update m_ab_local set winner=? WHERE id=?;update m_ab_local set judges=? WHERE id=?;update t_abst_local set topic=? WHERE id=?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array($_POST['winner'], $_SESSION['m_id'], $_POST['judges'], $_SESSION['m_id'], $_POST['resolved'], $_SESSION['abst_id']));
                $stmt->closeCursor();
                $arr = array($_POST["winner"], $_POST["judges"], $_POST["resolved"]);
                list($_SESSION["winner"], $_SESSION["judges"], $_SESSION["resolved"]) = $arr;
                header("Location:./flowsheet.php");
            endif;
        }

        // フローを削除する関数。引数$noは何枚目かを表す
        function delete_flow($no)
        {
            global $pdo, $c;
            $first = $no * $c - ($c - 1);
            $sql = "delete from flowsheet_local WHERE m_id=? AND no=?";
            $stmt = $pdo->prepare($sql);
            for ($i = $first; $i <= $first + $c - 1; $i++) :
                $stmt->execute(array($_SESSION["m_id"], $i));
            endfor;
            header("Location:./flowsheet.php");
        }

        function photo()
        {
            if (isset($_FILES["photo"])) :
                global $pdo;
                // 画像データのバリデーション

                for ($i = 0; $i <= 2; $i++) :
                    // 複数ファイルである・$_FILES Corruption 攻撃を受けた
                    // どれかに該当していれば不正なパラメータとして処理する
                    if (!is_int($_FILES['photo']['error'][$i])) {
                        throw new RuntimeException('パラメータが不正です');
                    }

                    // $_FILES['photo']['error'] の値を確認
                    switch ($_FILES['photo']['error'][$i]) {
                        case UPLOAD_ERR_OK: // OK
                            break;
                        case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                            continue 2;
                        default:
                            throw new RuntimeException('その他のエラーが発生しました');
                    }
                    // $_FILES['photo']['type']の値はブラウザ側で偽装可能なので
                    // MIMEタイプに対応する拡張子を自前で取得する
                    if (!$ext = array_search(
                        mime_content_type($_FILES['photo']['tmp_name'][$i]),
                        array(
                            'jpg' => 'image/jpeg',
                            'png' => 'image/png',
                        ),
                        true
                    )) :
                        throw new RuntimeException('ファイル形式が不正です');
                    endif;

                    // ファイルデータからSHA256ハッシュを取ってファイル名を決定し，保存する
                    if (!move_uploaded_file(
                        $_FILES['photo']['tmp_name'][$i],
                        $path = sprintf(
                            '../assets/img/%s.%s',
                            $hash = hash_file("sha256", $_FILES['photo']['tmp_name'][$i], false),
                            $ext
                        )
                    )) :
                        throw new RuntimeException('ファイル保存時にエラーが発生しました');
                    endif;

                    // ファイルのパーミッションを確実に0644に設定する
                    chmod($path, 0644);

                    // DBへ格納
                    $sql = "insert into flowsheet_photo values(null,?,?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array($_SESSION["m_id"], $hash . "." . $ext));
                endfor;
                header("Location:./flowsheet.php");
            endif;
        }

        // 画像をDBとimgディレクトリから消す関数
        function delete_photo()
        {
            if (!empty($_POST["inputphoto"])) :
                if (!is_array($_POST["inputphoto"])) : throw new RuntimeException("入力フォームの不正な改竄を検知したため，処理を停止しました。");
                endif;
                global $pdo;
                $sql = "select * from flowsheet_photo WHERE id=?";
                $stmt = $pdo->prepare($sql);
                foreach ($_POST["inputphoto"] as $photoid) :
                    $stmt->execute(array($photoid));
                    $path = $stmt->fetchAll();
                    unlink("../assets/img/" . $path[0]["path"]);
                endforeach;
                $sql = "delete from flowsheet_photo WHERE id=?";
                $stmt = $pdo->prepare($sql);
                foreach ($_POST["inputphoto"] as $photoid) :
                    $stmt->execute(array($photoid));
                endforeach;
                header("Location:./flowsheet.php");
            endif;
        }
        // 選択された試合に登録された画像ファイルをfetchする関数
        function fetch_photo()
        {
            global $pdo, $photo;
            $sql = "select * from flowsheet_photo WHERE m_id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($_SESSION["m_id"]));
            return $photo = $stmt->fetchAll();
        }

        // 特定ユーザーが登録している大会をfetchする関数
        function fetch_tour()
        {
            global $pdo, $tournament;
            $sql = "select * from t_abst_local WHERE holder_id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($_SESSION['userid']));
            $tournament = $stmt->fetchAll();
            return $tournament;
        }
        // 選択された大会に属する試合をラウンド数ごとにソートする関数
        // 引数は3次元配列
        function sort_match($match)
        {
            global $matches1, $matches2, $matches3, $matches4;
            // 各試合のデータをラウンドごとに配列に格納
            $matches1 = array();
            $matches2 = array();
            $matches3 = array();
            $matches4 = array();
            foreach ($match as $matches) :
                if ($matches['round_no'] == 1) : array_push($matches1, $matches);
                elseif ($matches['round_no'] == 2) : array_push($matches2, $matches);
                elseif ($matches['round_no'] == 3) : array_push($matches3, $matches);
                elseif ($matches['round_no'] == 4) : array_push($matches4, $matches);
                endif;
            endforeach;
            return $matches1;
            return $matches2;
            return $matches3;
            return $matches4;
        }

        // 以下は定数群
        // 各フローシートにおける役名の配列群
        $aca_qa_input = [
            '0.Memo',
            '1.Affirmative Constructive Speech',
            '2.QA N→A',
            '3.Negative Constructive Speech',
            '4.QA A→N',
            '5.Negative Attack Speech',
            '6.QA A→N',
            '7.Affirmative Attack Speech',
            '8.QA N→A',
            '9.Affirmative Defense Speech',
            '10.Negative Defense Speech',
            '11.Affirmative Summary Speech',
            '12.Negative Summary Speech'
        ];
        $parl_nowhip = ['POI&Memo', 'PM', 'LO', 'MG', 'MO', 'RLO', 'RPM'];
        $hpdu_whip = ['POI&Memo', 'PM', 'LO', 'MG', 'MO', 'Gov. Whip', 'Opp. Whip', 'RLO', 'RPM'];
        $jwsdc = ['POI&Memo', '1st prop.', '1st opp.', '2nd prop.', '2nd opp.', '3rd prop.', '3rd opp.', '4th opp.', '4th prop.'];
