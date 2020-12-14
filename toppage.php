<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>組合名</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" href="base.css" type="text/css" media="screen" />
<!-- base layout css.design sample -->
</head>
<body>
<div id="wrapper">
<div id="header">
<!-- キーワード -->
<!-- <h1>*** キーワード ***</h1> -->
<!-- 企業名｜ショップ名｜タイトル -->
<p class="logo"><a href="toppage.php">組合名</a> TEL:電話番号 </p>
<p class="gaiyou">外国人技能実習生の受け入れについて、お気軽にご相談ください。</p>

<!-- ページの概要 -->
<!--
<p class="description">*** ページの概要 ***</p> -->
</div><!-- / header end -->

<div class ="header2">
</div>

<div id="contents">
<!-- コンテンツここから -->

<h2>外国人技能実習生の受け入れをサポート</h2>
<p>組合名では、平成12年5月から、婦人子供服製造業・内装仕上げ施工業、帆布製品製造業、総菜加工、鉄鋼、とび、パン製造、冷凍空気調和機器施工等々と、多種多様な業種での技能実習生を受け入れ、管理団体として運営して参りました。</p>
<p>この度の法改正に伴い、介護分野における技能実習生の受け入れ準備をしております。</p>
<p>より質の高い人材の確保を円滑に行う事が出来るように早期から取り組み、介護分野における技能実習生解禁に備え支援し、解禁後技能実習生の受け入れを可能とします。</p>


<h3>ニュース</h3>
<!-- <p>テキスト</p> -->
<?php
	// ニュースを表示

	// 1ページの表示数
	$hyouzisuu = 5;
	
	// mysqlに接続する
	require_once "databasezyouhou.php";
	$databasezyouhou = databasezyouhou();
	$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
	if (!$link) {
 		ie("接続失敗" . mysqli_error());
	}
	
	$query = "SELECT * FROM news ORDER BY ID DESC LIMIT $hyouzisuu"; // 降順でhyouzisuu分取ってきている			
	$result = mysqli_query($link, $query);
	$num_rows = mysqli_num_rows($result);

	// 	二次元配列に突っ込む
	$news = array();
	for ($i = 0; $i < $num_rows; $i++) {
		$news[$i] = mysqli_fetch_array($result);
	}

	// ニュースをhtml形式で吐き出す
	for ($i = 0; $i < $num_rows; $i++) {
		print '<div class="news">';
		print '<div class="hiduketaitoru"><span class="newshiduke">';
		print $news[$i]['Nenn'] . "/";
		print $news[$i]['Tuki'] . "/";
		print $news[$i]['Hi'];
		print '</span><span class="newstitle">' . mb_convert_encoding($news[$i]['Taitoru'], "utf8");
		print "</span></div>";
		print '<p class ="newshonnbunn">'.mb_convert_encoding($news[$i]['Honnbunn'], "utf8") . "</p>";
		print '<br>';
		if($news[$i]['Gazou'] != null) {
			print '<img border="0" src="'. $news[$i]['Gazou'] .'" alt="ニュース画像">';
			print "<br><br>";
		}
		print "</div>";
	}
	
	// DB接続を閉じる
	mysqli_close($link);

?>

<br>
<a href="newspage.php">古いニュースへ</a>

<!-- コンテンツここまで -->
</div><!-- / contents end -->

<div id="sidebar">
<!-- サイドバー ここから -->

<p class="side-title">メニュー</p>
<ul class="localnavi">
<li><a href="toppage.php">トップページ</a></li>
<li><a href="annnai.html">組合案内</a></li>
<li><a href="ginouzissyuu.html">外国人技能実習生制度</a></li>
<li><a href="danntai.html">関連団体</a></li>
<li><a href="toiawase.php">お問い合わせ</a></li>
</ul>
<!--
<p class="side-title">*** タイトル ***</p>
<ul class="localnavi">
<li><a href="#">*** リンク ***</a></li>
<li><a href="#">*** リンク ***</a></li>
<li><a href="#">*** リンク ***</a></li>
<li><a href="#">*** リンク ***</a></li>
<li><a href="#">*** リンク ***</a></li>
</ul>
-->

<!-- サイドバー ここまで -->
</div><!-- / sidebar end -->
<div id="footer">
<!-- コピーライト / 著作権表示 -->
<p>Copyright &copy; *** 組合名 ***. All Rights Reserved.</p>
</div>
</div>
</body>
</html>