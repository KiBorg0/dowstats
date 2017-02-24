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

while ($row = $res->fetch_assoc()) {
	$times = ($row['gTime']%60)." "._('s.')." ";
	$timem = ($row['gTime']/60 % 60)." "._('m.')."   ";
	$timeh = intval($row['gTime'] /3600);
	$timeh = $timeh==0?"":$timeh." "._('h.')."   ";
	$newMap = $row['map'][1]=="P"?substr($row['map'], 3):$newMap = $row['map']; 
	echo "<b>". $row['cTime'] . "</b><br>"
	._("Game Time")		   .": ".$timeh.$timem.$times
	// ._("Map")			   .": ".$newMap."<br>"
	._("Senders Steam IDs").": ".$row['statsendsid'];

	foreach (glob("../replays/*(".$row['id'].").rec") as $filename)
		echo "<br/><a class = 'btn btn-primary' href = '".str_replace("#", "%23", $filename)."'>"._('Download Replay')."</a>";
	?>

	<style>
		.elem {
			border: solid  #6AC5AC 3px;
			position: relative;
		}
		.elem-green > .label, .elem-green > .endlabel{
			background-color: #FDC72F;
		}
		.clearfix:after {
			content: ".";
			display: block;
			height: 0;
			clear: both;
			visibility: hidden;
		}
		.content {
			max-width: 600px;
			margin: 1em auto;
		}
		article img {
			float: left;
			width: 25%;
		}
	</style>
	
	<article class="elem elem-green content clearfix">
	<table class="table table-striped table-hover text-center table-games">
	<thead>
		<tr>
			<!-- <td><?php echo _("Map").": ".$newMap."<br>"?></td> -->
			<td><?php echo _('Players')?></td>
			<td><?php echo _('Races')?></td>
			<td><?php echo _('APM')?><br/></td>
			<td><?php echo _('Result')?></td>
		</tr>
	</thead>

	<?php
	// ".($i==1?("<td rowspan='6'><img class = 'avatar_big' src=".'../images/maps/'.$row['map'].'.jpg'."></td>"):"")."

	for ($i = 1;$i <= $row['type']*2;$i++){
		$player_name_coded = $row["p" . $i];
		$player_apm = $row["apm" . $i . "r"];
		$href = ($player_apm != 0) ? "<a href = 'player.php?name=". $player_name_coded."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($player_name_coded) . "</a>" :  NickDecode::decodeNick($player_name_coded);
		// _("No Data")
		$apm = ($player_apm == 0)?"-":$player_apm;
	    $is_victory = false;
	    for($j=1; $j<=$row['type'];$j++)
	    	if ($row["w" . $j] == $player_name_coded) $is_victory = true;

		echo "<TR>
		<td>" . $href 								  . "</td>
	    <td>" . RaceSwitcher::getRace($row["r" . $i]) . "</td>
	    <td>" . $apm 								  . "</td>
	    <td>" . ($is_victory?_('Winner'):_('Loser'))  . "</td></TR>";
	}
	?>
	</table>
	<img src=<?php echo '../images/maps/'.$row['map'].'.jpg'?>>
	</article>
	
	<!-- <hr style="border-bottom: 1px solid #555;"/> -->

<?php
}

if($res->num_rows == 0){
		echo _("games with such parameters not found");
	}
?>
									