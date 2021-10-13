<?php
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
$name = (string)filter_input(INPUT_POST, 'name');
$address = (string)filter_input(INPUT_POST, 'address');
$tag = (string)filter_input(INPUT_POST, 'tag');
$info = (string)filter_input(INPUT_POST, 'info');
$link = (string)filter_input(INPUT_POST, 'link');

$fp = fopen('list.csv', 'a+b');
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
<title> Fancy Hotel Tour | Fancy and Relaxin' </title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://creative-community.space/coding/js/org.js"></script>
<script src="https://creative-community.space/coding/js/smoothscroll.js"></script>
<script type="text/javascript">
$(function(){
})
</script>
<link rel="stylesheet" href="https://creative-community.space/coding/submit/org/book.css"/>
<link rel="stylesheet" href="https://creative-community.space/coding/css/radius.css"/>
<link rel="stylesheet" href="https://creative-community.space/coding/fontbook/css/font-family.css" />
<link rel="stylesheet" href="/map/css/font.css" />
<link rel="stylesheet" href="/map/css/info.css" />
<link rel="stylesheet" href="/map/css/top.css" />
<style type="text/css">

body {
  background-color: #ebd809;
}
#org .tag .label {font-family: "DiaPro";}
#org .address .label {
  background-color:lemonchiffon;
  color: lightskyblue;
}
#org .address .label:hover {
  background-color:lightskyblue;
  color: lemonchiffon;
}
.address {zoom:0.5;}
.list li span {
  animation:2s ease-in infinite fontmotion;
}

    .cover {
      font-family: "Yu Gothic UI";
      background:#111;
    }
    .cover span {
      color:#fff;
      zoom: 200%;
    }
    .cover h1 {
      text-align: center;
      text-shadow:0 0 0.5vw lemonchiffon;
      color:#ebd809;
      font-family:"DiaPro";
      font-size: 12.5vw;
    }
    .cover h1 i {
      color:#000;
      background-color: #ebd809;
      display:inline-block;
      font-family:"DiaPro";
      font-size: 2.5vw;
      padding:0 1vw;
    }
    .cover a {color:#000;}

    .cover {
      background-image:url();
      background-color: #000;
    }
    #org h1 {
      display: inline-block;
      padding: 0 0.25rem;
      color:#ebd809;
      font-size: 1rem;
      background-color: #000;
      font-family: "ipaexg";
    }

      .relax #center a {
        text-align:center;
        animation:2s linear infinite alternate relax;
      }
      .relax #center a:hover {
        cursor:pointer;
        animation:.25s linear infinite alternate relax;
      }

      @keyframes relax {
        0% {
          color:#ebd809;
          background:#000;
        }
        100% {
          color:#000;
          background:#ebd809;
        }
        @-webkit-keyframes relax {
          0% {
          color:#ebd809;
          background:#000;
          }
          100% {
          color:#000;
          background:#ebd809;
          }
        }
      }

</style>
</head>
<body>
<div class="cover">
  <span class="left goout">Go Out</span>
  <span class="right relax">Presents</span>
  <h1>Fancy Hotel Tour</h1>
</div>

<ul class="list">
<?php if (!empty($rows)): ?>
<?php foreach ($rows as $row): ?>
<li id="<?=h($row[2])?>" class="list_item list_toggle radius" data-address="<?=h($row[1])?>" data-tag="<?=h($row[2])?>">
<p><?=h($row[3])?></p>
<span><?=h($row[0])?></span>
<a href="<?=h($row[4])?>"></a>
</li>
<?php endforeach; ?>
<?php else: ?>
<li id="<?=h($row[2])?>" class="list_item list_toggle radius" data-address="<?=h($row[1])?>" data-tag="<?=h($row[2])?>">
<p>Name</p>
<span>Title</span>
<a style="display:none;" href="none" target="_blank" rel="noopener noreferrer"></a>
</li>
<?php endif; ?>
</ul>
<hr/>

</body>
</html>
