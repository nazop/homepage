<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
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
			
	if(isset($_POST['newsID']) == false) {
		// 直接アクセスしてきている場合
		print "変更するデータが選ばれていません";
		print'<br><form action="newshennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}
			
	$query = "SELECT * FROM news WHERE ID = " . $_POST['newsID'];
	//print "$query"; // クエリが正しいかのデバッグ用		
	$result = mysqli_query($link, $query);
	$num_rows   = mysqli_num_rows($result);

	// 何でID指定して読み込んでるのにデータ無いんでしょうね？
	if( $num_rows == 0 ) {
		print "データがありません";
		print'<br><form action="newskannri.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}

	// 	配列に突っ込む
	$news = mysqli_fetch_array($result);

	// htmlでデータと変更決定ボタンを出力
	// 後で画像も追加しようかな……
	// 変更可能な内容はタイトル、本文、画像
	print '変更内容を入力して下さい<br>';
	print $news['Nenn'] . "/";
	print $news['Tuki'] . "/";
	print $news['Hi'] . '<br>';
	print '<form action = "newshennkousyori.php" method="POST" enctype="multipart/form-data" accept-charset="utf-8">';
	print 'タイトル<br>';
	//print '<input type = "text" name = "taitoru" size="40" maxlength="50" value="' . mb_convert_encoding($news['Taitoru'], "utf8") .'"><br>';
	print '<input type = "text" name = "taitoru" size="40" maxlength="50" value="' . $news['Taitoru'] .'"><br>';
	print '本文<br>';
	print '<textarea name = "honnbunn" rows="7" cols="60">';
	print $news['Honnbunn'];
	//print mb_convert_encoding($news['Honnbunn'], "utf8");
	print '</textarea><br>';
	print '添付画像<br>';
	print '<input type ="file" name = "gazou"><br>';
	print '<br>';
	print '<input type="hidden" name="newsID" value="'. $_POST['newsID'] . '">';
	print '<input type="submit" value="変更"><br><br></form>';
			
	// DB接続を閉じる
	mysqli_close($link);
			
?>


<form action="newshennkou.php" method="POST">
<input type="submit" value="戻る"><br>
</form>

</div>

<br><br>