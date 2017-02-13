<?


$host = $_SERVER['HTTP_HOST'];

$lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
setlocale(LC_ALL, $lang, $lang . '.utf8');

date_default_timezone_set('Europe/Moscow');

require_once("../lib/NickDecode.php");
require_once("../lib/RaceSwitcher.php");


/*

Directory Listing Script - Version 2

====================================

Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net

Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk

*/

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$searchname = NickDecode::codeNick($_GET["playername"]);
$raceOption = RaceSwitcher::getRaceNum($_GET["selected_race"]);
$selected_type = explode(";",$_GET["type_checkboxes"]);//массив[0,1,2,3], в котором true/false; 0-1x1 1-2x2 2-3x3 3-4x4
$game_page_limit = 10;
$where_condition = "";
for($i = 1; $i <= 8; $i++){
	$where_condition .= "(";
	$where_condition .= "p".$i." LIKE '%" . $searchname . "%' ";//поиск по имени игрока
	if($raceOption != 0) $where_condition .= " and r".$i." =" . $raceOption;//поиск по расе игрока
	if($selected_type[0] == "false") $where_condition .= " and (type = 2 or type = 3 or type = 4)";
	if($selected_type[1] == "false") $where_condition .= " and (type = 1 or type = 3 or type = 4)";
	if($selected_type[2] == "false") $where_condition .= " and (type = 1 or type = 2 or type = 4)";
	if($selected_type[3] == "false") $where_condition .= " and (type = 1 or type = 2 or type = 3)";
	$where_condition .= ")";
	if($i != 8) $where_condition .= "or ";
}

//$mysqli->real_query(" SELECT * FROM games WHERE p1 LIKE '%$searchname%' or p2 LIKE '%$searchname%' or p3 LIKE '%$searchname%' or p4 LIKE '%$searchname%' or p5 LIKE '%$searchname%' or p6 LIKE '%$searchname%' or p7 LIKE '%$searchname%' or p8 LIKE '%$searchname%' ORDER BY cTime DESC limit $game_page_limit");

// C какой статьи будет осуществляться вывод
$startFrom = isset($_GET['startFrom']) ? $_GET['startFrom'] : 0;

$mysqli->real_query(" SELECT * FROM games WHERE $where_condition ORDER BY cTime DESC limit {$startFrom}, 10");

$res = $mysqli->use_result();



while ($row = $res->fetch_assoc()) {
	$timehelpint = $row['gTime'] / 60;
	$timehours = intval($timehelpint / 60);
	echo "<b>" . $row['cTime'] . "</b><br>";
	echo _("Game Time").": " . $timehours . " "._('h.')."   " . $timehelpint % 60 .  " "._('m.')."   " . $row['gTime'] % 60 . " "._('s.')." ";
	if($row['map'][1] == "P"){
		$newMap = substr($row['map'], 3); 
	}else{
		$newMap = $row['map'];
	}
	echo _("Map").": "  . $newMap . "<br>";
	echo _("Senders Steam IDs").": "  . $row['statsendsid'];
	if(file_exists("../replays/".$row['id'].".rec")){
		echo "<br/><a class = 'btn btn-primary' href = '../replays/".$row['id'].".rec'>"._('Download Replay')."</a>";
	}else{
		echo "<br/>"._("Replay is Absent");
	}
	?>

	<table class="table table-striped table-hover text-center table-games">
		<thead>
			<tr>
				<td><?php echo _('Players')?></td>
				<td><?php echo _('Races')?></td>
				<td><?php echo _('APM')?><br/></td>
				<td><?php echo _('Result')?></td>
			</tr>
		</thead>

	<?php
	for ($i = 1;$i <= $row['type']*2;$i++){
		$type = $row['type'];
		$player_name_coded = $row["p" . $i];
		$player_race_coded = $row["r" . $i];
		$player_apm = $row["apm" . $i . "r"];
		echo "<TR>";
			$href = ($player_apm != 0) ? "<a href = 'player.php?name=". $player_name_coded."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($player_name_coded) . "</a>" :  NickDecode::decodeNick($player_name_coded);
		    echo "<td>". $href . "</td>";
		    echo "<td>" . RaceSwitcher::getRace($player_race_coded) . "</td>";
		    $apm = ($player_apm == 0) ? _("No Data") :  $player_apm;
		    echo "<td>" . $apm . "</td>";
		    $is_victory = false;
		    for($j=1; $j<=$type;$j++){
		    	$win_name_coded = $row["w" . $j];
		    	if ($win_name_coded == $player_name_coded) $is_victory = true;
		    }
		    if($is_victory){
				echo " <td>"._('Winner')."</td>";
			}else{
				echo " <td>"._('Loser')."</td>";
			}
	    echo "</TR>";
	}

	
	?>
	</table>
	<hr style="border-bottom: 1px solid #555;"/>

<?php
}

if($res->num_rows == 0){
		echo _("games with such parameters not found");
	}
?>
									