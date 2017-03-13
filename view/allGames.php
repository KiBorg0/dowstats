<?


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
$searchname = strtolower($_GET["playername"]);
$raceOption = RaceSwitcher::getRaceNum($_GET["selected_race"]);
$selected_type = explode(";",$_GET["type_checkboxes"]);//массив[0,1,2,3], в котором true/false; 0-1x1 1-2x2 2-3x3 3-4x4
$game_page_limit = 10;
$where_condition = "";
for($i = 1; $i <= 8; $i++){
	$where_condition .= "(";
	$where_condition .= "LOWER(CONVERT(UNHEX(p".$i.") USING utf8)) LIKE '%" . $searchname . "%' ";//поиск по имени игрока
	if($raceOption != 0) $where_condition .= " and r".$i." =" . $raceOption;//поиск по расе игрока
	if($selected_type[0] == "false") $where_condition .= " and (type = 2 or type = 3 or type = 4)";
	if($selected_type[1] == "false") $where_condition .= " and (type = 1 or type = 3 or type = 4)";
	if($selected_type[2] == "false") $where_condition .= " and (type = 1 or type = 2 or type = 4)";
	if($selected_type[3] == "false") $where_condition .= " and (type = 1 or type = 2 or type = 3)";
	$where_condition .= ")";
	if($i != 8) $where_condition .= "or ";
}


// C какой статьи будет осуществляться вывод
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
	$replay_download = $row['rep_download_counter'];
	// echo "<b>". $row['cTime'] . "</b><br>"
	// echo _("Game Time")		   .": ".$timeh.$timem.$times."<br/>"
	// echo "<br/>"._("Senders Steam IDs").": ".$row['statsendsid'];
	// ._("Number of replay downloads").": <span id = 'replay_counter".$row['id']."'>"  . $replay_download  . "</span>";
	// ._("Map")			   .": ".$newMap."<br>";

	// foreach (glob("../replays/*".$row['id'].".rec") as $filename)
	// 	echo "<br/><a class = 'btn btn-primary' onclick='increment_replay_download(".$row['id'].")' href = '".str_replace("#", "%23", $filename)."'>"._('Download Replay')."</a>";
	
	?>


	<!-- <div class="container"> -->

	
	<div class="row fullGameInfo" >
	<div class="row" >
		<div class="col-md-3">
			<div class="row">

				<b><?php echo $newMap;?></b>
				<!--<div class="col-md-6">

				</div>-->
			</div>
			<div class="row" style="min-height: 120px;">
				<!-- <div class="col-md-12"> -->
					<img class = "map-img" src=<?php echo 'images/maps/'.$row['map'].'.jpg'?>>
				<!-- </div> -->
			</div>
		</div>
		<div class="col-md-9 table-responsive">
			<table class="table table-striped table-hover text-center table-games">

			<thead>
				<tr>
					<!-- <td><?php echo _("Map").": ".$newMap."<br/>"?></td> -->
					<td><?php echo _('Players')?></td>
					<td><?php echo _('Races')?></td>
					<td><?php echo _('APM')?><br/></td>
					<td><?php echo _('Result')?></td>
				</tr>
			</thead>

			<?php
			$type = $row['type'];
			$winners = array();
			for($i=1; $i<=$type; $i++)
				$winners[] = $row["w".$i];

			for ($i = 1;$i <= $type*2;$i++){
				$player_name_coded = $row["p" . $i];
				$player_apm = $row["apm" . $i . "r"];
				$apm = ($player_apm == 0)?"-":$player_apm;
				$href = ($player_apm != 0) ? "<a href = 'player.php?name=". $player_name_coded."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($player_name_coded) . "</a>" :  NickDecode::decodeNick($player_name_coded);
				echo "<TR>
				<td>" . $href 								  . "</td>
			    <td>" . RaceSwitcher::getRace($row["r" . $i]) . "</td>
			    <td>" . $apm 								  . "</td>
			    <td>" . (in_array($player_name_coded, $winners)?_('Winner'):_('Loser'))  . "</td></TR>";
			}
			?>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<?php echo "<br/><b>". $row['cTime'] . "</b>";?>

		</div>
		<div class="col-md-7">
			<?php /*echo "<br/>"._("Senders Steam IDs").": ".$row['statsendsid'];*/?>
			<?php echo "<br/>".$timeh.$timem.$times."<br/>"?>
		</div>
		<div class="col-md-2">
			<?php if($row['replay_link']!='')
				echo " <a class = 'btn btn-primary' onclick='increment_replay_download(".$row['id'].")' href = '".$row['replay_link']."'>"._('Download Replay')."</a>";?>
		</div>
	</div>
	</div>
	<br/>
	<!-- </div> -->

<?php
	// echo "<br/>"._("Senders Steam IDs").": ".$row['statsendsid'];
	// if($row['replay_link']!='')
	// 	echo " <a class = 'btn btn-primary' onclick='increment_replay_download(".$row['id'].")' href = '".$row['replay_link']."'>"._('Download Replay')."</a>";
}

if($res->num_rows == 0){
		echo _("games with such parameters not found");
	}
?>
									