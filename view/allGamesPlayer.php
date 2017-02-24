<?php

$host = $_SERVER['HTTP_HOST'];

$lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
putenv('LC_ALL=' . $lang);
setlocale(LC_ALL, $lang, $lang . '.utf8');
bind_textdomain_codeset($lang, 'UTF-8');
bindtextdomain($lang, '../locale');
textdomain($lang);
date_default_timezone_set('Europe/Moscow');

require_once("../lib/NickDecode.php");
require_once("../lib/RaceSwitcher.php");

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// C какой статьи будет осуществляться вывод

$name = $_GET["name"];
$enemyOrAllyName = strtolower($_GET["enemyOrAllyName"]);
$raceOption = RaceSwitcher::getRaceNum($_GET["selected_race"]);
$selected_type = explode(";",$_GET["type_checkboxes"]);//массив[0,1,2,3], в котором true/false; 0-1x1 1-2x2 2-3x3 3-4x4
// формирование условия поиска по базе
$where_condition = "(";
for($i = 1; $i <= 8; $i++){
	$where_condition .= "(";
	$where_condition .= "p" . $i . " = '$name'";//поиск по имени игрока
	if($raceOption != 0) $where_condition .= " and r".$i." =" . $raceOption;//поиск по расе игрока
	$where_condition .= ")";
	if($i != 8) $where_condition .= "or ";
}
$where_condition .= ")";
// ник противника/союзника
if($enemyOrAllyName != ""){
	$where_condition .= " and ";
	$where_condition .= "(";
	for($i = 1; $i <= 8; $i++){
		$where_condition .= "LOWER(CONVERT(UNHEX(p" . $i . ") USING utf8)) LIKE '%" . $enemyOrAllyName . "%' ";
		if($i != 8) $where_condition .= "or ";
	}
	$where_condition .= ")";
}
// тип игры
if($selected_type[0] == "false") $where_condition .= " and (type = 2 or type = 3 or type = 4)";
if($selected_type[1] == "false") $where_condition .= " and (type = 1 or type = 3 or type = 4)";
if($selected_type[2] == "false") $where_condition .= " and (type = 1 or type = 2 or type = 4)";
if($selected_type[3] == "false") $where_condition .= " and (type = 1 or type = 2 or type = 3)";

$startFrom = isset($_GET['startFrom']) ? $_GET['startFrom'] : 0;
$mysqli->real_query(" SELECT * FROM games WHERE $where_condition ORDER BY cTime DESC limit {$startFrom}, 10");
$res = $mysqli->store_result();

while ($row = $res->fetch_assoc()) {
	$timehelpint = $row['gTime'] / 60;
	$timehours = intval($timehelpint / 60);
	$newMap = $row['map'][1]=="P"?substr($row['map'], 3):$newMap = $row['map']; 
	echo "<b>" . $row['cTime'] . "</b><br>";
	echo _("Game Time").": " . $timehours . " "._('h.')."   " . $timehelpint % 60 .  " "._('m.')."   " . $row['gTime'] % 60 . " "._('s.')." ";
	echo _("Map").": "  . $newMap . "<br>";
	echo _("Senders Steam IDs").": "  . $row['statsendsid'];
	if(file_exists("../replays/".$row['id'].".rec"))
		echo "<br/><a class = 'btn btn-primary' href = 'replays/".$row['id'].".rec'>"._('Download Replay')."</a>";
	// else
	// 	echo "<br/>"._("Replay is Absent");

	$type = $row['type'];
	$winners = array();
	for($i=1; $i<=$type; $i++)
		$winners[] = $row["w".$i];

	echo " <TABLE  class=\"table table-striped table-hover text-center table-games\">";
	echo "<thead><tr>
		<td>"._('Players') ."</td>
		<td>"._('Races')   ."</td>
		<td>"._('APM')	   ."<br/></td>
		<td>"._('Result')  ."</td></tr>
		</thead>";
	for($i=1; $i<=$type*2; $i++)
	{
		$apm = ($row["apm".$i."r"] == 0)?"-":$row["apm".$i."r"];
	    // if($i==1)
	    // 	" <td>" . $row["p".$i] . "</td>";
		echo "<TR>
		<td><a href = 'player.php?name=". $row["p".$i]."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($row["p".$i]) . "</a></td>
	    <td>" . RaceSwitcher::getRace($row["r".$i]) . "</td>
	    <td>" . $apm . "</td>
		<td>" . (in_array($row["p".$i], $winners)?_('Winner'):_('Loser'))  . "</td></TR>";
	}
	 echo "</TABLE>";
	 echo "<br><br>";
}

?>
									