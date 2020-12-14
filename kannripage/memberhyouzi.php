<?php
	// メンバーを表示する関数
	// $pageadはこの関数を呼び出すphp自身のアドレス(こいつからだと"newshyouzi")を入力。それによってページ移動する時のアドレスを指定する
	function memberhyouzi($pagead) {
			//print"$pagead"; // デバッグ用
			// 1ページの表示数
			$hyouzisuu = 5;
	
			// mysqlに接続する
			require_once "databasezyouhou.php";
			$databasezyouhou = databasezyouhou();
			$link = mysqli_connect($databasezyouhou[0],  $databasezyouhou[1],  $databasezyouhou[2],  $databasezyouhou[3]);
			if (!$link) {
 			   die("接続失敗" . mysqli_error());
			}
			
			// 今のページ数を設定
			if (isset($_POST['page']) == true) {
				$page = $_POST['page'];
			} else {
				$page = 0;
			}
			
			// 何個入ってるか分からないので全部取って来てしまっているが関数ありそう
			$query = "SELECT * FROM member ORDER BY ID DESC"; // 降順			
			$result = mysqli_query($link, $query);
			$num_rows   = mysqli_num_rows( $result );

			if($num_rows == 0) {
				print "データがありません";
				print'<br><form action="memberkannri.php" method="POST">' .
			 		'<input type="submit" value="戻る"><br></form>';
				exit();
			}
			
			// 最大ページ数を弾き出す。0からなので$num_rows - 1
			$maxPage = intval(($num_rows - 1) / $hyouzisuu);
			print ($page + 1) . '/' . ($maxPage + 1) . 'ページ目<br>';

			// 	二次元配列に突っ込む
			$member = array();
			for ($i = 0; $i < $num_rows; $i++) {
				$member[$i] = mysqli_fetch_array($result);
			}
			
			// このページで何個目まで表示するか。sqlの最後か表示数制限に引っかかるまでか
			$lastmember = min($num_rows, (($page + 1) * $hyouzisuu));
			
			// メンバーをhtml形式で吐き出す
			for ($i = $page * $hyouzisuu; $i < $lastmember; $i++) {

				/* ユーザーID・パスワード・名前・ふりがな・電話・備考欄表示
				  ユーザーiD : user パスワード: pass
				  名前(ふりがな)
				  電話番号:000-0000-0000 には今の所なってない
				  備考欄
				  */
				print '<div class="member">';
				print '<div class="user"><span class="id">ユーザーID:' . $member[$i]['Userid'];
				print '</span><span class="pass">パスワード:' . $member[$i]['Userpass'];
				print '</span>';
				// 変更・削除ボタン
				print '<div class="botann">';
				print '<form action = "memberhennkounaiyou.php" method="POST" class="hennkoubotann">';
				print '<input type="hidden" name="ID" value="'. $member[$i]['ID'] . '">';
				print '<input type="submit" value="変更"></form>';
				print '<form action = "membersakuzyo.php" method="POST" class="sakuzyobotann">';
				print '<input type="hidden" name="ID" value="'. $member[$i]['ID'] . '">';
				print '<input type="submit" value="削除"></form>';
				print '</div></div>'; 
				// 名前、電話
				print '<p class="namae">' . $member[$i]['Namae'] . '(' . $member[$i]['Hurigana'] . ')</p>';
				if ($member[$i]['Dennwa'] != null) {
					print '<p class="dennwa">電話番号:' . $member[$i]['Dennwa'] . '</p>';
				}
				// 備考欄
				if ($member[$i]['Bikou'] != null) {
					print '<p class="bikou">' . $member[$i]['Bikou'] . '</p>';
				}
				print '</div>';

			}

			
			// ページ番号とか次ページ・前ページボタンとか
			//print '<div>';
			if ($page > 0) {
				print '<form action="'. $pagead .'.php" method="POST">';
				print '<input type="hidden" name="page" value="' . ($page - 1) . '">';
				print '<input type="submit" value="前ページ"></form><br>';
			}
			if ($page < $maxPage) {
				print '<form action="'. $pagead .'.php" method="POST">';
				print '<input type="hidden" name="page" value="' . ($page + 1) . '">';
				print '<input type="submit" value="次ページ"></form><br>';
			}
			//print '</div>';

			// DB接続を閉じる
			mysqli_close($link);
		
	}

?>