<?php
	function Masterninnsyou() {
		// マスターかどうかクッキーでの認証を行う。返り値falseなら失敗、trueなら成功
		// マスターかしか判定出来ないので後で変えよう……
		
		//$Userid = 'master'; // ID
		//$Userpass = 'test'; // PASSWORD
		// マスターIDでやる用
		$Master = Master();
		//print $Master[0] . " " . $Master[1];
		$Userid =$Master[0] ;
		$Userpass = $Master[1];
	
		// クッキーが無い場合どうなるかのデバッグ用
		//setcookie('Userid', 0, time() - 36000);
	
		if((isset($_COOKIE['Userid']) === true) && (isset($_COOKIE['Userpass']) === true)) {
			if(($Userid === $_COOKIE['Userid']) && ($Userpass === $_COOKIE['Userpass'])) {
				/*もしクッキーが存在していてそのクッキーが正しい場合*/
				return true;
			} else {
				/*クッキーに違う値が入ってるってどういう状況……？*/
				print"クッキーが間違っています<br>";
				print'<br><form action="main.php" method="POST">' .
				 '<input type="submit" value="戻る"><br></form>';
				return false;
			}
		} else {
			// クッキーが無い
			print "クッキーの有効期限が切れたかログインを行っていません。ログインし直して下さい<br>";
			print'<br><form action="main.php" method="POST">' .
				 '<input type="submit" value="戻る"><br></form>';
			return false;
		}
	}

	function Roguinnzyouhou($Userid, $Userpass) {
		// 与えられたユーザーIDとパスワードが登録されているかtrue、falseで返す
		// mysqlに接続する
		require_once "databasezyouhou.php";
		$databasezyouhou = databasezyouhou();
		$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
		if (!$link) {
 			die("接続失敗" . mysqli_error());
		}
		
		$query = "SELECT * FROM member WHERE Userid = \"" . $Userid . "\" AND Userpass = \"" . $Userpass . "\"";
		$result = mysqli_query($link, $query);
		//print "$query";
		$num_rows = mysqli_num_rows($result);
		if($num_rows == 0) {
			return false;
		} else {
			// 複数あるかも知れないのでひとまず0以外でほっとく
			// でもID一緒の奴が居る設定駄目だと思う
			return true;
		}

	}
	
	function Master() {
		// マスターIDとパスワードを纏めた奴。ただここに書いてるだけ
		$Masterid = 'master';
		$Masterpass = 'test';
		$Master = array();
		$Master[0] = $Masterid;
		$Master[1] = $Masterpass;
		return $Master;
	}
	
	function Cookieninnsyou() {
	
		if((isset($_COOKIE['Userid']) === true) && (isset($_COOKIE['Userpass']) === true)) {
			if(Roguinnzyouhou($_COOKIE['Userid'], $_COOKIE['Userpass']) == true) {
				/*もしクッキーが存在していてそのクッキーが正しい場合*/
				return true;
			} else {
				/*クッキーに違う値が入ってるってどういう状況……？*/
				print"クッキーが間違っています<br>";
				print'<br><form action="main.php" method="POST">' .
				 '<input type="submit" value="戻る"><br></form>';
				return false;
			}
		} else {
			// クッキーが無い
			print "クッキーの有効期限が切れたかログインを行っていません。ログインし直して下さい<br>";
			print'<br><form action="main.php" method="POST">' .
				 '<input type="submit" value="戻る"><br></form>';
			return false;
		}
	
	}
	
	function Ninnsyoumode() {
		$mode = 2; // 1ならクッキー、2ならセッション
		return $mode;
	}
	
	function ninnsyou() {
		// 認証方法切り替え
		// main.phpも変える必要がある……
		$mode = Ninnsyoumode();
		if ($mode == 1) {
			return Cookieninnsyou();
		} else if ($mode == 2) {
			return Sessionninnsyou();
		}
	
	}
	
	function Sessionninnsyou() {
		// セッション管理開始
		session_start();
		if ((isset($_SESSION['Userid']) === true) && (isset($_SESSION['Userpass']) === true)) { 
			// セッション情報がある
			if(Roguinnzyouhou($_SESSION['Userid'], $_SESSION['Userpass']) == true) {
				/*もしセッション情報が存在していてそれが正しい場合*/
				return true;
			} else {
				/*違う値が入ってるってどういう状況……？*/
				print"セッション情報が間違っています<br>";
				print'<br><form action="main.php" method="POST">' .
				 '<input type="submit" value="戻る"><br></form>';
				return false;
			}
		} else {
			// セッションが無い
			print "セッションの有効期限が切れたかログインを行っていません。ログインし直して下さい<br>";
			print'<br><form action="main.php" method="POST">' .
				 '<input type="submit" value="戻る"><br></form>';
			return false;
		}
	}

?>
