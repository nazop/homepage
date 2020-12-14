<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>メンバー変更処理</title>
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
	
	// mysqlに接続する
	require_once "databasezyouhou.php";
	$databasezyouhou = databasezyouhou();
	$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
	if (!$link) {
 		die("接続失敗" . mysqli_error());
	}
			
	if(isset($_POST['ID']) == false) {
		// 変更画面に直接アクセスしてきている場合
		print "変更するメンバーが選ばれていません";
		print'<br><form action="memberhennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}
	
	// Useridは入力必須なのでそのままクエリの形に変換
	$Userid = "\"" . $_POST['Userid'] . "\"";
			
	// Userpassも入力必須
	$Userpass = "\"" .$_POST['Userpass'] . "\"";
	// 名前とふりがなも入力必須
	$Namae =  "\"" . $_POST['Namae'] . "\"";
	$Hurigana =  "\"" . $_POST['Hurigana'] . "\"";
	// 電話番号は数値限定だけど正しいのが入ってるかそもそも入力されてるか謎
	// どっちみち0から2147483647
	if (strval($_POST['Dennwa']) == '') {
		// 未入力の場合
		$Dennwa = 'null';
	} else {
		$Dennwa = "\"" .$_POST['Dennwa'] . "\"";
	}
	// 備考欄も無くて良い
	if (strval($_POST['Bikou']) == '') {
		// 未入力の場合
		$Bikou = 'null';
	} else {
		$Bikou = "\"" . $_POST['Dennwa'] . "\"";
	}
			
	$query = "UPDATE member SET Userid = " . $Userid . 
			", Userpass = " . $Userpass . 
			", Namae = " . $Namae .
			", Hurigana = " . $Hurigana .
			", Dennwa = " . $Dennwa .
			", Bikou = " . $Bikou .
			" WHERE ID = " . $_POST['ID'];
					
	$resultUpdate = mysqli_query($link, $query);

	if($resultUpdate == false) {
		print "アップデートに失敗しました";
		print "$query"; // クエリが正しいかのデバッグ用
		print'<br><form action="newshennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}

	// 変更完了メッセージ出してしゅーりょー
	// SELECTで確認作業入れても良いけどデバッグ用では？
	// 戻るボタンはphp外で入ってるのでスルー
	print "変更完了しました<BR>";
			
	// DB接続を閉じる
	mysqli_close($link);
			
?>

<form action="memberhennkou.php" method="POST">
<input type="submit" value="メンバー変更画面に戻る"><br>
</form>

</div>

<br><br>