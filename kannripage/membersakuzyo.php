<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>メンバー削除確認</title>
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

	// mysqlに接続する
	require_once "databasezyouhou.php";
	$databasezyouhou = databasezyouhou();
	$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
	if (!$link) {
 		die("接続失敗" . mysqli_error());
	}
			
	if(isset($_POST['ID']) == false) {
		// 削除画面に直接アクセスしてきている場合
		print "削除するデータが選ばれていません";
		print'<br><form action="newshennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}
			
	$query = "SELECT * FROM member WHERE ID = " . $_POST['ID'];		
	$result = mysqli_query($link, $query);
	$num_rows   = mysqli_num_rows($result);

	// 何でID指定して読み込んでるのにデータ無いんでしょうね？
	if($num_rows == 0) {
		print "データがありません";
		print "$query"; // クエリが正しいかのデバッグ用
		print'<br><form action="newskannri.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
			exit();
	}

	// 	配列に突っ込む
	$member = mysqli_fetch_array($result);

	// htmlでデータと削除決定ボタンを出力
	print 'このデータを削除しますか？<br>';
	// 削除ボタン
	print '<br><form action="membersakuzyosyori.php" method="POST">';
	print '<input type="hidden" name="ID" value="'. $_POST['ID'] . '">';
	print '<input type="submit" value="削除"><br></form>';
	// メンバー情報
	print '<div class="member">';				
	print '<div class="user"><span class="id">ユーザーID:' . $member['Userid'];
	print '</span><span class="pass">パスワード:' . $member['Userpass'] . '</div>'; 
	print '</span><p class="namae">' . $member['Namae'] . '(' . $member['Hurigana'] . ')</p>';
	if ($member['Dennwa'] != null) {
		print '<p class="dennwa">電話番号:' . $member['Dennwa'] . '</p>';
	}
	if ($member['Bikou'] != null) {
		print '<p class="bikou">' . $member['Bikou'] . '</p>';
	}
	print '</div>';
			
	// DB接続を閉じる
	mysqli_close($link);
			
?>

<br>

<form action="memberhennkou.php" method="POST">
<input type="submit" value="戻る"><br>
</form>

</div>

</body>
</html>