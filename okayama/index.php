<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$date = (string)filter_input(INPUT_POST, 'date'); // $_POST['date']
$sub = (string)filter_input(INPUT_POST, 'sub'); // $_POST['sub']
$tag = (string)filter_input(INPUT_POST, 'tag'); // $_POST['tag']
$address_a = (string)filter_input(INPUT_POST, '$address_a'); // $_POST['$address_a']
$address_b = (string)filter_input(INPUT_POST, '$address_b'); // $_POST['$address_b']
$link = (string)filter_input(INPUT_POST, 'link'); // $_POST['link']
$comment = (string)filter_input(INPUT_POST, 'comment'); // $_POST['comment']
$photo = (string)filter_input(INPUT_POST, 'photo'); // $_POST['photo']

$fp = fopen('okayama.csv', 'a+b');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    flock($fp, LOCK_EX);
    fputcsv($fp, [$date, $sub, $tag, $address, $link, $comment, $photo,]);
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
<title>岡山県オススメ60スポット | イトウヒロキ</title>
<link rel="stylesheet" type="text/css" href="/online/map/map.css" />
</head>
<body>
<div class="popup" id="about" style="display:none;">
<p><iframe src="about.php"></iframe></p>
<span class="close" onclick="obj=document.getElementById('about').style; obj.display=(obj.display=='none')?'block':'none';">✕</span>
</div>
<div class="about">
<span class="sub">岡山県オススメ60スポット</span>
<span class="sub">イトウヒロキ</span>
<a id="link" class="tag" onclick="obj=document.getElementById('about').style; obj.display=(obj.display=='none')?'block':'none';"></a>
</div>
<div class="refine">

<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<div class="refine-teims <?=h($row[2])?>" onclick="obj=document.getElementById('<?=h($row[5])?>').style; obj.display=(obj.display=='none')?'block':'none';">
<span class="date">No <?=h($row[0])?></span>
<div class="info" id="<?=h($row[5])?>" style="display:none;">
<p class="img"><img src='<?=h($row[7])?>'></p>
<span class="sub"><?=h($row[1])?></span>
<p class="text"><?=h($row[6])?></p>
<span class="address">
<a href="https://www.google.com/maps/place/<?=h($row[3])?>,<?=h($row[4])?>" target="_blank" rel="noopener noreferrer"><?=h($row[3])?>,<?=h($row[4])?></a></span>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<?php endif; ?>
</div>
</body>
</html>