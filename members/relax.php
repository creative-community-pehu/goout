<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width">
<style type="text/css">

#date_list li {
  display:none;
}
#btn-play{
  position:relative;
  z-index:10;
  display:block;
  width:75%;
  margin:0 auto 2.5rem;
  border:none;
  font-family: "DiaPro";
  font-size: 2rem;
}
.close {filter: invert(1);}

.about #link {
  position:absolute;
	cursor:pointer;
  margin:0;
  top:0; left:0;
  width:100%; height:100%;
  text-indent:-999px;
}
.about:hover {
  cursor:pointer;
  color:#fff;
  background:#eee;
  text-shadow:0.1rem 0.1rem #000;
  transition:.5s all;
}
.relax a {
  animation:2s linear infinite alternate relax;
}
.relax a:hover {
  animation:0.25s linear infinite alternate relax;
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

@media screen and (max-width: 750px){
#date_list li {
  width:100%;
}
#dance {transform:scale(0.75);}
}


.print{display:none;}

@media print{
.print{display:block;}
.no_print{display: none;}
}
</style>
<title>Fancy and Relaxin' | Go Out</title>
<meta name="description" content="行ったことのない場所へ（知らない道を選んで）、行く">
<link rel="icon" href="logo.png">
<link rel="stylesheet" type="text/css" href="relax.css" />
<link rel="stylesheet" type="text/css" href="review.css" />
<link rel="stylesheet" href="https://creative-community.space/coding/fontbook/css/font-family.css" />
</head>
<body>

<div class="popup" id="submit" style="display:none;">
<p><iframe src="submit.php"></iframe></p>
<span class="close" onclick="obj=document.getElementById('submit').style; obj.display=(obj.display=='none')?'block':'none';">✕</span>
</div>

<div class="about">
<div class="inside">
<span class="sub"><b>Fancy and Relaxin'</b></span>
<span class="right DiaPro">
<u>
  <i>Update | 
  <?php
  $mod = filemtime("list.csv");
  date_default_timezone_set('Asia/Tokyo');
  print "".date("m.d.y H:i",$mod);
  ?>
  </i>
</u>
</span>
<a id="link" class="tag" onclick="obj=document.getElementById('submit').style; obj.display=(obj.display=='none')?'block':'none';"></a>
</div>
</div>
<div id="info" class="no_print">
<div class="greeting">
<b>ファンシー・アンド・リラキシン</b>
</div>
<h1 class="DiaPro">行ったことのない場所へ（知らない道を選んで）、行く</h1>
<h1 class="DiaPro">
<span><u>活動内容</u><br/>最短ルートではなく、贅沢さ・心地よさを基準に道を選ぶ。<br/>初めて訪れた場所でもリラックスし、優雅に過ごすことを心がける。</span><br/>
</div>
<hr/>
<div id="dance"></div>
<div class="no_print">
<audio id="bgm1" preload loop>
  <source src="If_I_Were_A_Bell.mp3" type="audio/mp3">
</audio>
<button id="btn-play" type="button"><b class="fas fa-play">"We'll play and tell you what it is later"</b></button>
<hr/>
</div>
<div id="review"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
$("#dance").load("image.html");
$("#review").load("review.php");
})
</script>
<script>
  const bgm1 = document.querySelector("#bgm1");       // <audio>
  const btn  = document.querySelector("#btn-play");   // <button>

  btn.addEventListener("click", ()=>{
    // pausedがtrue=>停止, false=>再生中
    if( ! bgm1.paused ){
      btn.innerHTML = '<b class="fas fa-play">from Album "Relaxin with the Miles Davis Quintet"</b>';  // 「再生ボタン」に切り替え
      bgm1.pause();
    }
    else{
      btn.innerHTML = '<b class="fas fa-pause">BGM: If I Were A Bell by The Miles Davis Quintet</b>';  // 「一時停止ボタン」に切り替え
      bgm1.play();
    }
  });

  /**
   * [event] 再生終了時に実行
   */
   bgm1.addEventListener("ended", ()=>{
    bgm1.currentTime = 0;  // 再生位置を先頭に移動(こいつはなくても大丈夫です)
    btn.innerHTML = '<b class="fas fa-play"></b>';  // 「再生ボタン」に変更
  });
</script>
</body>
</html>