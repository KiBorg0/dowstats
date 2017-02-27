<?
	require_once("../lib/steam.php");
	require_once("../lib/NickDecode.php");
    require_once("../lib/RaceSwitcher.php");

    $lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
	putenv('LC_ALL=' . $lang);
	setlocale(LC_ALL, $lang, $lang . '.utf8');
	bind_textdomain_codeset($lang, 'UTF-8');
	bindtextdomain($lang, '../locale');
	textdomain($lang);

    $sort = array('name' 		 => 0,
			      'all' 		 => 1,
			      'win' 		 => 2,
			      'percent' 	 => 3,
			      'apm' 		 => 4,
			      'favRace' 	 => 5,
			      'allGamesTime' => 6,
			      'top' => 7, );

	

	$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
	if(isset($_GET['allSort'])) {
		//---------------ВЫВОД ЗАГОЛОВКА ТАБЛИЦЫ----------
		$sort_type = $sort[$_GET['allSort']];
        $tabel_header = array();
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByName();">'._('Player');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByAllGames();">'._('Number of Games');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByWin();">'._('Victories');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByPercent();">'._('Win Rate');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByAPM();">'._('APM');
		$tabel_header[] = '<td style = "width:15%;"><a href = "javascript: SortAllStatByFavRace();">'._('Favorite Race');
		$tabel_header[] = '<td style = "width:9%;"><a href = "javascript: SortAllStatByAllGamesTime();">&asymp;'._('Time');
		$result_header = "";
		for($i=0; $i<7;$i++)
			if($i==$sort_type) $result_header .= $tabel_header[$i]." &#8595;</a></td>";
			else $result_header .= $tabel_header[$i]."</a></td>";

		echo '<thead><tr>
		<td style = "width:5%;">'._('Number').'</td>
        <td style = "width:10%;">'._('Avatar').'</td>'
        .$result_header.
        '</tr>
        </thead>';
        //---------------ПОДГОТОВКА ДАННЫХ ДЛЯ ТАБЛИЦЫ----------
        $array = array();  
        $int = 0;
		if($_GET['allSort']=='name') {
        	// $pname = isset($_GET['playername'])?NickDecode::codeNick(strtolower($_GET['playername'])):"";
        	$pname = isset($_GET['playername'])?strtolower($_GET['playername']):"";
	    	$mysqli->real_query("SELECT * FROM players WHERE LOWER(CONVERT(UNHEX(name) USING utf8)) LIKE '%$pname%' ORDER BY name DESC ");
		}
		else
			$mysqli->real_query("SELECT * FROM players ");     
	       
		$res = $mysqli->store_result();
        while ($row = $res->fetch_assoc()) {
			$all = 0;
			$win = 0;
			$favRace = 0;
			$countGamesForRace = 0;
			for($j=1;$j<=9;$j++)
			{
				$sum = 0;
				for($i=1;$i<=4;$i++)
				{
					$win += $row[$i.'x'.$i.'_'.$j.'w'];
					$sum += $row[$i.'x'.$i.'_'.$j];
				}
				$all += $sum;
	            if($countGamesForRace<$sum)
                {
                    $favRace = $j;
                    $countGamesForRace = $sum;
                } 
			}
			$row['all'] = $all ;
			$row['win'] = $win ;
			$row['percent'] = ($all!= 0)?round(100 * $win/$all):0;
			$row['top'] = $row['mmr'];
			$row['favRace'] =  $favRace ;
			$row['allGamesTime'] =  ($all != 0)?intval($row['time'] / $all):0;
			$array[$int] = $row;
            $int++;
		}
		//---------------СОРТИРОВКА----------
		$sort_condition = $_GET['allSort'];
		// для условия сортировки 'name' сортировку делать не будем, так как она выполняется на этапе получаения записей из базы
		if($sort_condition!='name')
			for($j = 0; $j <= sizeof($array)-1;$j++)
				for($i = 0; $i < sizeof($array) - $j - 1;$i++)
					if ($array[$i][$sort_condition] > $array[$i+1][$sort_condition]) {
						$b = $array[$i]; //change for elements
						$array[$i] = $array[$i+1];
						$array[$i+1] = $b;
					}

        $number=0;
        //------------ВЫВОД-------------
        for($j = sizeof($array)-1; $j >= 0;$j--)
        {
        	if($array[$j]['all']!=0)
        	{
	        	$number++;
	        	$timehelpint = floor($array[$j]['allGamesTime'] / 60);   
	            echo "<tr>
	            <td>". $number ."</td>
	            <td><a href = 'player.php?sid=". $array[$j]['sid']."&lang=".$lang."#tab0'><img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'></a></td>
				<td><a href = 'player.php?sid=". $array[$j]['sid']."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($array[$j]['name']) . "</a></td>
				<td>". $array[$j]['all'] . "</td>
				<td>". $array[$j]['win'] . "</td>
				<td>". $array[$j]['percent'] . "%</td>
				<td>". $array[$j]['apm'] . "</td>
				<td>" . RaceSwitcher::getRace($array[$j]['favRace']) . "</td>
				<td>" . $timehelpint  .  " м.   " . $array[$j]['allGamesTime'] % 60 . " с. </td>
				</tr>";
			}
        }
	}
?>