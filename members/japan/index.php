<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$name = (string)filter_input(INPUT_POST, 'name');
$address = (string)filter_input(INPUT_POST, 'address');
$tag = (string)filter_input(INPUT_POST, 'tag');
$info = (string)filter_input(INPUT_POST, 'info');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('map_contents.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$name, $address, $tag, $info, $link,]);
    rewind($fp);
}

flock($fp, LOCK_SH);
while ($row = fgetcsv($fp)) {
    $rows[] = $row;
}
flock($fp, LOCK_UN);
fclose($fp);

?>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title> (日本の)インディペンデントスペース | by VG CTLG </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="/coding/js/org.js"></script>
<script src="/coding/js/smoothscroll.js"></script>
<script type="text/javascript">
$(function(){
    $("#about").load("/map/japan.html");
})
</script>
<link rel="stylesheet" href="/coding/submit/org/form.css"/>
<link rel="stylesheet" href="/coding/css/radius.css"/>
<style type="text/css">
.vg {
  position:absolute;
  top:0;
  left:0;
  max-width:80%;
  z-index:50;
  font-family: 'Lucida Console', Courier, monospace;
  font-size: 1rem;
  transform:scale(1,1.5);
  color:#fff;
  background: #000;
  display: inline-block;
  padding: 0.25rem
}
#bg_link {
  position:absolute;
  z-index:100;
  top:0;
  right:0;
  color:#000;
  line-height:1.5rem;
  letter-spacing:.1rem;
  font-family: "MS 明朝","MS Mincho", serif;
  font-size:0.9rem;
  text-decoration:none;
  display:inline-block;
  -ms-writing-mode: tb-rl;
  writing-mode: vertical-rl;
}
#bg_link a {
  color:#000;
  line-height:1.5rem;
  letter-spacing:.1rem;
  font-family: "MS 明朝","MS Mincho", serif;
  background:#fff;
  text-decoration:none;
  padding:0.25rem 0.125rem;
}
#bg_link i {padding:0.25rem 0.125rem;}

.address {zoom:0.5;}
.list li span {
  animation:2s ease-in infinite fontmotion;
}
</style>
</head>
<body>
<span class="vg">
Independent space in Japan
</span>

<span id="bg_link">
<a><b>Update</b>
  <i>
  <?php
  $mod = filemtime("map_contents.csv");
  date_default_timezone_set('Asia/Tokyo');
  print "".date("m.d.y H:i",$mod);
  ?>
  </i>
</a>
</span>
<form id="org">
<div class="search-box tag">
<ul>
<li>
<input type="radio" name="tag" value="art" id="art">
<label for="art" class="label">Art Space</label></li>
<li>
<input type="radio" name="tag" value="book" id="book">
<label for="book" class="label">Book Store</label></li>
<li>
<input type="radio" name="tag" value="curture" id="curture">
<label for="curture" class="label">Culture Space</label></li>
<li>
<input type="radio" name="tag" value="music" id="music">
<label for="music" class="label">Music Store</label></li>
<li>
<input type="radio" name="tag" value="venue" id="venue">
<label for="venue" class="label">Etc, Venue</label></li>
</ul>
</div>
<div class="search-box address">
<ul>
<li>
<input type="radio" name="address" value="hokkaido" id="hokkaido">
<label for="hokkaido" class="label">Hokkaido</label></li>
<li>
<input type="radio" name="address" value="tohoku" id="tohoku">
<label for="tohoku" class="label">Tohoku</label></li>
<li>
<input type="radio" name="address" value="tokyo" id="tokyo">
<label for="tokyo" class="label">Tokyo</label></li>
<li>
<input type="radio" name="address" value="kanto" id="kanto">
<label for="kanto" class="label">Kanto</label></li>
<li>
<input type="radio" name="address" value="chubu" id="chubu">
<label for="chubu" class="label">Chūbu</label></li>
<li>
<input type="radio" name="address" value="osaka" id="osaka">
<label for="osaka" class="label">Osaka</label></li>
<li>
<input type="radio" name="address" value="kyoto" id="kyoto">
<label for="kyoto" class="label">Kyoto</label></li>
<li>
<input type="radio" name="address" value="kansai" id="kansai">
<label for="kansai" class="label">Kansai</label></li>
<li>
<input type="radio" name="address" value="shikoku" id="shikoku">
<label for="shikoku" class="label">Shikoku</label></li>
<li>
<input type="radio" name="address" value="chugoku" id="chugoku">
<label for="chugoku" class="label">Chūgoku</label></li>
<li>
<input type="radio" name="address" value="kyushu" id="kyushu">
<label for="kyushu" class="label">Kyusyu | Okinawa</label></li>
</ul>
</div>
<div class="reset">
<input type="reset" name="reset" value="RESET" class="reset-button">
</div>
</form>

<ul class="list">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<li id="<?=h($row[2])?>" class="list_item list_toggle radius" data-address="<?=h($row[1])?>" data-tag="<?=h($row[2])?>">
<span><?=h($row[0])?></span>
<p><?=h($row[3])?></p>
<a href="<?=h($row[4])?>" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endforeach; ?>
<?php else: ?>
<li id="<?=h($row[2])?>" class="list_item list_toggle radius" data-address="<?=h($row[1])?>" data-tag="<?=h($row[2])?>">
<span>Title</span>
<p>contents</p>
<a href="<?=h($row[4])?>" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endif; ?>
</ul>
</body>
</html>
