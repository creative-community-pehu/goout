<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$title = (string)filter_input(INPUT_POST, 'title');
$value = (string)filter_input(INPUT_POST, 'value');
$comment = (string)filter_input(INPUT_POST, 'comment');
$address = (string)filter_input(INPUT_POST, 'address');
$link = (string)filter_input(INPUT_POST, 'link');
$type = (string)filter_input(INPUT_POST, 'type');

$fp = fopen('list.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$title, $value, $comment, $address, $link, $type]);
    rewind($fp);
}

flock($fp, LOCK_SH);
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}
flock($fp, LOCK_UN);
fclose($fp);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://creative-community.space/coding/js/org.js"></script>
<script type="text/javascript">
$(function(){
})
</script>
<style type="text/css">
.ipaexg {font-family: "ipaexg";}
.DiaPro, .sub {font-family: "DiaPro";}

.type,
.list .title,
.list .address,
#bg_link {
  font-family: "DiaPro";
}


</style>
<title>Fancy and Relaxin' | Go Out</title>
<link rel="icon" href="logo.png">
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="stylesheet" type="text/css" href="review.css" />
</head>
<body>

<div class="popup" id="submit" style="display:none;">
<p><iframe src="submit.php"></iframe></p>
<span class="close" onclick="obj=document.getElementById('submit').style; obj.display=(obj.display=='none')?'block':'none';">✕</span>
</div>

<div class="about">
<div class="inside">
<span class="sub"><b>Fancy and Relaxin' Spots</b></span>
<span class="right DiaPro">
<u>
  <i>Update | 
  <?php
  $mod = filemtime("list.csv");
  date_default_timezone_set('Asia/Tokyo');
  print "".date("m.d.y H:i",$mod);
  ?>
  </i>
</u></span>
<a id="link" class="tag" onclick="obj=document.getElementById('submit').style; obj.display=(obj.display=='none')?'block':'none';"></a>
</div>
</div>
<div id="announce">
<div class="greeting">
<h1 class="DiaPro">初めて訪れた場所を「贅沢度・リラックス度」を基準に評価し、優雅にリラックスできるスポットのコレクションを制作しています。</h1>
<p>ファンシー・アンド・リラキシンは、行ったことのない場所に行く／知らない道を選ぶことで、気分をリフレッシュし、こ・こ・ろ・豊かな生活を送ることを目的とした活動です。</p>
<p>スポットの紹介と同時に、行ったことのない場所に行く／知らない道を選ぶ楽しさを記録します。</p>
</div>
</div>

<div id="announce">
<div class="greeting">

<form id="org">
<div class="search-box type">
<ol>
<li>
<input type="radio" name="type" value="nature" id="nature">
<label for="nature" class="label">公園・自然</label></li>
<li>
<input type="radio" name="type" value="cafe" id="cafe">
<label for="cafe" class="label">喫茶</label></li>
<li>
<input type="radio" name="type" value="spa" id="spa">
<label for="spa" class="label">銭湯・スパ</label></li>
<li>
<input type="radio" name="type" value="hotel" id="hotel">
<label for="hotel" class="label">ホテル</label></li>
<li>
<input type="radio" name="type" value="public" id="public">
<label for="public" class="label">商業・公共施設</label></li>
<li>
<input type="radio" name="type" value="touristic" id="touristic">
<label for="touristic" class="label">観光地</label></li>
<li>
<input type="radio" name="type" value="etc" id="etc">
<label for="etc" class="label">その他</label></li>
</ol>
</div>

  <div class="search-box tag">
  <ol>
  <li>
  <input type="radio" name="value" value="amazing" id="amazing">
  <label for="amazing" class="label">*****</label></li>
  <li>
  <input type="radio" name="value" value="great" id="great">
  <label for="great" class="label">****</label></li>
  <li>
  <input type="radio" name="value" value="okay" id="okay">
  <label for="okay" class="label">***</label></li>
  <li>
  <input type="radio" name="value" value="bad" id="bad">
  <label for="bad" class="label">**</label></li>
  <li>
  <input type="radio" name="value" value="awful" id="awful">
  <label for="awful" class="label">*</label></li>
  </ol>
  </div>
  <div class="reset">
  <input type="reset" name="reset" value="RESET" class="reset-button DiaPro">
  </div>
  </div>
</form>

</div>
</div>

<ol class="list ipaexm">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<li class="list_item list_toggle" data-value="<?=h($row[1])?>" data-type="<?=h($row[5])?>">
<span class="title"><?=h($row[0])?></span>
<span class="value"><b class="<?=h($row[1])?>"></b></span>
<p class="comment"><?=h($row[2])?></p>
<span class="address"><?=h($row[3])?></span>
<a class="<?=h($row[4])?>" href="https://www.google.com/maps/place/<?=h($row[4])?>" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endforeach; ?>
<?php else: ?>
<li id="<?=h($row[2])?>" class="list_item list_toggle radius">
<span class="title">Title</span>
<span class="value"><b class="wanttovisit"></b></span>
<p class="comment">Comment</p>
<span class="address">address</span>
<a class="none" href="https://www.google.com/maps/place/____" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endif; ?>
</ol>
</hr>
</body>
</html>
