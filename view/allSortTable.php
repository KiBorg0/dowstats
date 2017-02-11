<?
	require_once("../lib/steam.php");
	require_once("../lib/NickDecode.php");
    require_once("../lib/RaceSwitcher.php");

	$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
	if(isset($_GET['allSort'])) {
		header("Content-type: text/txt; charset=UTF-8");
		if($_GET['allSort']=='name') {

			echo '<thead><tr>
			<td>номер</td>
            <td>аватар</td>
            <td><a href = "javascript: SortAllStatByName();">игрок &#8595;</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">всего игр</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">побед</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">% побед</td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">апм</td>
            <td><a href = "javascript: SortAllStatByFavRace();">любимая раса</td>
            <td><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;время</td>		
            </tr>
            </thead>
            ';
            $pname = NickDecode::codeNick($_GET['playername']);
	    	// $pname = isset($_GET['playername']) ? NickDecode::codeNick($_GET['playername']) : 'ERRORNAME';

	    	echo $pname;
		    $mysqli->real_query("SELECT * FROM players WHERE name LIKE '%$pname%' ORDER BY name ASC ");       
			$res = $mysqli->use_result();
			$i = 1;
	        while ($row = $res->fetch_assoc()) {

				echo "<tr>";
				echo "<td>". $i ."</td>";
				echo "<td>";
				echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
				echo "</td>";
				echo "<td>";
				echo "<a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>"//ссылка на профиль
				 .NickDecode::decodeNick($row['name']) . "</a></td>";
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;

				$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
				$win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
				$win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
				$win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
				$win = $win1x1 + $win2x2 + $win3x3 + $win4x4;

				echo "<td>" . $all . "</td>";
				echo "<td>" . $win . "</td>";
				if($all!= 0){
					echo "<td>" . round(100 * $win/$all) . "%</td>";
				}else{
					echo "<td>" . 0 . "</td>";
				};
				echo "<td>" . $row['apm'] . "</td>";


				$favRace = 0;
				$countWinRace = 0;
				if($countWinRace <  $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1']){
					$favRace = 1;
					$countWinRace = $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1'];
				}
				if($countWinRace <  $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2']){
					$favRace = 2;
					$countWinRace = $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2'];
				}
				if($countWinRace <  $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3']){
					$favRace = 3;
					$countWinRace = $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3'];
				}
				if($countWinRace <  $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4']){
					$favRace = 4;
					$countWinRace = $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4'];
				}
				if($countWinRace <  $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5']){
					$favRace = 5;
					$countWinRace = $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5'];
				}
				if($countWinRace <  $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6']){
					$favRace = 6;
					$countWinRace = $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6'];
				}
				if($countWinRace <  $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7']){
					$favRace = 7;
					$countWinRace = $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7'];
				}
				if($countWinRace <  $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8']){
					$favRace = 8;
					$countWinRace = $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8'];
				}
				if($countWinRace <  $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9']){
					$favRace = 9;
					$countWinRace = $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9'];
				}
				echo "<td>" . RaceSwitcher::getRace($favRace) . "</td>";
				$timehelpint = $row['time'] / 60;
				$timehours = floor($timehelpint / 60);
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;
				if($all != 0){
					$allGamesTime =  intval($row['time'] / $all);
				}else{
					$allGamesTime = 0;
				}
				$timehelpint = floor($allGamesTime / 60);
				echo "<td>" . $timehelpint  .  " м.   " . $allGamesTime % 60 . " с. </td>";
				echo "</tr>";
				$i += 1;
			}
		}

		if($_GET['allSort']=='games') {
			echo '<thead><tr>
			<td>номер</td>
            <td>аватар</td>
            <td><a href = "javascript: SortAllStatByName();">игрок</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">всего игр &#8595;</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">побед</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">% побед</td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">апм</td>
            <td><a href = "javascript: SortAllStatByFavRace();">любимая раса</td>
            <td><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;время</td>	
            </tr>
            </thead>
            ';
            $array = array();  
            $int = 0;

		    $mysqli->real_query("SELECT * FROM players ");        
			$res = $mysqli->use_result();
	        while ($row = $res->fetch_assoc()) {
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;

				$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
				$win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
				$win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
				$win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
				$win = $win1x1 + $win2x2 + $win3x3 + $win4x4;

				$row['all'] = $all ;
				$row['win'] = $win ;

				if($all!= 0){
					$row['percent'] =  round(100 * $win/$all);
				}else{
					$row['percent'] = 0 ;
				};


				$favRace = 0;
				$countWinRace = 0;
				if($countWinRace <  $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1']){
					$favRace = 1;
					$countWinRace = $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1'];
				}
				if($countWinRace <  $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2']){
					$favRace = 2;
					$countWinRace = $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2'];
				}
				if($countWinRace <  $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3']){
					$favRace = 3;
					$countWinRace = $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3'];
				}
				if($countWinRace <  $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4']){
					$favRace = 4;
					$countWinRace = $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4'];
				}
				if($countWinRace <  $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5']){
					$favRace = 5;
					$countWinRace = $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5'];
				}
				if($countWinRace <  $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6']){
					$favRace = 6;
					$countWinRace = $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6'];
				}
				if($countWinRace <  $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7']){
					$favRace = 7;
					$countWinRace = $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7'];
				}
				if($countWinRace <  $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8']){
					$favRace = 8;
					$countWinRace = $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8'];
				}
				if($countWinRace <  $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9']){
					$favRace = 9;
					$countWinRace = $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9'];
				}
				$row['favRace'] =  $favRace ;
				$timehelpint = $row['time'] / 60;
				$timehours = floor($timehelpint / 60);
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;
				if($all != 0){
					$allGamesTime =  intval($row['time'] / $all);
				}else{
					$allGamesTime = 0;
				}
				$row['allGamesTime'] =  $allGamesTime ;
				$array[$int] = $row;
                $int = $int + 1;
				
			}

			//---------------СОРТИРОВКА----------
			 for($j = 0; $j < sizeof($array)-1;$j++)
            {
                for($i = 0; $i < sizeof($array) - $j - 1;$i++)
                {
                    if ($array[$i]['all'] > $array[$i+1]['all']) {
                     $b = $array[$i]; //change for elements
                     $array[$i] = $array[$i+1];
                     $array[$i+1] = $b;
                    }
                }
            }

			
			$i = 1;
            //------------ВЫВОД-------------
            for($j = sizeof($array)-1; $j >= 0;$j--)
            {   
                echo "<tr>";
                echo "<td>". $i ."</td>";
                echo "<td>";
				echo "<img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'>";
				echo "</td>";
				echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $array[$j]['name'] ."'>" .NickDecode::decodeNick($array[$j]['name']) . "</a></td>";
                 echo "<td>". $array[$j]['all'] . "</td>";
                 echo "<td>". $array[$j]['win'] . "</td>";
                 echo "<td>". $array[$j]['percent'] . "%</td>";
                 echo "<td>". $array[$j]['apm'] . "</td>";
                 echo "<td>" . RaceSwitcher::getRace($array[$j]['favRace']) . "</td>";
                $timehelpint = floor($array[$j]['allGamesTime'] / 60);
				echo "<td>" . $timehelpint  .  " м.   " . $array[$j]['allGamesTime'] % 60 . " с. </td>";
				echo "</tr>";
                    echo "</tr>";
                $i++;
            }


		}


		if($_GET['allSort']=='win') {
			echo '<thead><tr>
			<td>номер</td>
            <td>аватар</td>
            <td><a href = "javascript: SortAllStatByName();">игрок</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">всего игр</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">побед &#8595;</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">% побед</td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">апм</td>
            <td><a href = "javascript: SortAllStatByFavRace();">любимая раса</td>
            <td><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;время</td>			
            
            </tr>
            </thead>
            ';
            $array = array();  
            $int = 0;

		    $mysqli->real_query("SELECT * FROM players ");        
			$res = $mysqli->use_result();
	        while ($row = $res->fetch_assoc()) {
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;

				$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
				$win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
				$win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
				$win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
				$win = $win1x1 + $win2x2 + $win3x3 + $win4x4;

				$row['all'] = $all ;
				$row['win'] = $win ;

				if($all!= 0){
					$row['percent'] =  round(100 * $win/$all);
				}else{
					$row['percent'] = 0 ;
				};


				$favRace = 0;
				$countWinRace = 0;
				if($countWinRace <  $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1']){
					$favRace = 1;
					$countWinRace = $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1'];
				}
				if($countWinRace <  $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2']){
					$favRace = 2;
					$countWinRace = $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2'];
				}
				if($countWinRace <  $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3']){
					$favRace = 3;
					$countWinRace = $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3'];
				}
				if($countWinRace <  $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4']){
					$favRace = 4;
					$countWinRace = $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4'];
				}
				if($countWinRace <  $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5']){
					$favRace = 5;
					$countWinRace = $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5'];
				}
				if($countWinRace <  $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6']){
					$favRace = 6;
					$countWinRace = $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6'];
				}
				if($countWinRace <  $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7']){
					$favRace = 7;
					$countWinRace = $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7'];
				}
				if($countWinRace <  $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8']){
					$favRace = 8;
					$countWinRace = $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8'];
				}
				if($countWinRace <  $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9']){
					$favRace = 9;
					$countWinRace = $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9'];
				}
				$row['favRace'] =  $favRace ;
				$timehelpint = $row['time'] / 60;
				$timehours = floor($timehelpint / 60);
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;
				if($all != 0){
					$allGamesTime =  intval($row['time'] / $all);
				}else{
					$allGamesTime = 0;
				}
				$row['allGamesTime'] =  $allGamesTime ;
				$array[$int] = $row;
                $int = $int + 1;
				
			}

			//---------------СОРТИРОВКА----------
			 for($j = 0; $j <= sizeof($array)-1;$j++)
            {
                for($i = 0; $i < sizeof($array) - $j - 1;$i++)
                {
                    if ($array[$i]['win'] > $array[$i+1]['win']) {
                     $b = $array[$i]; //change for elements
                     $array[$i] = $array[$i+1];
                     $array[$i+1] = $b;
                    }
                }
            }

        	$i = 1;
            //------------ВЫВОД-------------
            for($j = sizeof($array)-1; $j >= 0;$j--)
            {   
                echo "<tr>";
                echo "<td>". $i ."</td>";
                echo "<td>";
				echo "<img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'>";
				echo "</td>";
				echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $array[$j]['name'] ."'>" .NickDecode::decodeNick($array[$j]['name']) . "</a></td>";
                 echo "<td>". $array[$j]['all'] . "</td>";
                 echo "<td>". $array[$j]['win'] . "</td>";
                 echo "<td>". $array[$j]['percent'] . "%</td>";
                 echo "<td>". $array[$j]['apm'] . "</td>";
                 echo "<td>" . RaceSwitcher::getRace($array[$j]['favRace']) . "</td>";
                $timehelpint = floor($array[$j]['allGamesTime'] / 60);
				echo "<td>" . $timehelpint  .  " м.   " . $array[$j]['allGamesTime'] % 60 . " с. </td>";
				echo "</tr>";
                    echo "</tr>";
                $i++;
            }


		}


		if($_GET['allSort']=='percent') {
			echo '<thead><tr>
			<td>номер</td>
            <td>аватар</td>
            <td><a href = "javascript: SortAllStatByName();">игрок</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">всего игр</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">побед</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">% побед &#8595;</td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">апм</td>
            <td><a href = "javascript: SortAllStatByFavRace();">любимая раса</td>
            <td><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;время</td>	
            
            </tr>
            </thead>
            ';
            $array = array();  
            $int = 0;

		    $mysqli->real_query("SELECT * FROM players ");        
			$res = $mysqli->use_result();
	        while ($row = $res->fetch_assoc()) {
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;

				$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
				$win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
				$win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
				$win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
				$win = $win1x1 + $win2x2 + $win3x3 + $win4x4;

				$row['all'] = $all ;
				$row['win'] = $win ;

				if($all!= 0){
					$row['percent'] =  round(100 * $win/$all);
				}else{
					$row['percent'] = 0 ;
				};


				$favRace = 0;
				$countWinRace = 0;
				if($countWinRace <  $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1']){
					$favRace = 1;
					$countWinRace = $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1'];
				}
				if($countWinRace <  $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2']){
					$favRace = 2;
					$countWinRace = $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2'];
				}
				if($countWinRace <  $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3']){
					$favRace = 3;
					$countWinRace = $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3'];
				}
				if($countWinRace <  $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4']){
					$favRace = 4;
					$countWinRace = $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4'];
				}
				if($countWinRace <  $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5']){
					$favRace = 5;
					$countWinRace = $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5'];
				}
				if($countWinRace <  $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6']){
					$favRace = 6;
					$countWinRace = $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6'];
				}
				if($countWinRace <  $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7']){
					$favRace = 7;
					$countWinRace = $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7'];
				}
				if($countWinRace <  $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8']){
					$favRace = 8;
					$countWinRace = $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8'];
				}
				if($countWinRace <  $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9']){
					$favRace = 9;
					$countWinRace = $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9'];
				}
				$row['favRace'] =  $favRace ;
				$timehelpint = $row['time'] / 60;
				$timehours = floor($timehelpint / 60);
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;
				if($all != 0){
					$allGamesTime =  intval($row['time'] / $all);
				}else{
					$allGamesTime = 0;
				}
				$row['allGamesTime'] =  $allGamesTime ;
				$array[$int] = $row;
                $int = $int + 1;
				
			}

			//---------------СОРТИРОВКА----------
			 for($j = 0; $j < sizeof($array)-1;$j++)
            {
                for($i = 0; $i < sizeof($array) - $j - 1;$i++)
                {
                    if ($array[$i]['percent'] > $array[$i+1]['percent']) {
                     $b = $array[$i]; //change for elements
                     $array[$i] = $array[$i+1];
                     $array[$i+1] = $b;
                    }
                }
            }

        	$i=1;
            //------------ВЫВОД-------------
            for($j = sizeof($array)-1; $j >= 0;$j--)
            {   
                echo "<tr>";
                echo "<td>". $i ."</td>";
                echo "<td>";
				echo "<img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'>";
				echo "</td>";
				echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $array[$j]['name'] ."'>" .NickDecode::decodeNick($array[$j]['name']) . "</a></td>";
                 echo "<td>". $array[$j]['all'] . "</td>";
                 echo "<td>". $array[$j]['win'] . "</td>";
                 echo "<td>". $array[$j]['percent'] . "%</td>";
                 echo "<td>". $array[$j]['apm'] . "</td>";
                 echo "<td>" . RaceSwitcher::getRace($array[$j]['favRace']) . "</td>";
                $timehelpint = floor($array[$j]['allGamesTime'] / 60);
				echo "<td>" . $timehelpint  .  " м.   " . $array[$j]['allGamesTime'] % 60 . " с. </td>";
				echo "</tr>";
                    echo "</tr>";
                $i++;
            }


		}


		if($_GET['allSort']=='apm') {
			echo '<thead><tr>
            <td>номер</td>
            <td>аватар</td><td><a href = "javascript: SortAllStatByName();">игрок</a></td><td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">всего игр</a></td><td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">побед</a></td><td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">% побед</td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">апм&nbsp;&#8595;</td>
            <td><a href = "javascript: SortAllStatByFavRace();">любимая раса</td><td><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;время</td>			
            
            </tr>
            </thead>
            ';
            $array = array();  
            $int = 0;

		    $mysqli->real_query("SELECT * FROM players ");        
			$res = $mysqli->use_result();
	        while ($row = $res->fetch_assoc()) {
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;

				$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
				$win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
				$win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
				$win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
				$win = $win1x1 + $win2x2 + $win3x3 + $win4x4;

				$row['all'] = $all ;
				$row['win'] = $win ;

				if($all!= 0){
					$row['percent'] =  round(100 * $win/$all);
				}else{
					$row['percent'] = 0 ;
				};


				$favRace = 0;
				$countWinRace = 0;
				if($countWinRace <  $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1']){
					$favRace = 1;
					$countWinRace = $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1'];
				}
				if($countWinRace <  $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2']){
					$favRace = 2;
					$countWinRace = $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2'];
				}
				if($countWinRace <  $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3']){
					$favRace = 3;
					$countWinRace = $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3'];
				}
				if($countWinRace <  $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4']){
					$favRace = 4;
					$countWinRace = $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4'];
				}
				if($countWinRace <  $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5']){
					$favRace = 5;
					$countWinRace = $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5'];
				}
				if($countWinRace <  $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6']){
					$favRace = 6;
					$countWinRace = $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6'];
				}
				if($countWinRace <  $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7']){
					$favRace = 7;
					$countWinRace = $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7'];
				}
				if($countWinRace <  $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8']){
					$favRace = 8;
					$countWinRace = $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8'];
				}
				if($countWinRace <  $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9']){
					$favRace = 9;
					$countWinRace = $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9'];
				}
				$row['favRace'] =  $favRace ;
				$timehelpint = $row['time'] / 60;
				$timehours = floor($timehelpint / 60);
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;
				if($all != 0){
					$allGamesTime =  intval($row['time'] / $all);
				}else{
					$allGamesTime = 0;
				}
				$row['allGamesTime'] =  $allGamesTime ;
				$array[$int] = $row;
                $int = $int + 1;
				
			}

			//---------------СОРТИРОВКА----------
			 for($j = 0; $j < sizeof($array)-1;$j++)
            {
                for($i = 0; $i < sizeof($array) - $j - 1;$i++)
                {
                    if ($array[$i]['apm'] > $array[$i+1]['apm']) {
                     $b = $array[$i]; //change for elements
                     $array[$i] = $array[$i+1];
                     $array[$i+1] = $b;
                    }
                }
            }

        	$i=1;
            //------------ВЫВОД-------------
            for($j = sizeof($array)-1; $j >= 0;$j--)
            {   
                echo "<tr>";
                echo "<td>". $i ."</td>";
                echo "<td>";
				echo "<img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'>";
				echo "</td>";
				echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $array[$j]['name'] ."'>" .NickDecode::decodeNick($array[$j]['name']) . "</a></td>";
                 echo "<td>". $array[$j]['all'] . "</td>";
                 echo "<td>". $array[$j]['win'] . "</td>";
                 echo "<td>". $array[$j]['percent'] . "%</td>";
                 echo "<td>". $array[$j]['apm'] . "</td>";
                 echo "<td>" . RaceSwitcher::getRace($array[$j]['favRace']) . "</td>";
                $timehelpint = floor($array[$j]['allGamesTime'] / 60);
				echo "<td>" . $timehelpint  .  " м.   " . $array[$j]['allGamesTime'] % 60 . " с. </td>";
				echo "</tr>";
                    echo "</tr>";
                $i++;
            }


		}


		if($_GET['allSort']=='favRace') {
			echo '<thead><tr>
			<td>номер</td>
            <td>аватар</td>
            <td><a href = "javascript: SortAllStatByName();">игрок</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">всего игр</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">побед</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">% побед</td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">апм</td>
            <td><a href = "javascript: SortAllStatByFavRace();">любимая раса &#8595;</td>
            <td><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;время</td>			
            </tr>
            </thead>
            ';
            $array = array();  
            $int = 0;

		    $mysqli->real_query("SELECT * FROM players ");        
			$res = $mysqli->use_result();
	        while ($row = $res->fetch_assoc()) {
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;

				$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
				$win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
				$win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
				$win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
				$win = $win1x1 + $win2x2 + $win3x3 + $win4x4;

				$row['all'] = $all ;
				$row['win'] = $win ;

				if($all!= 0){
					$row['percent'] =  round(100 * $win/$all);
				}else{
					$row['percent'] = 0 ;
				};


				$favRace = 0;
				$countWinRace = 0;
				if($countWinRace <  $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1']){
					$favRace = 1;
					$countWinRace = $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1'];
				}
				if($countWinRace <  $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2']){
					$favRace = 2;
					$countWinRace = $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2'];
				}
				if($countWinRace <  $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3']){
					$favRace = 3;
					$countWinRace = $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3'];
				}
				if($countWinRace <  $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4']){
					$favRace = 4;
					$countWinRace = $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4'];
				}
				if($countWinRace <  $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5']){
					$favRace = 5;
					$countWinRace = $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5'];
				}
				if($countWinRace <  $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6']){
					$favRace = 6;
					$countWinRace = $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6'];
				}
				if($countWinRace <  $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7']){
					$favRace = 7;
					$countWinRace = $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7'];
				}
				if($countWinRace <  $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8']){
					$favRace = 8;
					$countWinRace = $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8'];
				}
				if($countWinRace <  $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9']){
					$favRace = 9;
					$countWinRace = $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9'];
				}
				$row['favRace'] =  $favRace ;
				$timehelpint = $row['time'] / 60;
				$timehours = floor($timehelpint / 60);
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;
				if($all != 0){
					$allGamesTime =  intval($row['time'] / $all);
				}else{
					$allGamesTime = 0;
				}
				$row['allGamesTime'] =  $allGamesTime ;
				$array[$int] = $row;
                $int = $int + 1;
				
			}

			//---------------СОРТИРОВКА----------
			 for($j = 0; $j < sizeof($array)-1;$j++)
            {
                for($i = 0; $i < sizeof($array) - $j - 1;$i++)
                {
                    if ($array[$i]['favRace'] > $array[$i+1]['favRace']) {
                     $b = $array[$i]; //change for elements
                     $array[$i] = $array[$i+1];
                     $array[$i+1] = $b;
                    }
                }
            }

            $i=1;
            //------------ВЫВОД-------------
            for($j = sizeof($array)-1; $j >= 0;$j--)
            {   
                echo "<tr>";
                echo "<td>". $i ."</td>";
                echo "<td>";
				echo "<img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'>";
				echo "</td>";
				echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $array[$j]['name'] ."'>" .NickDecode::decodeNick($array[$j]['name']) . "</a></td>";
                 echo "<td>". $array[$j]['all'] . "</td>";
                 echo "<td>". $array[$j]['win'] . "</td>";
                 echo "<td>". $array[$j]['percent'] . "%</td>";
                 echo "<td>". $array[$j]['apm'] . "</td>";
                 echo "<td>" . RaceSwitcher::getRace($array[$j]['favRace']) . "</td>";
                $timehelpint = floor($array[$j]['allGamesTime'] / 60);
				echo "<td>" . $timehelpint  .  " м.   " . $array[$j]['allGamesTime'] % 60 . " с. </td>";
				echo "</tr>";
                    echo "</tr>";
                $i++;
            }


		}


		if($_GET['allSort']=='allGamesTime') {
			echo '<thead><tr>
			<td>номер</td>
            <td>аватар</td>
            <td><a href = "javascript: SortAllStatByName();">игрок</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">всего игр</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">побед</a></td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">% побед</td>
            <td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">апм</td>
            <td><a href = "javascript: SortAllStatByFavRace();">любимая раса</td>
            <td><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;время &#8595;</td>			
            </tr>
            </thead>
            ';
            $array = array();  
            $int = 0;

		    $mysqli->real_query("SELECT * FROM players ");        
			$res = $mysqli->use_result();
	        while ($row = $res->fetch_assoc()) {
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;

				$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
				$win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
				$win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
				$win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
				$win = $win1x1 + $win2x2 + $win3x3 + $win4x4;

				$row['all'] = $all ;
				$row['win'] = $win ;

				if($all!= 0){
					$row['percent'] =  round(100 * $win/$all);
				}else{
					$row['percent'] = 0 ;
				};


				$favRace = 0;
				$countWinRace = 0;
				if($countWinRace <  $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1']){
					$favRace = 1;
					$countWinRace = $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1'];
				}
				if($countWinRace <  $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2']){
					$favRace = 2;
					$countWinRace = $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2'];
				}
				if($countWinRace <  $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3']){
					$favRace = 3;
					$countWinRace = $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3'];
				}
				if($countWinRace <  $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4']){
					$favRace = 4;
					$countWinRace = $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4'];
				}
				if($countWinRace <  $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5']){
					$favRace = 5;
					$countWinRace = $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5'];
				}
				if($countWinRace <  $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6']){
					$favRace = 6;
					$countWinRace = $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6'];
				}
				if($countWinRace <  $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7']){
					$favRace = 7;
					$countWinRace = $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7'];
				}
				if($countWinRace <  $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8']){
					$favRace = 8;
					$countWinRace = $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8'];
				}
				if($countWinRace <  $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9']){
					$favRace = 9;
					$countWinRace = $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9'];
				}
				$row['favRace'] =  $favRace ;
				$timehelpint = $row['time'] / 60;
				$timehours = floor($timehelpint / 60);
				$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
				$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
				$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
				$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
				$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;
				if($all != 0){
					$allGamesTime =  intval($row['time'] / $all);
				}else{
					$allGamesTime = 0;
				}
				$row['allGamesTime'] =  $allGamesTime ;
				$array[$int] = $row;
                $int = $int + 1;
				
			}

			//---------------СОРТИРОВКА----------
			 for($j = 0; $j < sizeof($array)-1;$j++)
            {
                for($i = 0; $i < sizeof($array) - $j - 1;$i++)
                {
                    if ($array[$i]['allGamesTime'] > $array[$i+1]['allGamesTime']) {
                     $b = $array[$i]; //change for elements
                     $array[$i] = $array[$i+1];
                     $array[$i+1] = $b;
                    }
                }
            }

            $i=1;
            //------------ВЫВОД-------------
            for($j = sizeof($array)-1; $j >= 0;$j--)
            {   
                echo "<tr>";
                echo "<td>". $i ."</td>";
                echo "<td>";
				echo "<img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'>";
				echo "</td>";
				echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $array[$j]['name'] ."'>" . NickDecode::decodeNick($array[$j]['name']) . "</a></td>";
                 echo "<td>". $array[$j]['all'] . "</td>";
                 echo "<td>". $array[$j]['win'] . "</td>";
                 echo "<td>". $array[$j]['percent'] . "%</td>";
                 echo "<td>". $array[$j]['apm'] . "</td>";
                 echo "<td>" . RaceSwitcher::getRace($array[$j]['favRace']) . "</td>";
                $timehelpint = floor($array[$j]['allGamesTime'] / 60);
				echo "<td>" . $timehelpint  .  " м.   " . $array[$j]['allGamesTime'] % 60 . " с. </td>";
				echo "</tr>";
                    echo "</tr>";
                $i++;
            }


		}


	}
?>