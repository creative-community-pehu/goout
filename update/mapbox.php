<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$title = (string)filter_input(INPUT_POST, 'title');
$status = (string)filter_input(INPUT_POST, 'status');
$more = (string)filter_input(INPUT_POST, 'more');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('mapbox.csv', 'a+b');
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
<title>Go Out | 地図を作ろう</title>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="description" content="Life is precious.　Every minute.　And more precious with you in it.　Let's have some fun.">
<link rel="icon" href="/map/logo.png">
<link rel="stylesheet" href="/map/css/top.css" />
<link rel="stylesheet" href="/map/css/info.css" />
<link rel="stylesheet" href="/map/css/fonts.css" />
<link rel="stylesheet" href="/map/css/update.css"/>
<link rel="stylesheet" href="https://creative-community.space/coding/fontbook/css/font-family.css" />
<style>
    body {margin: 0; padding: 0; background-color:lemonchiffon;}
    #main {width:75%; margin:2vw auto;}
.cc {
    font-family: "ipag", monospace;
    transform:scale(1, 1.25);
}
#top_btn {
    position: fixed;
    bottom:0; left:0;
    z-index: 1000;
    margin:2.5vw;
    font-size:2.5vw;
}
#top_btn a {
    display: block;
    text-align: center;
    width: 5.5vw;
    height: 4.5vw;
    line-height: 4.5vw;
    color: #000;
    cursor: pointer;
    text-decoration: none;
    transition: all 1000ms ease;
}
#top_btn a:hover {
    color: lightskyblue;
    cursor: pointer;
    transition: all 1000ms ease;
}
    
</style>
</head>

<body>
<p id="top_btn"><a class="cc" href="#" onclick="history.back(-1);return false;">↵</a></p>

<div id="main">
<ul id="update_log">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<li class="goout">
<h2><u><?=h($row[0])?></u><br/>
<i><?=h($row[1])?></i></h2>
<p><b><?=h($row[2])?></b>
<a href="<?=h($row[3])?>" target="_blank" rel=”noopener noreferrer”></a></p>
</li>
<?php endforeach; ?>
<?php else: ?>
<li class="goout">
<h2><u>タイトル</u><br/>
<i>進行状況</i></h2>
<p><b>説明</b>
<a href="<?=h($row[3])?>" target="_blank" rel=”noopener noreferrer”></a></p>
</li>
<?php endif; ?>
<li>
<h2 class="relax"><u>地図を作ろう</u><br/>
<i class="goout">Work In Progress</i></h2>
<p class="relax"><b>Mapboxを使って、初めて訪れた場所・お気に入りの場所を集めたコレクションを作成しています。</b></p>
</li>
</ul>
</div>
</body>
</html>
