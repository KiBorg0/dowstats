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
$sid = $_GET["sid"];


$enemyOrAllyName = strtolower($_GET["enemyOrAllyName"]);
$raceOption = RaceSwitcher::getRaceNum($_GET["selected_race"]);
$selected_type = explode(";",$_GET["type_checkboxes"]);//массив[0,1,2,3], в котором true/false; 0-1x1 1-2x2 2-3x3 3-4x4
$mysqli->real_query(" SELECT * FROM players WHERE sid='$sid'");
$res = $mysqli->store_result();

$where_condition = "(";
if($row = $res->fetch_assoc()){
	$nicknames = unserialize(base64_decode($row['last_nicknames']));
	if($nicknames)
		for($j=0;$j<sizeof($nicknames);$j++) {
			$where_condition .= "(";
			for($i = 1; $i <= 8; $i++){
				// $where_condition .= "(";
				$where_condition .= "p" . $i . " = '".$nicknames[$j]."'";//поиск по имени игрока
				if($raceOption != 0) $where_condition .= " and r".$i." =" . $raceOption;//поиск по расе игрока
				// $where_condition .= ")";
				if($i != 8) $where_condition .= " or ";
			}
			$where_condition .= ")";
			if($j != sizeof($nicknames)-1) $where_condition .= " or ";
		}
	else
		for($i = 1; $i <= 8; $i++){
				// $where_condition .= "(";
				$where_condition .= "p" . $i . " = '".$name."'";//поиск по имени игрока
				if($raceOption != 0) $where_condition .= " and r".$i." =" . $raceOption;//поиск по расе игрока
				// $where_condition .= ")";
				if($i != 8) $where_condition .= " or ";
		}
}
// формирование условия поиска по базе
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
echo $where_condition;

$startFrom = isset($_GET['startFrom']) ? $_GET['startFrom'] : 0;
$mysqli->real_query(" SELECT * FROM games WHERE $where_condition ORDER BY cTime DESC limit {$startFrom}, 10");
$res = $mysqli->store_result();

$json = file_get_contents ('../images/maps/maps.json');
$arrara = json_decode($json, true);
while ($row = $res->fetch_assoc()) {

	$times = ($row['gTime']%60)." "._('s.')." ";
	$timem = ($row['gTime']/60 % 60)." "._('m.')."   ";
	$timeh = intval($row['gTime'] /3600);
	$timeh = $timeh==0?"":$timeh." "._('h.')."   ";
	$newMap = $arrara[strtolower($row['map'])]!=''?$arrara[strtolower($row['map'])]:$row['map']; 
	// $newMap = $row['map'][1]=="P"?substr($row['map'], 3):$newMap = $row['map']; 
	$replay_download = $row['rep_download_counter'];
	echo "<b>". $row['cTime'] . "</b><br>"
	._("Game Time")		   .": ".$timeh.$timem.$times."<br>"
	._("Senders Steam IDs").": ".$row['statsendsid'] ."<br>"
	._("Map")			   .": ".$newMap."<br>"
	._("Number of replay downloads").": <span id = 'replay_counter".$row['id']."'>"  . $replay_download  . "</span><br>";
	foreach (glob("../replays/*".$row['id'].".rec") as $filename)
		echo "<br/><a class = 'btn btn-primary' onclick='increment_replay_download(".$row['id'].")' href = '".str_replace("#", "%23", $filename)."'>"._('Download Replay')."</a>";

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
		$player_name_coded = $row["p" . $i];
		$player_apm = $row["apm" . $i . "r"];
		$apm = ($player_apm == 0)?"-":$player_apm;
		$href = ($player_apm != 0) ? "<a href = 'player.php?name=". $player_name_coded."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($player_name_coded) . "</a>" :  NickDecode::decodeNick($player_name_coded);
		echo "<TR>
		<td>" . $href 								. "</td>
	    <td>" . RaceSwitcher::getRace($row["r".$i]) . "</td>
	    <td>" . $apm 								. "</td>
		<td>" . (in_array($player_name_coded, $winners)?_('Winner'):_('Loser'))  . "</td></TR>";
	}
	 echo "</TABLE>";
	 echo "<br><br>";
}

?>
									