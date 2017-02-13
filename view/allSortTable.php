<?
	require_once("../lib/steam.php");
	require_once("../lib/NickDecode.php");
    require_once("../lib/RaceSwitcher.php");

    $sort = array('name' 		 => 0,
			      'games' 		 => 1,
			      'win' 		 => 2,
			      'percent' 	 => 3,
			      'apm' 		 => 4,
			      'favRace' 	 => 5,
			      'allGamesTime' => 6, );
	

	$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
	$lang = $_GET['lang'];
	if(isset($_GET['allSort'])) {
		//---------------ВЫВОД ЗАГОЛОВКА ТАБЛИЦЫ----------
		$sort_type = $sort[$_GET['allSort']];
        $tabel_header = array();
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByName();">'._('player');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">'._('count of games');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">'._('wins');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">'._('win ratio');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">'._('apm');
		$tabel_header[] = '<td style = "width:15%;"><a href = "javascript: SortAllStatByFavRace();">'._('favorite race');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;'._('time');
		$result_header = "";
		for($i=0; $i<7;$i++)
			if($i==$sort_type) $result_header .= $tabel_header[$i]." &#8595;</a></td>";
			else $result_header .= $tabel_header[$i]."</a></td>";

		echo '<thead><tr>
		<td style = "width:5%;">'._('number').'</td>
        <td style = "width:10%;">'._('avatar').'</td>'
        .$result_header.
        '</tr>
        </thead>';
        //---------------ПОДГОТОВКА ДАННЫХ ДЛЯ ТАБЛИЦЫ----------
        $array = array();  
        $int = 0;
		if($_GET['allSort']=='name') {
        	$pname = isset($_GET['playername'])?NickDecode::codeNick($_GET['playername']):"";
	    	$mysqli->real_query("SELECT * FROM players WHERE name LIKE '%$pname%' ORDER BY name DESC ");
		}
		else
			$mysqli->real_query("SELECT * FROM players ");     
	       
		$res = $mysqli->use_result();
        while ($row = $res->fetch_assoc()) {
			$all = 0;
			$win = 0;
			for($i=1;$i<=4;$i++)
				for($j=1;$j<=9;$j++)
				{
					$win += $row[$i.'x'.$i.'_'.$j.'w'];
					$all += $row[$i.'x'.$i.'_'.$j]; 
				}
			$favRace = 0;
			$countWinRace = 0;
            for($i=1; $i<=9; $i++)
            {
                $sum = $row['1x1_'.$i]+$row['2x2_'.$i]+$row['3x3_'.$i]+$row['4x4_'.$i];
	            if($countWinRace<$sum)
                {
                    $favRace = $i;
                    $countWinRace = $sum;
                }
        	}
			$row['all'] = $all ;
			$row['win'] = $win ;
			$row['percent'] = ($all!= 0)?round(100 * $win/$all):0;
			$row['favRace'] =  $favRace ;
			$row['allGamesTime'] =  ($all != 0)?intval($row['time'] / $all):0;
			$array[$int] = $row;
            $int++;
		}
		//---------------СОРТИРОВКА----------
		$sort_condition = $_GET['allSort'];
		if($sort_condition!='name')
		for($j = 0; $j <= sizeof($array)-1;$j++)
			for($i = 0; $i < sizeof($array) - $j - 1;$i++)
				if ($array[$i][$sort_condition] > $array[$i+1][$sort_condition]) {
					$b = $array[$i]; //change for elements
					$array[$i] = $array[$i+1];
					$array[$i+1] = $b;
				}
        $number=1;

        //------------ВЫВОД-------------
        for($j = sizeof($array)-1; $j >= 0;$j--)
        {
        	$timehelpint = floor($array[$j]['allGamesTime'] / 60);   
            echo "<tr>
            <td>". $number ."</td>
            <td>
            <img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'>
			</td>
			<td><a href = 'player.php?name=". $array[$j]['name']."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($array[$j]['name']) . "</a></td>
			<td>". $array[$j]['all'] . "</td>
			<td>". $array[$j]['win'] . "</td>
			<td>". $array[$j]['percent'] . "%</td>
			<td>". $array[$j]['apm'] . "</td>
			<td>" . RaceSwitcher::getRace($array[$j]['favRace']) . "</td>
			<td>" . $timehelpint  .  " м.   " . $array[$j]['allGamesTime'] % 60 . " с. </td>
			</tr>";
            $number++;
        }
	}
?>