<?php
require_once("../lib/NickDecode.php");
require_once("../lib/RaceSwitcher.php");

$lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
setlocale(LC_ALL, $lang, $lang . '.utf8');

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");

if(isset($_GET['race'])) {
	if($_GET['race']=='all') {
		echo '<h3>'._('General Stats').'</h3>';
		$mysqli->real_query("SELECT * FROM players ORDER BY time DESC");
        $res = $mysqli->use_result();

        $all = 0;
        $win = 0;
        while ($row = $res->fetch_assoc()) {
			$win = $win + $win1x1 + $win2x2 + $win3x3 + $win4x4;
			for($i=1;$i<=4;$i++)
				for($j=1;$j<=9;$j++)
				{
					$win += $row[$i.'x'.$i.'_'.$j.'w'];
					$all += $row[$i.'x'.$i.'_'.$j]; 
				}
		}
		$Wnr8 =  ($all != 0)?round (100 * $win/$all):0;
		
		echo _('Total Win Rate').': '.$Wnr8.'%';
		?>
		</br>
		<div class="navbar-form navbar-left" style="width:400px;">
		    <div class="form-group ">
		        <input id="player_name_input" onkeypress=" player_name_input_keypress(event)" style="width:300px;" class="form-control" placeholder=<?php echo "'"._("Find by player name/clan name")."'"?>>
		    </div>
		    <a class="btn btn-default" onclick = "Search_player()" ><span class="glyphicon glyphicon-search"></span></a>
		</div>
		<?php
		echo '<TABLE   class="table table-striped table-hover text-center" id = "table-allStat">';
             	
		echo "</TABLE>";
	}
	else {
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
		$Wnr8 =  ($all != 0)?round (100 * $win/$all):0;
		
		echo _('Race Win Rate').': ' . ($Wnr8). '%';
		echo '<TABLE   class="table table-striped table-hover text-center">
	         	<thead><tr>
	            <td>'._('Number').'</td><td>'._('Avatar').'</td><td>'._('Player').'</td><td>'._('Number of Games').'</td><td>'._('Victories').'</td><td>'._('Win Rate').'</td>
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
			echo "<td><a href = 'player.php?name=". $row['name']."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
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
