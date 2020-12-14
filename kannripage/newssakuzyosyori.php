<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ニュース削除実行</title>
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

	// データを削除する
	// mysqlに接続する
	require_once "databasezyouhou.php";
	$databasezyouhou = databasezyouhou();
	$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
	if (!$link) {
 		die("接続失敗" . mysqli_error());
	}
			
	if(isset($_POST['newsID']) == false) {
		// 削除画面に直接アクセスしてきている場合
		print "削除するデータが選ばれていません";
		print'<br><form action="newshennkou.php" method="POST">' .
			 '<input type="submit" value="戻る"><br></form>';
		exit();
	}
			
	// まず画像データを削除
	$query = "SELECT * FROM news WHERE ID = " . $_POST['newsID'];
	$result = mysqli_query($link, $query);
	$num_rows   = mysqli_num_rows($result);
	// 何でID指定して読み込んでるのにデータ無いんでしょうね？
	// あっ更新したら行くんじゃね？
	if($num_rows == 0) {
		print "データがありません";
		print'<br><form action="newshennkou.php" method="POST">' .
	 		 '<input type="submit" value="戻る"><br></form>';
		exit();
	}
	// 結果を配列に突っ込む
	$news = mysqli_fetch_array($result);
	if($news['Gazou'] != null) {
		//$gazou = "\"" . str_replace('./', '/', $news['Gazou'])  . "\"";
		//$gazou = "\"" . mb_convert_encoding($news['Gazou'], "utf8") . "\"";
		$gazou = $news['Gazou'];
		// ほぼほぼデバッグ用
		if(unlink($gazou) == false) {
			print "画像の消去に失敗しました";
			print'<br><form action="newshennkou.php" method="POST">' .
				 '<input type="submit" value="戻る"><br></form>';
			exit();
		}
	}
			
	$query = "DELETE FROM news WHERE ID = " . $_POST['newsID'];
	$result = mysqli_query($link, $query);
	if ($result == false) {
		// クエリ失敗してる。不正な入力が入る感じではないのでプログラムのミスだと思われる
		print "クエリが不正です<br>";
		print "$query<br>";
		print'<br><form action="newshennkou.php" method="POST">' .
			 '<input type="submit" value="ニュース変更画面へ"><br></form>';
		exit();
	}	
			
	// 上手くいったハズなのでデータ削除しましたって出す
	// SELECTで確認作業入れても良いけどデバッグ用では？
	// 戻るボタンはphp外で入ってるのでスルー
	print "削除完了しました<BR>";
			
	// DB接続を閉じる
	mysqli_close($link);
			
?>


<form action="newshennkou.php" method="POST">
<input type="submit" value="ニュース変更画面に戻る"><br>
</form>

</div>

<br><br>