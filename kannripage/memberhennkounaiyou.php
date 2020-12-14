<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ニュース変更内容入力</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<!--<link rel="stylesheet" href="base.css" type="text/css" media="screen" /> -->
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
	
	// sqlからぶっこ抜いて入力フォームに入力内容が入った状態で表示する
	// mysqlに接続する
	require_once "databasezyouhou.php";
	$databasezyouhou = databasezyouhou();
	$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
	if (!$link) {
 		die("接続失敗" . mysqli_error());
	}
			
	if(isset($_POST['ID']) == false) {
		// 直接アクセスしてきている場合
		print "変更するメンバーが選ばれていません";
		print'<br><form action="memberhennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}
			
	$query = "SELECT * FROM member WHERE ID = " . $_POST['ID'];
	//print "$query"; // クエリが正しいかのデバッグ用		
	$result = mysqli_query($link, $query);
	$num_rows  = mysqli_num_rows($result);

	// 何でID指定して読み込んでるのにデータ無いんでしょうね？
	if($num_rows == 0) {
		print "データがありません";
		print'<br><form action="memberkannri.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}

	// 	配列に突っ込む
	$member = mysqli_fetch_array($result);

	// htmlでデータと変更決定ボタンを出力
	print '変更内容を入力して下さい<br>';
	print '<p>ユーザーIDとユーザーパスワード、名前、ふりがなは入力必須です。</p>';
	print '<form action="memberhennkousyori.php" method="POST" accept-charset="utf-8">';
	print '<p>ユーザーID</p>';
	print '<input type = "text" name = "Userid" size="40" maxlength="16" value ="' . $member['Userid'] .'" required><br>';
	print '<p>ユーザーパスワード</p>';
	print '<input type = "text" name = "Userpass" size="40" maxlength="16" value ="' . $member['Userpass'] .'" required><br>';
	print '<p>名前</p>';
	print '<input type = "text" name = "Namae" size="40" maxlength="50" value ="' . $member['Namae'] .'" required><br>';
	print '<p>ふりがな（ひらがな）</p>';
	print '<input type = "text" name = "Hurigana" size="40" maxlength="50" value ="' . $member['Hurigana'] .'" required><br>';
	print '<p>電話番号(-で区切らない形で)</p>';
	print '<input type = "number" name = "Dennwa" min="0" max ="2147483647" value ="' . $member['Hurigana'] .'"><br>';
	print '<p>備考欄</p>';
	print '<textarea name = "Bikou" rows="7" cols="60">';
	print $member['Bikou'];
	print '</textarea><br><br>';
	print '<input type="hidden" name="ID" value="'. $_POST['ID'] . '">';
	print '<input type="submit" value="変更"><br><br></form>';
			
	// DB接続を閉じる
	mysqli_close($link);
			
?>


<form action="memberhennkou.php" method="POST">
<input type="submit" value="戻る"><br>
</form>

</div>

<br><br>