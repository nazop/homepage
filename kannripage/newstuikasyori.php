<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ニュース追加処理</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<!-- <link rel="stylesheet" href="base.css" type="text/css" media="screen" /> -->
<!-- base layout css.design sample -->
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

	// DB処理
	$hizuke = time();
	$nenn = date("Y", $hizuke);
	$tuki = date("n", $hizuke);
	$hi = date("j", $hizuke);
	if (isset($_POST['taitoru']) == true) {
		// isset==trueなら管理画面飛ばして直接アクセスはしてない
		if (strval($_POST['taitoru']) == '') {
			// タイトルが未入力の場合
			$taitoru = "\"" . "無題" . "\"";
		} else {
			$taitoru = "\"" . $_POST['taitoru'] . "\"";
		}
		//mb_convert_encoding($taitoru, "utf8");
	} else {
		// タイトルだけ無いなんて事は無いと思うので全部無いと判断
		print "ニュースが送信されていないのでニュースを追加出来ません<br>";
		print'<br><form action="newskannri.php" method="POST">' .
			 '<input type="submit" value="ニュース管理画面へ"><br></form>';
		exit();
	}
	if (strval($_POST['honnbunn']) == '') {
		// 未入力の場合
		$honnbunn = 'null';
	} else {
		$honnbunn =  "\"" . $_POST['honnbunn'] . "\"";
		//mb_convert_encoding($honnbunn, "utf8");
	}
			
	// 画像の処理
	// アップロードされたファイルが一時ファイルに入ってるので移動させる
	$tempfile = $_FILES['gazou']['tmp_name']; // アップロードされたファイルの場所
	$filename = '../gazou/' . $_FILES['gazou']['name']; // 移動先
	if(is_uploaded_file($tempfile)){ // ファイルが存在するか確かめる
		if(move_uploaded_file($tempfile , $filename )) { // 移動させてそれが成功したか確かめる
			// 成功してたらクエリに突っ込む用に$gazouに入ってる文字列を変換
			$gazou = "\"" . $filename . "\"";
		} else {
			print "画像のアップロードに失敗しました<br>";
			print '<form action="newskannri.php" method="POST">';
			print '<input type="submit" value="戻る"></form><br>';
			exit();
		}
	} else {
		// 未入力の場合
		$gazou = 'null';
	}

	$query = "INSERT INTO news(Hizuke, Nenn, Tuki, Hi, Taitoru, Honnbunn, Gazou) ".
	"VALUES($hizuke, $nenn, $tuki, $hi, $taitoru, $honnbunn, $gazou)";
	//$query = 'INSERT INTO news(nenn) VALUES(1)';\
	//$query = 'INSERT INTO news(taitoru) VALUES($taitoru)';
	//print"$query<br>";exit(); // デバッグ用
	$result = mysqli_query($link, $query);
	if ($result == false) {
		// クエリ失敗してる。不正な入力が入る感じではないのでプログラムのミスだと思われる
		print "クエリが不正です<br>";
		print "$query<br>";
		print'<br><form action="newskannri.php" method="POST">' .
			 '<input type="submit" value="メンバー追加画面へ"><br></form>';
		exit();
	}
	//mysqli_free_result($result); // result解放用だけどINSERT文では必要無いのでは？
	//クエリが正しいかデバッグする用
	//print "$hizuke, $nenn, $tuki, $hi, $taitoru, $honnbunn, $gazou, $query";

	// DB接続を閉じる
	mysqli_close($link);
	// ページ更新した時用＝二重投稿防止にページを移動させる
	//header('Location: http://web-sim.sub.jp/newstuikakannryou.php'); // サーバ用
	//header('Location: http://localhost:81/homepage/newstuikakannryou.php'); // 自分のPCでのデバッグ用
	header('Location:./newstuikakannryou.php');
	exit();
			
?>

<!--ページ更新した時用＝二重投稿防止にページを移動させる処理によって無駄になったhtml文章-->

<br>

<form action="newskannri.php" method="POST">
<input type="submit" value="戻る"><br>
</form>

<br>

</div>

</body>
</html>