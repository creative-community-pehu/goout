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
<link rel="stylesheet" href="/map/css/update.css"/>
<style>
body { margin: 0; padding: 0; }
</style>
</head>

<body>
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
<i class="goout">How to Coding</i></h2>
<p class="relax"><b>Mapboxを使って、初めて訪れた場所・お気に入りの場所を集めたコレクションを作成しています。</b></p>
</li>
</ul>
</body>
</html>