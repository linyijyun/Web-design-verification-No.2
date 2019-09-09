<?php include "base.php";?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0039) -->
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<title>健康促進網</title>
	<link href="./css/css.css" rel="stylesheet" type="text/css">
	<script src="./js/jquery-1.9.1.min.js"></script>
	<script src="./js/js.js"></script>
</head>

<body>
	<div id="alerr"
		style="background:rgba(51,51,51,0.8); color:#FFF; min-height:100px; width:300px; position:fixed; display:none; z-index:9999; overflow:auto;">
		<pre id="ssaa"></pre>
	</div>
	<iframe name="back" style="display:none;"></iframe>
	<div id="all">
		<div id="title">
      <!--以date()函式取出題目所需的日期格式---------------------------------------計算total資料表中的總瀏灠數並顯示--------->
			<?=date("m月d日 l");?> | 今日瀏覽: <?=$_SESSION['total'];?> | 累積瀏覽: <?=q("select sum(`total`) from `total`")[0][0];?> 
			<a href='index.php' style="float:right">回首頁</a>
		</div>
		<div id="title2">
			<a href="index.php">
				<img src="./icon/02B01.jpg" alt="健康促進網-回首頁"  title="健康促進網-回首頁">
			</a>
		</div>
		<div id="mm">
			<div class="hal" id="lef">
				<a class="blo" href="?do=user">帳號管理</a>
				<a class="blo" href="?do=po">分類網誌</a>
				<a class="blo" href="?do=news">最新文章管理</a>
				<a class="blo" href="?do=know">講座管理</a>
				<a class="blo" href="?do=que">問卷管理</a>
			</div>
			<div class="hal" id="main">
				<div>
					<marquee style="width:80%; display:inline-block">
					請民眾踴躍投稿電子報，讓電子報成為大家相互交流、分享的園地！詳見最新文章
					</marquee>
					<span style="width:18%; display:inline-block;">
					<?php
          //以登入的狀態來決定要顯示的內容為會員登入或會員帳號
						if(empty($_SESSION['login'])){
							echo "<a href='?do=login'>會員登入</a>";
						}else{

              //以登入帳號來決定是管理者admin登入還是一般會員
							if($_SESSION['login']!="admin"){
						?>
						歡迎，<?=$_SESSION['login'];?>
						
						<button onclick="lof('index.php?do=logout')">登出</button>
						<?php

							}else{

						?>
						歡迎，<?=$_SESSION['login'];?>
            <!----管理者admin登入的話會多一個"管理"按鈕----->
						<button onclick="lof('admin.php')">管理</button> |
						<button onclick="lof('index.php?do=logout')">登出</button>
						<?php
							}
						}

						?>
					</span>
					<div class="">
					<?php
          //依照網址參數來決定中間區塊要載入那個檔案
					$do=(!empty($_GET['do']))?$_GET['do']:"";
					switch($do){
            case "user":
              //會員管理
							include "ad_user.php";
						break;
            case "news":
              //最新文章管理
							include "ad_news.php";
						break;
            case "que":
              //問卷管理
							include "ad_que.php";
						break;
            default:
            //不在功能中的項目一律顯示以下文字內容
						echo "<h1 class='ct'>請選擇管理項目</h1>";

					}
				?>
					</div>
				</div>
			</div>
		</div>
		<div id="bottom">
			本網站建議使用：IE9.0以上版本，1024 x 768 pixels 以上觀賞瀏覽 ， Copyright © 2019健康促進網社群平台 All Right Reserved
			<br>服務信箱：health@test.labor.gov.tw<img src="./icon/02B02.jpg" width="45">
		</div>
	</div>

</body>

</html>