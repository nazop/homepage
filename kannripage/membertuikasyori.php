<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>メンバー追加処理</title>
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
	
	// メンバーを挿入
	// mysqlに接続する
	require_once "databasezyouhou.php";
	$databasezyouhou = databasezyouhou();
	$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
	if (!$link) {
 		 die("接続失敗" . mysqli_error());
	}
			
	if (isset($_POST['Userid']) == true) {
		// isset==trueなら管理画面飛ばして直接アクセスはしてない
		// Useridは入力必須なのでそのままクエリの形に変換
		$Userid = "\"" . $_POST['Userid'] . "\"";

	} else {
		// POSTされたデータが無いと判断
		print "メンバーの情報が送信されていないのでメンバーを追加出来ません<br>";
		print'<br><form action="membertuika.php" method="POST">' .
			 '<input type="submit" value="メンバー追加画面へ"><br></form>';
		exit();
	}
			
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
	
	$query = "INSERT INTO member(Userid, Userpass, Namae, Hurigana, Dennwa, Bikou) ".
	"VALUES($Userid, $Userpass, $Namae, $Hurigana, $Dennwa, $Bikou)";z
	$result = mysqli_query($link, $query);
	if ($result == false) {
		// クエリ失敗してる。不正な入力が入る感じではないのでプログラムのミスだと思われる
		print "クエリが不正です<br>";
		print "$query<br>";
		print'<br><form action="membertuika.php" method="POST">' .
			 '<input type="submit" value="メンバー追加画面へ"><br></form>';
		exit();
	}
	mysqli_free_result($result);
			
	// DB接続を閉じる
	mysqli_close($link);		

	// ページ更新した時用＝二重投稿防止にページを移動させる
	//header('Location: http://web-sim.sub.jp/memberstuikakannryou.php'); // サーバ用
	//header('Location: http://localhost:81/homepage/membertuikakannryou.php'); // 自分のPCでのデバッグ用
	header('Location: ./membertuikakannryou.php');
	exit();
			
?>

<!--ページ更新した時用＝二重投稿防止にページを移動させる処理によって無駄になったhtml文章-->

<br><br>

<form action="memberkannri.php" method="POST">
<input type="submit" value="戻る"><br>
</form>

</div>

</body>
</html>