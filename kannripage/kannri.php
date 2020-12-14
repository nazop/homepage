<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理画面</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<!-- <link rel="stylesheet" href="base.css" type="text/css" media="screen" /> -->
<link rel="stylesheet" href="kannri.css" type="text/css" media="screen" />
</head>

<body>

<div class ="konntenntuire">

<?php

	require_once "ninnsyou.php";
	
	if (ninnsyou() == false) {
		exit();
	}
			
?>

<!-- ここから本文 -->


<br><br>

<form action="newskannri.php" method="POST">
<input type="submit" value="ニュース管理画面"><br>
</form>

<br><br>

<form action="memberkannri.php" method="POST">
<input type="submit" value="メンバー管理画面"><br>
</form>

<br><br>

<form action="main.php" method="POST">
<input type="submit" value="戻る"><br>
</form>

</div>

</body>
</html>