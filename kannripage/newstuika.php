<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ニュース追加画面</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<!-- <link rel="stylesheet" href="base.css" type="text/css" media="screen" /> -->
<link rel="stylesheet" href="kannri.css" type="text/css" media="screen" />
</head>

<body>

<div class ="konntenntuire">

<!-- ここから本文 -->

<?php

	require_once "ninnsyou.php";
	
	if (ninnsyou() == false) {
		exit();
	}
			
?>

<p>ニュースとして追加する内容を入力して下さい</p>

<form action = "newstuikasyori.php" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
<!-- ID,シリアル,年月日はオート入力 -->
<p>タイトル</p>
<input type = "text" name = "taitoru" size="40" maxlength="50"><br>
<p>本文</p>
<textarea name = "honnbunn" rows="7" cols="60"></textarea><br>
<p>添付画像</p>
<input type ="file" name = "gazou"><br><br>
<input type="submit" value="ニュース追加"><br><br>
</form>


<form action="newskannri.php" method="POST">
<input type="submit" value="戻る"><br>
</form>

</div>

</body>
</html>