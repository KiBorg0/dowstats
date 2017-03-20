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

$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// C какой статьи будет осуществляться вывод

$name = $_GET["name"];
$sid = $_GET["sid"];


$enemyOrAllyName = strtolower($_GET["enemyOrAllyName"]);
$raceOption = RaceSwitcher::getRaceNum($_GET["selected_race"]);
$selected_type = explode(";",$_GET["type_checkboxes"]);
$startFrom = isset($_GET['startFrom']) ? $_GET['startFrom'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'cTime';

$mysqli->real_query(" SELECT * FROM players WHERE sid='$sid'");
$res = $mysqli->store_result();

$where_condition = "(";
if($row = $res->fetch_assoc()){
	$nicknames = unserialize(base64_decode($row['last_nicknames']));
	if($nicknames)
		for($j=0;$j<sizeof($nicknames);$j++) {
			
			for($i = 1; $i <= 8; $i++){
				$where_condition .= "(";
				$where_condition .= "p" . $i . " = '".$nicknames[$j]."'";
				if($raceOption != 0) $where_condition .= " and r".$i." =" . $raceOption;
				$where_condition .= ")";
				if($i != 8) $where_condition .= " or ";
			}
			
			if($j != sizeof($nicknames)-1) $where_condition .= " or ";
		}
	else
		for($i = 1; $i <= 8; $i++){
				$where_condition .= "p" . $i . " = '".$name."'";
				if($raceOption != 0) $where_condition .= " and r".$i." = " . $raceOption;
				if($i != 8) $where_condition .= " or ";
		}
}

// формирование условия поиска по базе
$where_condition .= ")";
// ник противника/союзника
if($enemyOrAllyName != ""){
	$where_condition .= " AND ";
	$where_condition .= "(";
	for($i = 1; $i <= 8; $i++){
		$where_condition .= "LOWER(CONVERT(UNHEX(p" . $i . ") USING utf8)) LIKE '%" . $enemyOrAllyName . "%' ";
		if($i != 8) $where_condition .= "or ";
	}
	$where_condition .= ")";
}

if($sort=='rep_download_counter')
	$where_condition .= " AND replay_link!=''";


$type_condition = '';
for($i=0; $i<4; $i++){
	if($selected_type[$i] != "false"){
		if($i!=0&&$selected_type[$i-1] != "false") $type_condition .= " OR ";	
		$type_condition .= "type = ".($i+1);
	} 	
}
if($type_condition !='')
	$where_condition .= ' AND ('.$type_condition.')';

// echo $where_condition;
$mysqli->real_query(" SELECT * FROM games WHERE $where_condition ORDER BY $sort DESC limit {$startFrom}, 10");
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
	// echo "<b>". $row['cTime'] . "</b><br>"
	// ._("Game Time")		   .": ".$timeh.$timem.$times."<br>"
	// ._("Senders Steam IDs").": ".$row['statsendsid'] ."<br>"
	// ._("Map")			   .": ".$newMap."<br>"
	// ._("Number of replay downloads").": <span id = 'replay_counter".$row['id']."'>"  . $replay_download  . "</span><br>";
	// foreach (glob("../replays/*".$row['id'].".rec") as $filename)
		// echo "<br/><a class = 'btn btn-primary' onclick='increment_replay_download(".$row['id'].")' href = '".str_replace("#", "%23", $filename)."'>"._('Download Replay')."</a>";

	$type = $row['type'];
	$winners = array();
	for($i=1; $i<=$type; $i++)
		$winners[] = $row["w".$i];
?>

	<div class="container-fluid" style="border:1px solid #cecece; border-radius: 4px;">
		<div class="row " style = "display: flex; align-items: center;" >
			<div class="col-md-3"  >
					<b><?php echo $newMap;?></b><br/><br/>
					<img class = "img-rounded center-block" src=<?php echo 'images/maps/'.strtolower($row['map']).'.jpg'?>>
			</div>
			<div class="col-md-9 table-responsive">
	            <table class="table table-striped table-hover text-center table-games" >
	            <thead><tr>
	                <td><?php echo _('Players') ?></td>
	                <td><?php echo _('Races')   ?></td>
	                <td><?php echo _('APM')	    ?></td>
	                <td><?php echo _('Result')  ?></td></tr>
	            </thead>
	            <?php
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
	            ?>
	            </table>
            </div>
        </div>
        	<div class="row">
				<div class="col-md-3">
					<b><?php echo "<br/>".$timeh.$timem.$times."<br/>"?></b>
				</div>
				<div class="col-md-6">
					<?php echo "<br/><b>". $row['cTime'] . "</b>";?>
					<?php echo "<br/>"._("Senders Steam IDs").": ".$row['statsendsid'];?>
				</div>
				<div class="col-md-3">
					<?php 
					if($row['replay_link']!='')
						echo "<div class='btn-group' role='group'><div class='btn btn-primary' id = 'replay_counter".$row['id']."' role='group' onclick='sort_by_downloads()'>"  . $replay_download  . "</div><a class = 'btn btn-primary' role='group' onclick='increment_replay_download(".$row['id'].")' href = '".$row['replay_link']."'>"._('Download Replay')."</a></div>";
					else {
						foreach (glob("../replays/*".$row['id'].".rec") as $filename)
							echo "<div class='btn-group' role='group'><div class='btn btn-primary' id = 'replay_counter".$row['id']."' role='group' onclick='sort_by_downloads()'>"  . $replay_download  . "</div><a class = 'btn btn-primary' role='group' onclick='increment_replay_download(".$row['id'].")' href = '".str_replace("#", "%23", $filename)."'>"._('Download Replay')."</a></div>";
					}
					?>
				</div>
			</div>
	</div>
	<br/>
    
<?php
}

?>								