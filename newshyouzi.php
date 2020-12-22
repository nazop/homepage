<?php
	// newsを表示する関数
	// $hennkouは0:ニュース表示、1:変更・削除ボタンを出す
	// $pageadは呼び出すphp自身のアドレス(こいつからだと"newshyouzi")を入力。それによってページ移動する時のアドレスを指定する
	function newshyouzi($hennkou, $pagead) {
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
			$query = "SELECT * FROM news ORDER BY ID DESC"; // 降順			
			$result = mysqli_query($link, $query);
			$num_rows   = mysqli_num_rows( $result );

			if(($num_rows == 0) && ($hennkou == 1)) {
				print "データがありません";
				print'<br><form action="newskannri.php" method="POST">' .
			 		'<input type="submit" value="戻る"><br></form>';
				exit();
			}
			
			// 最大ページ数を弾き出す。0からなので$num_rows - 1
			$maxPage = intval(($num_rows - 1) / $hyouzisuu);
			print ($page + 1) . '/' . ($maxPage + 1) . 'ページ目<br>';

			// 	二次元配列に突っ込む
			$news = array();
			for ($i = 0; $i < $num_rows; $i++) {
				$news[$i] = mysqli_fetch_array($result);
			}
			
			// このページで何個目までニュース表示するか。sqlの最後か表示数制限に引っかかるまでか
			$lastNews = min($num_rows, (($page + 1) * $hyouzisuu));
			
			// ニュースをhtml形式で吐き出す
			for ($i = $page * $hyouzisuu; $i < $lastNews; $i++) {
				print '<div class="news">';
				print '<div class="hiduketaitoru"><span class="newshiduke">';
				print $news[$i]['Nenn'] . "/";
				print $news[$i]['Tuki'] . "/";
				print $news[$i]['Hi'];
				print '</span><span class="newstitle"> ' . mb_convert_encoding($news[$i]['Taitoru'], "utf8");
				//print '<input type="submit" value="' . $news[$i]['Taitoru'] . '"><br></form>';
				if ($hennkou == 1) {
					print '<span class="botann">';
					print '<form action = "newshennkounaiyou.php" method="POST" class ="hennkoubotann">';
					print '<input type="hidden" name="newsID" value="'. $news[$i]['ID'] . '">';
					print '<input type="submit" value="変更"></form>';
					print '<form action = "newssakuzyo.php" method="POST" class ="sakuzyobotann">';
					print '<input type="hidden" name="newsID" value="'. $news[$i]['ID'] . '">';
					print '<input type="submit" value="削除"><br></form>';
					print '</span>';
				}
				print "</div>";
				print '<p class ="newshonnbunn">'.mb_convert_encoding($news[$i]['Honnbunn'], "utf8") . "</p>";
				print '<br>';
				if($news[$i]['Gazou'] != null) {
					$newsGazouName = mb_substr($news[$i]['Gazou'], 1);
					print '<img border="0" src="'. $newsGazouName .'" alt="ニュース画像">';
					print "<br><br>";
				}
				print "</div>";
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