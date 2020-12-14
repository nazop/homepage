<?php
	function databasezyouhou() {
		/* $databasezyouhou[]を返す
		   [0]=MySQLサーバーのホスト名,[1]=MySQLでどのユーザー名でログインするか,[2]=そのユーザのパス,
		   [3]=接続するデータベース名
		   データベースに接続する時は
		   require "databasezyouhou.php";
		   $databasezyouhou = databasezyouhou();
		   $link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
		   で接続する
		   */
		   $databasezyouhou = array('localhost', 'user', 'pass', 'kumiai');
			return $databasezyouhou;		   
	}

?>