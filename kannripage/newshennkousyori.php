<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ニュース変更処理</title>
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
	require_once"databasezyouhou.php";
	$databasezyouhou = databasezyouhou();
	$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
	if (!$link) {
 		die("接続失敗" . mysqli_error());
	}
			
	if(isset($_POST['newsID']) == false) {
		// 変更画面に直接アクセスしてきている場合
		print "変更するデータが選ばれていません";
		print'<br><form action="newshennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}
			
	if (strval($_POST['taitoru']) == '') {
		// タイトルが未入力の場合
		$taitoru = "\"" . "無題" . "\"";
	} else {
		$taitoru = "\"" . $_POST['taitoru']. "\"";
	}
	//mb_convert_encoding($taitoru, "utf8");
			
	if (strval($_POST['honnbunn']) == '') {
		// 未入力の場合
		$honnbunn = 'null';
	} else {
		$honnbunn =  "\"" . $_POST['honnbunn'] . "\"";
		//mb_convert_encoding($honnbunn, "utf8");
	}
			
	// 画像の処理
	// 今の画像を削除してアップロードする
	// 今の画像消す部分
	$query = "SELECT * FROM news WHERE ID = " . $_POST['newsID'];
	$result = mysqli_query($link, $query);
	$num_rows   = mysqli_num_rows($result);
	// 何でID指定して読み込んでるのにデータ無いんでしょうね？
	if($num_rows == 0) {
		print "データがありません";
		print'<br><form action="newshennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}
	// 結果を配列に突っ込む
	$news = mysqli_fetch_array($result);
	if($news['Gazou'] != null) {
		$gazou = $news['Gazou'];
		// ほぼほぼデバッグ用
		if(unlink($gazou) == false) {
			print "画像の消去に失敗しました";
			print'<br><form action="newshennkou.php" method="POST">' .
			 	 '<input type="submit" value="戻る"><br></form>';
			exit();
		}
	}
	// 画像のアップロード処理とsqlのクエリ変更用文字列$gazouを作る
	// アップロードされたファイルが一時ファイルに入ってるので移動させる
	$tempfile = $_FILES['gazou']['tmp_name']; // アップロードされたファイルの場所
	$filename = './gazou/' . $_FILES['gazou']['name']; // 移動先
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
			
	$query = "UPDATE news SET Taitoru = " . $taitoru . 
			", Honnbunn = " . $honnbunn . 
			", Gazou = " . $gazou .
			" WHERE ID = " . $_POST['newsID'];
	//print "$query"; // クエリが正しいかのデバッグ用		
	$resultUpdate = mysqli_query($link, $query);

	if($resultUpdate == false) {
		print "アップデートに失敗しました";
		print'<br><form action="newshennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}

	// 変更完了メッセージ出してしゅーりょー
	// SELECTで確認作業入れても良いけどデバッグ用では？
	// 戻るボタンはphp外で入ってるのでスルー
	print "<p>変更完了しました</p>";
			
	// DB接続を閉じる
	mysqli_close($link);
			
?>

<form action="newshennkou.php" method="POST">
<input type="submit" value="ニュース変更画面に戻る"><br>
</form>

</div>

<br><br>