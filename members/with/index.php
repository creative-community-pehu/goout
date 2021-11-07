
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
<link rel="icon" href="/map/members/logo.png">
<link rel="stylesheet" href="/map/css/click.css"/>
<link rel="stylesheet" href="/map/css/fonts.css"/>
<link rel="stylesheet" href="https://creative-community.space/coding/fontbook/css/font-family.css"/>
<style>
body { margin: 0; padding: 0;  background:#ebd809;}
#links {width:95%; margin:auto;}

.DiaPro, .sub {font-family: "DiaPro";}

.about {
  top:0;
  font-size:1rem;
	padding:0 2.5% 0.5rem;
	position:relative;
  z-index:50;
  background:#000;
  width:95%;
}
.inside {
  width:95%;
  max-width:75rem;
  margin:auto;
}

.sub b {
  display:block;
  color:#ebd809;
  font-size:4.5rem;
  padding:1.25%;
}
</style>
</head>

<body>

<div class="about">
<div class="inside">
<span class="sub"><b>Special Contents</b></span>
</div>
</div>
<div id="links">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<div class="click">
<h1 class="left relax"><b><?=h($row[1])?></b></h1>
<h1 class="right relax"><b><?=h($row[0])?></b></h1>
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
