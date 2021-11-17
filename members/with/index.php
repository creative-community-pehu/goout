<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$label = (string)filter_input(INPUT_POST, 'label');
$date = (string)filter_input(INPUT_POST, 'date');
$status = (string)filter_input(INPUT_POST, 'status');
$title = (string)filter_input(INPUT_POST, 'title');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('date.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$label, $date, $status, $title, $link]);
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
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title> Go Out | Members Only </title>
<link rel="stylesheet" href="https://creative-community.space/map/css/click.css" />
<link rel="stylesheet" href="https://creative-community.space/map/css/fonts.css" />
<style type="text/css">
body {padding:0; margin: 0; background:lemonchiffon;}
#cover {
  position:relative;
  display:block;
  width:100%;
  height:10rem;
  animation: 5s ease-in 2.5s reverse both running slidein;
}
#cover a {
    background:#fff;
    border: 0.1vw solid #000;
    border-radius: 50%;
    padding: 0.5vw 5vw;
    font-size: 4vw;
    color:#000;
    text-decoration: none;
}
.center {
  position:absolute;
  top:50%; left:50%;
  transform:translate(-50%,-50%);
  -webkit-transform:translate(-50%,-50%);
  margin:0; padding:0;
}
body { margin: 0; padding: 0;}
#links {width:95%; margin:0 auto 5rem;}
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
<div id="cover">
<h1 id="title" class="center goout"><span>Special</span></h1>
</div>

<div id="links">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<div class="click">
<h1 class="left <?=h($row[0])?>"><b><?=h($row[1])?></b></h1>
<h1 class="right <?=h($row[0])?>"><b><?=h($row[2])?></b></h1>
<p class="btn center <?=h($row[0])?>">
  <a href="<?=h($row[4])?>" target="_parent"><?=h($row[3])?></a>
</p>

<?php endforeach; ?>
<?php else: ?>
<div class="click">
<h1 class="left goout"><b>00.00.0000</b></h1>
<h1 class="right goout"><b>With</b></h1>
<p class="btn center goout"><a href="" target="_parent">Title</a></p>
</div>
<?php endif; ?>
</div>
</body>
</html>
