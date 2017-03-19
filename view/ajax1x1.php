<?php
require_once("../lib/NickDecode.php");
require_once("../lib/RaceSwitcher.php");

$lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
putenv('LC_ALL=' . $lang);
setlocale(LC_ALL, $lang, $lang . '.utf8');
bind_textdomain_codeset($lang, 'UTF-8');
bindtextdomain($lang, '../locale');
textdomain($lang);

function get_table_header_by_sort_type($sort_type){
?>
<TABLE   class="table table-striped table-hover text-center">
  <thead><tr>
    <td style = "width:5%;"><?php echo _('Number')?></td>
    <td style = "width:10%;"><?php echo _('Avatar')?></td>
    <td style = "width:15%;"><a id = "sort_by_player" href = "#"><?php echo _('Player').' ';if($sort_type == "player") echo "&#8595;"?>
    </a></td>
    <td style = "width:15%;"><a id = "sort_by_allgames" href = "#"><?php echo _('Number of Games').' ';if($sort_type == "allgames") echo "&#8595;"?>  </a></td>
    <td style = "width:15%;"><a id = "sort_by_wins" href = "#"><?php echo _('Victories').' ';if($sort_type == "wins") echo "&#8595;"?>
    </a></td>
    <td style = "width:15%;"><a id = "sort_by_pwins" href = "#"><?php echo _('Win Rate').' ';if($sort_type == "pwins") echo "&#8595;"?>
	  </a></td>
    <td style = "width:15%;"><?php echo _('Favorite Race').' '?></td>
    <td style = "width:10%;"	><a id = "sort_by_mmr" href = "#">SOLO MMR <?php if($sort_type == "mmr") echo "&#8595;" ?>
    </a></td>
  </tr></thead>

<?php
}

// header("Content-type: text/txt; charset=UTF-8");
?>
<script type="text/javascript" src="js/1x1.js"></script>

<?php
//----------соединение с базой--------------------
$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");

//----------тип запроса на вывод-----------------------
$r_type = isset($_GET['race'])?$_GET['race']:0;//если идет запрос от сортировки, а не от верхней панели, то тип статистики(общая, СМ, хаос и т.д) берется отсюда
$sort_type = isset($_GET['sort'])?$_GET['sort']:"mmr";

$searchname = isset($_GET['playername'])?$_GET['playername']:"";

//----------информация для дальнейшей сортировки-------------
?>
<span style = "display:none" id = "request_type_info"><?php echo $r_type; ?></span>
<span style = "display:none" id = "sort_type_info"><?php echo $sort_type; ?></span>

<?php

// echo ($r_type!=0)?"<h3>".RaceSwitcher::getRace($r_type)." 1x1</h3>":"<h3>"._('General stats')." 1x1</h3>";

if($r_type==0)
	$mysqli->real_query("SELECT SUM(1x1_1) + SUM(1x1_2)+ SUM(1x1_3)+ SUM(1x1_4)+ SUM(1x1_5)+ SUM(1x1_6)+ SUM(1x1_7)+ SUM(1x1_8)+ SUM(1x1_9) AS allsum, SUM(1x1_1w) + SUM(1x1_2w)+ SUM(1x1_3w)+ SUM(1x1_4w)+ SUM(1x1_5w)+ SUM(1x1_6w)+ SUM(1x1_7w)+ SUM(1x1_8w)+ SUM(1x1_9w) AS allsumwin FROM players ORDER BY time DESC");
else
	$mysqli->real_query("SELECT SUM(1x1_".$r_type.") AS allsum, SUM(1x1_".$r_type."w) AS allsumwin FROM players ORDER BY time DESC");

$res = $mysqli->store_result();
$res = $res->fetch_assoc();
$Wnr8 =  ($res["allsum"]!=0)?round (100 * $res["allsumwin"]/$res["allsum"]):0;
echo _("Win Rate").": ". $Wnr8 . "%";


?>
<br/>
<div class="navbar-form navbar-left" style="width:400px;">
	<div class="form-group ">
	    <input id="player_name_input" onkeypress=" player_name_input_keypress1x1(event)" style="width:300px;" class="form-control" placeholder=<?php echo "'"._("Find by player name/clan name")."'"?>>
	</div>
	<a class="btn btn-default" id = "search_player" ><span class="glyphicon glyphicon-search"></span></a>
