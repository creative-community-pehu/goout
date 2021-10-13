
<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$format = (string)filter_input(INPUT_POST, 'format');
$date = (string)filter_input(INPUT_POST, 'date');
$comment = (string)filter_input(INPUT_POST, 'comment');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('date.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$format, $date, $comment, $link]);
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
<title>Fancy and Relaxin' | with</title>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="description" content="行ったことのない場所へ（知らない道を選んで）、行く">
<link rel="icon" href="/map/members/relax/logo.png">
<link rel="stylesheet" href="/map/css/links.css"/>
<link rel="stylesheet" href="/map/css/fonts.css"/>
<link rel="stylesheet" href="https://creative-community.space/coding/fontbook/css/font-family.css"/>
<style>
body { margin: 0; padding: 0; }
#links {width:90%; margin:auto;}
</style>
</head>

<body>
<div id="links">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<div class="click">
<h1 class="left relax"><b><?=h($row[0])?></b></h1>
<h1 class="right relax"><b><?=h($row[1])?></b></h1>
<p class="btn center relax"><a href="<?=h($row[3])?>" target="_parent"><?=h($row[2])?></a></p>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="click">
<h1 class="left relax"><b>Fancy and</b></h1>
<h1 class="right relax"><b>Relaxin' with</b></h1>
<p class="btn center relax"><a href="/map/members/relax/" target="_parent">Members Only</a></p>
</div>
<?php endif; ?>
</div>
</body>
</html>
