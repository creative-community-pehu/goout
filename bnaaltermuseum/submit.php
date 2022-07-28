<?php

mb_language("ja");
mb_internal_encoding("UTF-8");

// メッセージを保存するファイルのパス設定
define( 'FILENAME', 'draft.csv');

// 変数の初期化
$page_flag = 0;

if( !empty($_POST['btn_confirm']) ) {

	$page_flag = 1;
	session_start();
	$_SESSION['page'] = true;

} elseif( !empty($_POST['btn_submit']) ) {

	if( $file_handle = fopen( FILENAME, "a") ) {

		// 書き込むデータを作成
		$data = "'".$_POST['things']."','".$_POST['essay']."','".$_POST['map']."','".$_POST['date']."','".$_POST['time']."'\n\n";

		// 書き込み
		fwrite( $file_handle, $data);

		// ファイルを閉じる
		fclose( $file_handle);
	}

	session_start();
	if( !empty($_SESSION['page']) && $_SESSION['page'] === true ) {

	$page_flag = 2;

	// 変数とタイムゾーンを初期化
	$header = null;
	$auto_reply_subject = null;
	$auto_reply_text = null;
	$admin_reply_subject = null;
	$admin_reply_text = null;
	date_default_timezone_set('Asia/Tokyo');

	// ヘッダー情報を設定
	$header = "MIME-Version: 1.0\n";
	$header .= "From: creative-community.space <pehu@creative-community.space>\n";
	$header .= "Reply-To: creative-community.space <pehu@creative-community.space>\n";

	// 件名を設定
	$admin_reply_subject = 'Submit | things that i (we) heard';
  
	// 本文を設定
	$admin_reply_text .= "\n" . $_POST['things'] . "\n";
	$admin_reply_text .= "\n" . nl2br($_POST['essay']) . "\n";
	$admin_reply_text .= "\n" . $_POST['map'] . "\n";
	$admin_reply_text .= "" . $_POST['date'] .  " ";
	$admin_reply_text .= " ". $_POST['time'] . "\n\n\n";
	$admin_reply_text .= "https://creative-community.space/members/map/heard/";

	mb_send_mail( 'pehu@creative-community.space', $admin_reply_subject, $admin_reply_text, $header);

	} else {
		$page_flag = 0;
	}
}
?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="icon" href="logo.png">
        <link rel="stylesheet" href="form.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital@0;1&display=swap" rel="stylesheet">
        <title>Submit | things that i (we) heard</title>
        <style type="text/css">
            body {
                background: #CDCBCC;
                color: #fff;
                margin: 0;
            }
            
            #main u {
                background: #fff;
                color: #000;
                text-decoration: none;
            }
            
            #submit a {
                color: #fff;
                background: #CDCBCC !important;
            }
            
            #submit sup {
                padding:0 0.5rem;
                font-size:75%;
            }
            
            #submit a:hover {
                color: #fff;
                background: #000 !important;
            }
            
            .content a,
            #credit a {
                color: #fff;
            }
            
            .content a:hover,
            #credit a:hover {
                color: #000;
                background: #fff !important;
            }
            
            details summary {
                color: #000;
                background-color: #fff;
            }
            
            details summary:hover {
                background: #000;
                color: #fff;
            }
            
            details[open] summary:hover {
                background: #CDCBCC;
                color: #fff;
            }
            
            body,
            #credit,
            #main input[type="text"],
            #main input[type="name"],
            #main input[type="url"],
            #main input[type="email"],
            #main input[type="date"],
            #main input[type="time"],
            #main input[type="submit"],
            #main textarea {
                font-family: 'Libre Baskerville', "YuMincho", "Yu Mincho", "游明朝体", serif;
            }
        </style>
    </head>

    <body>
        <div id="credit">
          <a href="#" onClick="history.back(); return false;" target="_parent">私（わたしたち）が聞いた言葉</a>
          <a href="#" onClick="history.back(); return false;" target="_parent">↲</a>
        </div>

        <div id="submit">
            <?php if( $page_flag === 1 ): ?>
            <section id="main" class="form">
                <form method="post">
                    <div id="post">
                        <div>
                            <div>
                                <div class="submit">
                                    <h1><u>聞いた言葉</u><br/>
                                        <?php echo $_POST['things']; ?>
                                    </h1>
                                    <p><u>聞いた言葉・場所にまつわるエピソード</u></p>
                                    <p>
                                        <?php echo nl2br($_POST['essay']); ?>
                                    </p>
                                </div>
                                <hr/>
                                <h1>
                                    <u>言葉を聞いた場所</u>
                                    <a href="<?php echo $_POST['map']; ?>" target="_blank"><?php echo $_POST['map']; ?></a>
                                </h1>
                                <h1>
                                    <u>言葉を聞いた日時</u><br/>
                                    <?php echo $_POST['date']; ?>
                                    <?php echo $_POST['time']; ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <p id="next">
                        <input type="submit" name="btn_submit" value="投稿する">
                        <input type="submit" value="修正する" onClick="history.back(); return false;">
                    </p>

                    <input type="hidden" name="things" value="<?php echo $_POST['things']; ?>">
                    <input type="hidden" name="essay" value="<?php echo $_POST['essay']; ?>">
                    <input type="hidden" name="map" value="<?php echo $_POST['map']; ?>">
                    <input type="hidden" name="date" value="<?php echo $_POST['date']; ?>">
                    <input type="hidden" name="time" value="<?php echo $_POST['time']; ?>">


                </form>
            </section>
            <?php elseif( $page_flag === 2 ): ?>

            <div class="thankyou">
                <h1>ご投稿ありがとうございました。</h1>
                <p>近日中に、あなたが投稿した言葉をデジタル地図に追加します。</p>
                <h1><a href="/members/map/heard/">things that i (we) heard</a></h1>
            </div>

            <?php else: ?>

            <footer>
              <hr/>
                <p>会員限定</p>
                <h1><i>things that i (we) heard</i></h1>
                <p>あなたがあなたの周りで聞いた言葉を投稿する</p>
            </footer>
            <section id="main" class="form">
                <form action="" method="post">
                    <div class="submit">
                        <h1><u>あなたが聞いた言葉</u>
                            <sup>※ 必須</sup>
                            <br/>
                            <input type="text" name="things" value="<?php if( !empty($_POST['things']) ){ echo $_POST['things']; } ?>" placeholder="things that you heard" required>
                        </h1>
                        <h1><u>聞いた言葉・場所にまつわるエピソード</u></h1>
                        <p><textarea name="essay" rows="12.5" placeholder="About the things that you heard"><?php if( !empty($_POST['essay']) ){ echo $_POST['essay']; } ?></textarea></p>
                        <hr/>
                        <h1><u>言葉を聞いた場所</u>
                            <sup>※ 必須</sup>
                            <br/>
                            <input type="url" name="map" value="<?php if( !empty($_POST['map']) ){ echo $_POST['map']; } ?>" placeholder="ex https://goo.gl/maps/〇〇" required><br/></h1>
                            <p>
                              <a href="https://www.google.co.jp/maps/" target="_blank">Google Map</a>
                              で言葉を聞いた場所を探し、上記のフォームにリンクを添付してください</p>
                            <hr/>
                        <h1><u>言葉を聞いた日時</u>
                            <sup>※ 必須</sup>
                            <br/>
                            <input type="date" name="date" value="<?php if( !empty($_POST['date']) ){ echo $_POST['date']; } ?>" required>
                            <input type="time" name="time" value="<?php if( !empty($_POST['time']) ){ echo $_POST['time']; } ?>" required><br/></h1>
                        <p><input type="submit" name="btn_confirm" value="確認する"></p>
                    </div>
                </form>
            </section>
            <section id="content" style="padding-top: 0; border-bottom: 0; padding-bottom: 0;">
                <details>
                    <summary>
                        <h2>特集</h2>
                    </summary>
                    <div class="content">
                        <u>2020年春 - 2022年春</u>
                        <h3>things that i (we) heard around OTO building</h3>
                        <p><a href="https://creative-community.space/map/otobuilding/" target="_blank">私（わたしたち）が音ビルの周りで聞いた言葉</a></p>
                <div id="membersonly"></div>
                    </div>
                </details>
            </section>
            <?php endif; ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#membersonly").load("/map/things/membersonly.html");
            })
        </script>
    </body>

    </html>