</div>
<?php


echo get_table_header_by_sort_type($sort_type);
$searchname = $searchname!=""?NickDecode::codeNick($searchname):"";
$searchcondition = $searchname!=""?"WHERE name LIKE '%$searchname%'":"";
if($r_type == 0)
	switch ($sort_type) {
		case "allgames":
			$mysqli->real_query("SELECT *, 1x1_1 + 1x1_2 + 1x1_3 + 1x1_4 + 1x1_5 + 1x1_6 + 1x1_7 + 1x1_8 + 1x1_9 AS allsum FROM players ".$searchcondition." ORDER BY allsum DESC");
		case "wins":
			$mysqli->real_query("SELECT *, 1x1_1w + 1x1_2w + 1x1_3w + 1x1_4w + 1x1_5w + 1x1_6w + 1x1_7w + 1x1_8w + 1x1_9w AS allwins FROM players ".$searchcondition." ORDER BY allwins DESC");
		case "pwins":
			$mysqli->real_query("SELECT *,(1x1_1w + 1x1_2w + 1x1_3w + 1x1_4w + 1x1_5w + 1x1_6w + 1x1_7w + 1x1_8w + 1x1_9w)/(1x1_1 + 1x1_2 + 1x1_3 + 1x1_4 + 1x1_5 + 1x1_6 + 1x1_7 + 1x1_8 + 1x1_9) AS allsum FROM players ".$searchcondition." ORDER BY allsum DESC");
		case "mmr":
			$mysqli->real_query("SELECT * FROM players ".$searchcondition." ORDER BY ".$sort_type." DESC");
			break;
		case "name":
			$mysqli->real_query("SELECT * FROM players ".$searchcondition." ORDER BY ".$sort_type." ASC");
			break;
	}
else
	switch ($sort_type) {
		case "allgames":
			$mysqli->real_query("SELECT * FROM players ".$searchcondition." ORDER BY 1x1_".$r_type." DESC");
			break;
		case "wins":
			$mysqli->real_query("SELECT * FROM players ".$searchcondition." ORDER BY 1x1_".$r_type."w DESC");
			break;
		case "pwins":
			$mysqli->real_query("SELECT *,(1x1_".$r_type."w)/(1x1_".$r_type.") AS percent FROM players ORDER BY percent DESC");
			break;
		case "mmr":
			$mysqli->real_query("SELECT * FROM players ".$searchcondition." ORDER BY ".$sort_type." DESC");
			break;
		case "name":
			$mysqli->real_query("SELECT * FROM players ".$searchcondition." ORDER BY ".$sort_type." ASC");
			break;
	}


$res = $mysqli->store_result();
$number = 0;
while ($row = $res->fetch_assoc()) {
	$favRace = 0;
	$countGamesForRace = 0;
	for($i=1; $i<=9; $i++)
		if($countGamesForRace <  $row['1x1_'.$i])
		{
			$favRace = $i;
			$countGamesForRace = $row['1x1_'.$i];
		}
	$all = 0;
	$win = 0;
	for($i=(($r_type==0)?1:$r_type);$i<=(($r_type==0)?9:$r_type);$i++)
	{
		$all += $row['1x1_'.$i];
		$win += $row['1x1_'.$i.'w'];
	}
	if($all!=0)
	{
		$number++;
		echo "<tr>"
		."<td>" . $number 						 .  "</td>"
		."<td><a href = 'player.php?sid=". $row['sid']."&lang=".$lang."#tab0'><img class = 'avatar' src='" . $row['avatar_url'] . "'></a></td>"
		."<td><a href = 'player.php?sid=". $row['sid']."&lang=".$lang."#tab0'>" . NickDecode::decodeNick($row['name']) . "</a></td>"
		."<td>" . $all				  		     .  "</td>"
		."<td>" . $win			  				 .  "</td>"
		."<td>" . round(100 * $win/$all)		 . "%</td>"
		."<td>" . RaceSwitcher::getRace($favRace).  "</td>"
		."<td>" . $row['mmr']  					 .  "</td></tr>";
	}
}
echo "</TABLE>";
?>
