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

	$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");

	$sort_type = isset($_GET['allSort'])?$_GET['allSort']:'top';
	if($sort_type=='name') {
		$pname = isset($_GET['playername'])?strtolower($_GET['playername']):"";
		$mysqli->real_query("SELECT * FROM players WHERE LOWER(CONVERT(UNHEX(name) USING utf8)) LIKE '%$pname%' ORDER BY name DESC ");
	}
	else
		$mysqli->real_query("SELECT * FROM players ");

	// $mysqli->real_query("SELECT * FROM players ORDER BY time DESC");
    $res = $mysqli->store_result();
    $all = 0;
    $win = 0;
    $race_id = isset($_GET['race'])?$_GET['race']:0;
	?>
    </br>
    <div class="navbar-form navbar-left" style="width:400px;">
        <div class="form-group ">
            <input id="player_name_input" onkeypress=" player_name_input_keypress(event,<?php echo $race_id?>)" style="width:300px;" class="form-control" placeholder=<?php echo "'"._("Find by player name/clan name")."'"?>>
        </div>
        <a class="btn btn-default" onclick = "Search_player(<?php echo $race_id?>)" ><span class="glyphicon glyphicon-search"></span></a>
    </div>
	<?php

	if($race_id==0) {
        //---------------ПОДГОТОВКА ДАННЫХ ДЛЯ ТАБЛИЦЫ----------
        $array = array();  
        $int = 0;
	    $all_t = 0; $win_t = 0;   
        while ($row = $res->fetch_assoc()) {
			$all = 0;
			$win = 0;
			$favRace = 0;
			$countGamesForRace = 0;
			for($i=1;$i<=4;$i++)
				for($j=1;$j<=9;$j++)
				{
					$win_t += $row[$i.'x'.$i.'_'.$j.'w'];
					$all_t += $row[$i.'x'.$i.'_'.$j]; 
				}
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
		// для условия сортировки 'name' сортировку делать не будем, так как она выполняется на этапе получаения записей из базы
		if($sort_type!='name')
			for($j = 0; $j <= sizeof($array)-1;$j++)
				for($i = 0; $i < sizeof($array) - $j - 1;$i++)
					if ($array[$i][$sort_type] > $array[$i+1][$sort_type]) {
						$b = $array[$i]; //change for elements
						$array[$i] = $array[$i+1];
						$array[$i+1] = $b;
					}
		$Wnr8 =  ($all_t != 0)?round (100 * $win_t/$all_t):0;
		echo _('Total Win Rate').': '.$Wnr8.'%';
		echo '<TABLE   class="table table-striped table-hover text-center">';
		//---------------ВЫВОД ЗАГОЛОВКА ТАБЛИЦЫ----------
		
        $tabel_header = array();
		$tabel_header[] = '<td style = "width:14%;"><a href = "javascript: SortBy(\'name\');">'._('Player');
		$tabel_header[] = '<td style = "width:11%;"><a href = "javascript: SortBy(\'all\');">'._('Number of Games');
		$tabel_header[] = '<td style = "width:10%;"><a href = "javascript: SortBy(\'win\');">'._('Victories');
		$tabel_header[] = '<td style = "width:10%;"><a href = "javascript: SortBy(\'percent\');">'._('Win Rate');
		$tabel_header[] = '<td style = "width:10%;"><a href = "javascript: SortBy(\'apm\');">'._('APM');
		$tabel_header[] = '<td style = "width:10%;"><a href = "javascript: SortBy(\'favRace\');">'._('Favorite Race');
		$tabel_header[] = '<td style = "width:10%;"><a href = "javascript: SortBy(\'allGamesTime\');">&asymp;'._('Time');
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
        $number=0;
        //------------ВЫВОД-------------
        for($j = sizeof($array)-1; $j >= 0;$j--)
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
		echo "</TABLE>";
	}else{
	    $all_r = 0; $win_r = 0;
		$array = array(); 
		$i = 0;
	    while ($row = $res->fetch_assoc()) {
			$all_r += $all = $row['1x1_'.$race_id] + $row['2x2_'.$race_id] + $row['3x3_'.$race_id] +$row['4x4_'.$race_id];
			$win_r += $win = $row['1x1_'.$race_id.'w'] + $row['2x2_'.$race_id.'w'] + $row['3x3_'.$race_id.'w'] + $row['4x4_'.$race_id.'w'];
			$row['all'] = $all ;
			$row['win'] = $win ;
			$row['percent'] = ($all!= 0)?round(100 * $win/$all):0;
			$row['top'] = $row['all']/1.5+$row['percent'];
			$array[$i] = $row;
            $i++;
        }
        $Wnr8 =  ($all_r != 0)?round (100 * $win_r/$all_r):0;

		//---------------СОРТИРОВКА----------
		if($sort_type!='name')
			for($j = 0; $j <= sizeof($array)-1;$j++)
				for($i = 0; $i < sizeof($array) - $j - 1;$i++)
					if ($array[$i][$sort_type] > $array[$i+1][$sort_type]) {
						$b = $array[$i]; //change for elements
						$array[$i] = $array[$i+1];
						$array[$i+1] = $b;
						}
        $number=0;

        //------------ВЫВОД-------------
		echo _('Race Win Rate').': ' . ($Wnr8). '%';
		echo '<TABLE   class="table table-striped table-hover text-center">
	         	<thead><tr>
	            <td style = "width:5%;">'._('Number')		  .'</td>
	            <td style = "width:10%;">'._('Avatar')		  .'</td>
	            <td style = "width:15%;"><a href = "javascript: SortBy(\'name\','.$race_id.');">'._('Player')		  .'</td>
	            <td style = "width:15%;"><a href = "javascript: SortBy(\'all\','.$race_id.');">'._('Number of Games').'</td>
	            <td style = "width:15%;"><a href = "javascript: SortBy(\'win\','.$race_id.');">'._('Victories')	  .'</td>
	            <td style = "width:15%;"><a href = "javascript: SortBy(\'percent\','.$race_id.');">'._('Win Rate')		  .'</td></tr></thead>';
        for($j = sizeof($array)-1; $j >= 0;$j--)
        {
        	if($array[$j]['all']==0)
        		continue;
        	$number++;
            echo "<tr>
            <td>". $number ."</td>
            <td>
            <img class = 'avatar' src='" . $array[$j]['avatar_url'] . "'>
			</td>
			<td><a href = 'player.php?sid=". $array[$j]['sid']."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($array[$j]['name']) . "</a></td>
			<td>". $array[$j]['all'] . "</td>
			<td>". $array[$j]['win'] . "</td>
			<td>". $array[$j]['percent'] . "%</td>
			</tr>";
        }
        echo "</TABLE>";
    }
?>