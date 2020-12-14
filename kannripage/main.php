<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ログインフォーム</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<!-- <link rel="stylesheet" href="base.css" type="text/css" media="screen" /> -->
<link rel="stylesheet" href="kannri.css" type="text/css" media="screen" />
</head>

<body>

<!-- ここから本文 -->

<div class ="konntenntuire">

<?php

	require_once "ninnsyou.php";
	$mode = Ninnsyoumode(); // 1ならクッキー、2ならセッション
	
	// ログインページに来ると自動的に起動するけど入力してない時は何もしない
	if((isset($_POST['Userid']) === true) && (isset($_POST['Userpass']) === true)) {
		if(Roguinnzyouhou($_POST['Userid'], $_POST['Userpass']) == true) {
			if ($mode == 1) {
				/*クッキーに覚えさせる*/
				$Cooketime = 60 * 30; // 30分
				//setcookie('Userid', $_POST['Userid'], time() + $Cooketime, '/homepage/');
				setcookie('Userid', $_POST['Userid'], time() + $Cooketime);
				setcookie('Userpass', $_POST['Userpass'], time() + $Cooketime);

				exit;
			} else if ($mode == 2) {
				// セッションに覚えさせる
				// セッション管理開始
				session_start();
				$_SESSION['Userid'] = $_POST['Userid'];  
				$_SESSION['Userpass'] = $_POST['Userpass'];  
			}
			//header('Location: http://web-sim.sub.jp/kannri.php'); // サーバ用
			//header('Location: http://localhost:81/homepage/kannri.php'); // 自分のPCでのデバッグ用
			header('Location: ./kannri.php');
			exit();
		} else {
			print "ID、パスワードが違います<br>";
		}
	}

?>

<h3>ログイン</h3>

<form action="main.php" method="POST">

<p>ID<br></p>
<input type="text" name="Userid"><br>
<p>PASSWORD<br></p>
<input type="text" name="Userpass"><br><br>
<input type="submit" value="送信"><br>

</form>

</div>

</body>
</html>