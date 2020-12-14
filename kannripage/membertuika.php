<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>メンバー追加</title>
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

<!-- ユーザーIDとユーザーパスワードと名前・フリガナ、電話番号、備考欄を入力させる。SQLでのIDは勝手に挿入される仕様 -->
<p>追加するメンバーの情報を入力して下さい。</p>
<p>ユーザーIDとユーザーパスワード、名前、ふりがなは入力必須です。</p>
<form action="membertuikasyori.php" method="POST" accept-charset="utf-8">
<p>ユーザーID</p>
<input type = "text" name = "Userid" size="40" maxlength="16" required><br>
<p>ユーザーパスワード</p>
<input type = "text" name = "Userpass" size="40" maxlength="16" required><br>
<p>名前</p>
<input type = "text" name = "Namae" size="40" maxlength="50" required><br>
<p>ふりがな（ひらがな）</p>
<input type = "text" name = "Hurigana" size="40" maxlength="50" required><br>
<p>電話番号(-で区切らない形で)</p>
<input type = "number" name = "Dennwa" min="0" max ="2147483647"><br>
<p>備考欄</p>
<textarea name = "Bikou" rows="7" cols="60"></textarea><br><br>
<input type="submit" value="追加"><br>
</form>

<br><br>

<form action="memberkannri.php" method="POST">
<input type="submit" value="戻る"><br>
</form>

</div>

</body>
</html>