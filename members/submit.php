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
$("#").load("");
})
</script>
<style type="text/css">
body {margin:0; padding:0; background:#ebd809;}

.ipaexg {font-family: "ipaexg";}
.DiaPro, .sub {font-family: "DiaPro";}

#org b {
  font-size:200%;
  display:inline-block;
  color:#fff;
  text-shadow:0.1rem 0.1rem #000;
}
#org .sub {
  padding:1rem;
  line-height:200%;
}
#org .sub a {
	color:#000;
background:#fff;
text-decoration:none;
padding:0.25rem;
border-radius:0.25rem;
border:0.1rem solid #000;
}
#org h1 {
  font-size:2rem;
  margin-top:-3.5rem;
  padding:0 2.5% 0;
}
#org .greeting {
  margin:0 auto 2.5rem;
  width:90%;
  padding:0 2.5vw;
  border:1px solid #000;
  border-radius:0.5rem;
	background-color:rgba(255,255,255,0.75);
}
#org h1 span {
  padding:1rem 0;
  display:inline-block;
  font-size:50%;
}

</style>
<title>Submit | Fancy and Relaxin'</title>
<link rel="icon" href="logo.png">
<link rel="stylesheet" type="text/css" href="review.css" />
</head>
<body>
<form action="complete.php" id="org" class="submit" method="post">
<div class="greeting ipaexm">
<p>※ このフォームから、あなたが見つけたスポットをコレクションに追加することができます。</p>
</div>
<p class="sub ipaexm"><b class="DiaPro">Title</b><br/>場所の名前（正式名称がない場合はあなたの呼び名）を入力して下さい<br/>
<input type="text" name="title" placeholder="Title" required></p>
<div class="search-box type">
<span class="sub ipaexm"><b class="DiaPro">Type</b><br/>スポットのカテゴリーを選択してください</span>
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
<span class="sub ipaexm"><b class="DiaPro">Review</b><br/>その場所の快適度・満足度を5段階で評価してください</span>
<ol>
<li>
<input type="radio" name="value" value="amazing" id="amazing" required>
<label for="amazing" class="label">*****</label></li>
<li>
<input type="radio" name="value" value="great" id="great" required>
<label for="great" class="label">****</label></li>
<li>
<input type="radio" name="value" value="okay" id="okay" required>
<label for="okay" class="label">***</label></li>
<li>
<input type="radio" name="value" value="bad" id="bad" required>
<label for="bad" class="label">**</label></li>
<li>
<input type="radio" name="value" value="awful" id="awful" required>
<label for="awful" class="label">*</label></li>
<li>
</ol>
</div>

<p class="sub ipaexm">その場所についての簡単なコメントを入力して下さい<br/><textarea name="comment" placeholder="comment" required></textarea></p>
<p class="sub ipaexm"><b class="DiaPro">Information</b><br/>その場所（正確な住所がわからなければ、〇〇付近など）の住所を入力してください<br/><input type="text" name="address" placeholder="address" required></p>
<p class="sub ipaexm">場所の座標を入力してください。 <a href="https://support.google.com/maps/answer/18539?co=GENIE.Platform%3DDesktop&hl=ja" target="_blank" rel="noopener noreferrer">座標の調べ方</a>
<br/><input type="text" name="link" value="none" required>
<br/>わからない場合は、noneと入力した状態のままご投稿ください。</p>
<div class="reset">
<button type="submit" class="DiaPro">Submit | 投稿する</button>
</div>
</form>
</body>
</html>
