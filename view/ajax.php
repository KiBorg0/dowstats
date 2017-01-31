<?php
require_once("../lib/NickDecode.php");
require_once("../lib/RaceSwitcher.php");

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");

if(isset($_GET['race'])) {
	header("Content-type: text/txt; charset=UTF-8");
	if($_GET['race']=='all') {
		echo '<h3>Общая статистика</h3>';
		$mysqli->real_query("SELECT * FROM players ORDER BY time DESC");
        $res = $mysqli->use_result();

        $all = 0;
        $win = 0;
        while ($row = $res->fetch_assoc()) {
			$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
			$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
			$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
			$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
			$all = $all + $all1x1 + $all2x2 + $all3x3 + $all4x4;

			$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
			$win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
			$win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
			$win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
			$win = $win + $win1x1 + $win2x2 + $win3x3 + $win4x4;
		}
		$Wnr8 =  50;
		if($all != 0){
			$Wnr8 =  round (100 * $win/$all);
		}
		
		echo 'среднеквадратичное отклонение: ' . $Wnr8;
		?>
		</br>
		<div class="navbar-form navbar-left" style="width:400px;">
		    <div class="form-group ">
		        <input id="player_name_input" onkeypress=" player_name_input_keypress(event)" style="width:300px;" class="form-control" placeholder="Поиск по имени игрока/клана">
		    </div>
		    <a class="btn btn-default" onclick = "Search_player()" ><span class="glyphicon glyphicon-search"></span></a>
		</div>
		<?php
		echo '<TABLE   class="table table-striped table-hover text-center" id = "table-allStat">';
             	
		echo "</TABLE>";
	}
	else {
		
		header("Content-type: text/txt; charset=UTF-8");
		// if($_GET['1']=='1') {
		$race_id = $_GET['race']; 
		echo '<h3>'.RaceSwitcher::getRace($race_id).'</h3>';
		$mysqli->real_query("SELECT * FROM players ORDER BY time DESC");
	    $res = $mysqli->use_result();

	    $all = 0;
	    $win = 0;
	    while ($row = $res->fetch_assoc()) {
			$all = $all + $row['1x1_'.$race_id] + $row['2x2_'.$race_id] + $row['3x3_'.$race_id] +$row['4x4_'.$race_id];

			$win = $win + $row['1x1_'.$race_id.'w'] + $row['2x2_'.$race_id.'w'] + $row['3x3_'.$race_id.'w'] + $row['4x4_'.$race_id.'w'];
		}
		$Wnr8 =  50;
		if($all != 0){
			$Wnr8 =  round (100 * $win/$all);
		}
		
		echo 'Процент побед расы: ' . ($Wnr8). ' %';
		echo '<TABLE   class="table table-striped table-hover text-center">
	         	<thead><tr>
	            <td>номер</td><td>аватар</td><td>игрок</td><td>всего игр</td><td>побед</td><td>% побед</td>
	            </tr>
	            </thead>
	            ';
	    $mysqli->real_query("SELECT * FROM players ORDER BY time DESC");        
		$res = $mysqli->use_result();

		$i = 1;
	    while ($row = $res->fetch_assoc()) {
			echo "<tr>";
			// номер игрока в списке
			echo "<td>" . $i . "</td>";
			echo "<td>";
				echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
				echo "</td>";
			echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
			$all = $row['1x1_'.$race_id] + $row['2x2_'.$race_id] + $row['3x3_'.$race_id] +$row['4x4_'.$race_id];

			$win = $row['1x1_'.$race_id.'w'] + $row['2x2_'.$race_id.'w'] + $row['3x3_'.$race_id.'w'] + $row['4x4_'.$race_id.'w'];

			echo "<td>" . $all . "</td>";
			echo "<td>" . $win . "</td>";
			if($all!= 0){
				echo "<td>" . round(100 * $win/$all) . "</td>";
			}else{
				echo "<td>" . 0 . "</td>";
			};

			echo "</tr>";
			$i += 1;
		}
		echo "</TABLE>";
	}
}
else
	echo 'карявый GET запрос';
?>
