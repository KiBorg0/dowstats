<?php

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");
date_default_timezone_set('Europe/Moscow');

require_once("../lib/NickDecode.php");
require_once("../lib/RaceSwitcher.php");

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// C какой статьи будет осуществляться вывод
$startFrom = isset($_GET['startFrom']) ? $_GET['startFrom'] : 0;
$lang = $_GET['lang'];
$name = $_GET["name"];
$enemyOrAllyName = NickDecode::codeNick($_GET["enemyOrAllyName"]);
$raceOption = RaceSwitcher::getRaceNum($_GET["selected_race"]);
$selected_type = explode(";",$_GET["type_checkboxes"]);//массив[0,1,2,3], в котором true/false; 0-1x1 1-2x2 2-3x3 3-4x4
$game_page_limit = 10;
$where_condition = "(";
for($i = 1; $i <= 8; $i++){
	$where_condition .= "(";
	$where_condition .= "p" . $i . " = '$name'";//поиск по имени игрока
	if($raceOption != 0) $where_condition .= " and r".$i." =" . $raceOption;//поиск по расе игрока
	$where_condition .= ")";
	if($i != 8) $where_condition .= "or ";
}
$where_condition .= ")";

if($enemyOrAllyName != ""){
	$where_condition .= " and ";
	$where_condition .= "(";
	for($i = 1; $i <= 8; $i++){
		$where_condition .= "p" . $i . " LIKE '%" . $enemyOrAllyName . "%' ";
		if($i != 8) $where_condition .= "or ";
	}
	$where_condition .= ")";
}

if($selected_type[0] == "false") $where_condition .= " and (type = 2 or type = 3 or type = 4)";
if($selected_type[1] == "false") $where_condition .= " and (type = 1 or type = 3 or type = 4)";
if($selected_type[2] == "false") $where_condition .= " and (type = 1 or type = 2 or type = 4)";
if($selected_type[3] == "false") $where_condition .= " and (type = 1 or type = 2 or type = 3)";





$mysqli->real_query(" SELECT * FROM games WHERE $where_condition ORDER BY cTime DESC limit {$startFrom}, {$game_page_limit}");
$res = $mysqli->use_result();

while ($row = $res->fetch_assoc()) {

	$timehelpint = $row['gTime'] / 60;
	$timehours = intval($timehelpint / 60);
	echo "<b>" . $row['cTime'] . "</b><br>";
	echo _("Game time").": " . $timehours . " "._('h.')."   " . $timehelpint % 60 .  " "._('m.')."   " . $row['gTime'] % 60 . " "._('s.')." ";
	if($row['map'][1] == "P")
		$newMap = substr($row['map'], 3); 
	else
		$newMap = $row['map'];
	
	echo _("Map").": "  . $newMap . "<br>";
	echo _("Senders steam ids").": "  . $row['statsendsid'];
	
	if(file_exists("../replays/".$row['id'].".rec"))
		echo "<br/><a class = 'btn btn-primary' href = 'replays/".$row['id'].".rec'>"._('download replay')."</a>";
	else
		echo "<br/>"._("replay is absent");

	$type = $row['type'];

	$winners = array();
	for($i=1; $i<=$type; $i++)
		$winners[] = $row["w".$i];

	echo " <TABLE  class=\"table table-striped table-hover text-center table-games\">";
	echo "<thead><tr>
		<td>"._('players')."</td>
		<td>"._('races')."</td>
		<td>"._('apm')."<br/></td>
		<td>"._('result')."</td></tr>
		</thead>";
	for($i=1; $i<=$type*2; $i++)
	{
		echo "<TR>\n";
	    echo " <td><a href = 'player.php?name=". $row["p".$i]."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($row["p".$i]) . "</a></td>\n";
	    echo " <td>" . RaceSwitcher::getRace($row["r".$i]) . "</td>\n";
	    if($i==1)
	    	" <td>" . $row["p".$i] . "</td>\n";
	    $apm = ($row["apm".$i."r"] == 0) ? _("no data") : $row["apm".$i."r"];
	    echo " <td>" . $apm . "</td>\n";

	    if(in_array($row["p".$i], $winners))
			echo " <td>"._('win')."</td>";
		else
			echo " <td>"._('lose')."</td>";
	    echo "</TR>\n";
	}
	 echo "</TABLE>\n";
	 echo "<br><br>";
}

?>
									