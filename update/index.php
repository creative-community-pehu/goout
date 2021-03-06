<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$title = (string)filter_input(INPUT_POST, 'title');
$status = (string)filter_input(INPUT_POST, 'status');
$more = (string)filter_input(INPUT_POST, 'more');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('log.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$title, $status, $more, $link]);
    rewind($fp);
}

flock($fp, LOCK_SH);
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}
flock($fp, LOCK_UN);
fclose($fp);

?>
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <title>Go Out | 行ったことのない場所へ行く</title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="description" content="知っていることの外へ、わからないところまで出かける">
        <link rel="icon" href="/map/logo.png">
        <link rel="stylesheet" href="../css/fonts.css" />
        <link rel="stylesheet" href="style_v3.css" />
        <style>
            body {
                margin: 0;
                padding: 0;
                background-color: lemonchiffon;
            }
            
            #main {
                width: 90%;
                max-width: 750px;
                margin: 1rem auto;
            }
            
            #top_btn {
                position: fixed;
                bottom: 0;
                left: 0;
                z-index: 1000;
                margin: 1rem;
                font-size: 2rem;
            }
            
            #top_btn a {
                color: #000;
                text-decoration: none;
                transition: all 1000ms ease;
            }
            
            #top_btn a:hover {
                color: lightskyblue;
                cursor: pointer;
                transition: all 500ms ease;
            }
        </style>
    </head>

    <body>
        <p id="top_btn"><a href="#" onclick="history.back(-1);return false;">↵</a></p>

        <div id="main">
            <ul id="update_log">
                <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                <li class="goout">
                    <h2>
                        <?=h($row[0])?>
                    </h2>
                    <p><b><?=h($row[1])?></b>
                        <a href="<?=h($row[2])?>" target="<?=h($row[3])?>"></a>
                    </p>
                </li>
                <?php endforeach; ?>
                <?php else: ?>
                <li class="goout">
                    <h2>タイトル<br/>
                        <i>進行状況</i></h2>
                    <p><b>説明</b>
                        <a href="#" target="_parent"></a>
                    </p>
                </li>
                <?php endif; ?>
                <li>
                    <h2 class="relax">地図を作ろう<br/>
                        <i class="goout">Digital Map</i></h2>
                    <p class="goout"><b>Mapbox を使って、デジタル地図を作成</b>
                        <a href="mapbox.php" target="left"></a>
                    </p>
                </li>
            </ul>
        </div>
    </body>

    </html>