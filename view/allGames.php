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


$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
$searchname = strtolower($_GET["playername"]);
$raceOption = RaceSwitcher::getRaceNum($_GET["selected_race"]);
$selected_type = explode(";",$_GET["type_checkboxes"]);//массив[0,1,2,3], в котором true/false; 0-1x1 1-2x2 2-3x3 3-4x4
$startFrom = isset($_GET['startfrom']) ? $_GET['startfrom'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'cTime';$game_page_limit = 10;
$where_condition = "";
for($i = 1; $i <= 8; $i++){
	if($searchname!=''||$raceOption!=0){
		$where_condition .= "(";
		if($searchname!=''){
			$where_condition .= "LOWER(CONVERT(UNHEX(p".$i.") USING utf8)) LIKE '%" . $searchname . "%' ";
			if($raceOption != 0) $where_condition .= ' AND ';
		}
		if($raceOption != 0) $where_condition .= "r".$i."=" . $raceOption;//поиск по расе игрока
		$where_condition .= ")";
		if($i != 8) $where_condition .= " OR ";	
	}
}

// if($sort=='rep_download_counter')
	// $where_condition = $where_condition!='' ? '('.$where_condition.") AND replay_link!=''" : "replay_link!=''";

$type_condition = '';
for($i=0; $i<4; $i++){
	if($selected_type[$i] != "false"){
		if($i!=0&&$selected_type[$i-1] != "false") $type_condition .= " OR ";
		$type_condition .= "type = ".($i+1);
	} 	
}
if($type_condition!='')
	$type_condition = $where_condition=='' ? '('.$type_condition.")" :' AND ('.$type_condition.")";
$where_condition = $where_condition!=''?'('.$where_condition.")".$type_condition:$type_condition;

$where_condition = $where_condition!='' ? $where_condition : '1';

$mysqli->real_query(" SELECT * FROM games WHERE $where_condition ORDER BY $sort DESC limit {$startFrom}, 10");
$res = $mysqli->store_result();

$json = file_get_contents('../images/maps/maps.json');
$arrara = json_decode($json, true);

while ($row = $res->fetch_assoc()) {

	if(!$row['confirmed']&&$row['replay_link']=='')
		continue;

	$times = ($row['gTime']%60)." "._('s.')." ";
	$timem = ($row['gTime']/60 % 60)." "._('m.')."   ";
	$timeh = intval($row['gTime'] /3600);
	$timeh = $timeh==0?"":$timeh." "._('h.')."   ";
	$newMap = $arrara[strtolower($row['map'])]!=''?$arrara[strtolower($row['map'])]:$row['map']; 
	$replay_download = $row['rep_download_counter'];

	$statsendsid_str = $row['statsendsid'];
	$statsendsid = unserialize(base64_decode($statsendsid_str));

	?>


	<div id="<?php echo $row['id'];?>" class="container-fluid" style="border:1px solid #cecece; border-radius: 4px;">
	<div class="row " style = "display: flex; align-items: center;" >
		<div class="col-md-3">
				<br/>
				<!-- <b><?php echo $row['id'];?></b> -->
				<b><?php echo $newMap;?></b><br/><br/>
				<?php 
				$mapname = '../images/maps/'.strtolower($row['map']).'.jpg';
				if(!file_exists($mapname))
					$mapname = 'images/maps/default.jpg';
				?>
				<img class = "img-rounded center-block" src=<?php echo $mapname?>>
		</div>
		<div class="col-md-9 table-responsive">
			<table class="table table-striped table-hover text-center table-games" >

			<thead>
				<tr>
					<td><?php echo _('Players')?></td>
					<td><?php echo _('Races')?></td>
					<td><?php echo _('APM')?></td>
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
				$href = "player.php?";
				if($statsendsid){
					$sid = isset($statsendsid[$i])?$statsendsid[$i]:'';
					$href .= "sid=". $sid."&lang=".$lang."#tab0";
				}
				else
					$href .= "name=". $player_name_coded."&lang=".$lang."#tab0";
				$href = ($player_apm != 0) ? "<a href = '".$href."'>" . NickDecode::decodeNick($player_name_coded) . "</a>" :  NickDecode::decodeNick($player_name_coded);
				echo "<TR>
				<td>" . $href 								  . "</td>
			    <td>" . RaceSwitcher::getRace($row["r" . $i]) . "</td>
			    <td>" . $apm 								  . "</td>
			    <td>" . (!$row['confirmed']?"-":(in_array($player_name_coded, $winners)?_('Winner'):_('Loser')))  . "</td></TR>";
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
			<?php
			$echo_str = "<br/>"._("Senders").": ";
			// $echo_str = "<br/>"._("Senders Steam IDs").": ";
			if($statsendsid)
			{
				echo $echo_str;
				for($j=0;$j<=8;$j++)
					if(isset($statsendsid[$j]))
					{
						$mysqli->real_query("SELECT name FROM players WHERE sid='".$statsendsid[$j]."'");
						$resplayer = $mysqli->store_result();
						$rowplayer = $resplayer->fetch_assoc();
						echo "<a href='player.php?sid=".$statsendsid[$j]."&lang=".$lang."#tab0'>".NickDecode::decodeNick($rowplayer['name'])."</a> ";
					}
			}
			else
				echo $echo_str.$statsendsid_str;
			?>
		</div>
		<div class="col-md-3">
			<?php 
			if($row['replay_link']!='')
				echo "<div class='btn-group' role='group'><div class='btn btn-primary' id = 'replay_counter".$row['id']."' role='group' onclick='sort_by_downloads()'>"  . $replay_download  . "</div><a class = 'btn btn-primary' role='group' onclick='increment_replay_download(".$row['id'].")' href = '".$row['replay_link']."'>"._('Download Replay')."</a></div>";
			else {
				foreach (glob("../replays/".$row['id'].".rec") as $filename)
					echo "<div class='btn-group' role='group'><div class='btn btn-primary' id = 'replay_counter".$row['id']."' role='group' onclick='sort_by_downloads()'>"  . $replay_download  . "</div><a class = 'btn btn-primary' role='group' onclick='increment_replay_download(".$row['id'].")' href = '".str_replace("#", "%23", $filename)."'>"._('Download Replay')."</a></div>";
			}
			?>
		</div>
	</div>
	</div>
	<!-- </div> -->
	<br/>

<?php
}

if($res->num_rows == 0){
		echo _("games with such parameters not found");
	}
?>
									