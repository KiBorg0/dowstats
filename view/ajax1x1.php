<?php
$timeinfo = "";
$startmt = microtime(true);
require_once("../lib/NickDecode.php");

function getRace($num){
	switch($num){
		case 1:
			return "Космодесант";
			break;
		case 2:
			return "Хаос";
			break;
		case 3:
			return "Орки";
			break;
		case 4:
			return "Эльдары";
			break;
		case 5:
			return "Имперская гвардия";
			break;
		case 6:
			return "Некроны";
			break;
		case 7:
			return "Империя Тау";
			break;
		case 8:
			return "Сёстры битвы";
			break;
		case 9:
			return "Темные эльдары";
			break;
	}
}

function get_title_by_request_type($r_type){
	switch($r_type){
		case "all":
			return "<h3>Общая статистика 1x1</h3>";
			break;
		case "1":
			return "<h3>Космодесант 1х1</h3>";
			break;
		case "2":
			return "<h3>Хаос 1х1</h3>";
			break;
		case "3":
			return "<h3>Орки 1х1</h3>";
			break;
		case "4":
			return "<h3>Эльдары 1х1</h3>";
			break;
		case "5":
			return "<h3>Имперская гвардия 1х1</h3>";
			break;
		case "6":
			return "<h3>Некроны 1х1</h3>";
			break;
		case "7":
			return "<h3>Империя Тау 1х1</h3>";
			break;
		case "8":
			return "<h3>Сёстры битвы 1х1</h3>";
			break;
		case "9":
			return "<h3>Темные эльдары 1х1</h3>";
			break;
	}
}

function calculate_and_show_winrate($r_type){
	global $mysqli;
	switch($r_type){
		case "all":
			$mysqli->real_query("SELECT SUM(1x1_1) + SUM(1x1_2)+ SUM(1x1_3)+ SUM(1x1_4)+ SUM(1x1_5)+ SUM(1x1_6)+ SUM(1x1_7)+ SUM(1x1_8)+ SUM(1x1_9) AS allsum, SUM(1x1_1w) + SUM(1x1_2w)+ SUM(1x1_3w)+ SUM(1x1_4w)+ SUM(1x1_5w)+ SUM(1x1_6w)+ SUM(1x1_7w)+ SUM(1x1_8w)+ SUM(1x1_9w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "общий процент побед: " . $Wnr8 . "%";
			break;
		case "1":
			$mysqli->real_query("SELECT SUM(1x1_1) AS allsum, SUM(1x1_1w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед космодесанта 1х1: " . $Wnr8 . "%";
			break;
		case "2":
			$mysqli->real_query("SELECT SUM(1x1_2) AS allsum, SUM(1x1_2w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед хаоса 1х1: " . $Wnr8 . "%";
			break;
		case "3":
			$mysqli->real_query("SELECT SUM(1x1_3) AS allsum, SUM(1x1_3w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед орков 1х1: " . $Wnr8 . "%";
			break;
		case "4":
			$mysqli->real_query("SELECT SUM(1x1_4) AS allsum, SUM(1x1_4w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед эльдаров 1х1: " . $Wnr8 . "%";
			break;
		case "5":
			$mysqli->real_query("SELECT SUM(1x1_5) AS allsum, SUM(1x1_5w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед ИГ 1х1: " . $Wnr8 . "%";
			break;
		case "6":
			$mysqli->real_query("SELECT SUM(1x1_6) AS allsum, SUM(1x1_6w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед некронов 1х1: " . $Wnr8 . "%";
			break;
		case "7":
			$mysqli->real_query("SELECT SUM(1x1_7) AS allsum, SUM(1x1_7w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед тау 1х1: " . $Wnr8 . "%";
			break;
		case "8":
			$mysqli->real_query("SELECT SUM(1x1_8) AS allsum, SUM(1x1_8w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед сестёр 1х1: " . $Wnr8 . "%";
			break;
		case "9":
			$mysqli->real_query("SELECT SUM(1x1_9) AS allsum, SUM(1x1_9w) AS allsumwin FROM players ORDER BY time DESC");
        	$res = $mysqli->use_result();
        	$res = $res->fetch_assoc();
        	$Wnr8 =  50;
			if($res["allsum"] != 0){
				$Wnr8 =  round (100 * $res["allsumwin"]/$res["allsum"]);
			}
        	return "процент побед ТЭ 1х1: " . $Wnr8 . "%";
			break;
	}
}

function make_query($sort_type, $searchname,$request_type){

	global $mysqli;
	if($searchname != ""){
		$searchname = NickDecode::codeNick($searchname);
		$mysqli->real_query("SELECT * FROM players WHERE name LIKE '%$searchname%' ORDER BY mmr DESC");
	}
	else{
		if($sort_type == "mmr"){
			$mysqli->real_query("SELECT * FROM players ORDER BY mmr DESC");
		}else if($sort_type == "player"){
			$mysqli->real_query("SELECT * FROM players ORDER BY name DESC");
		}

		if($request_type == "all"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT *, 1x1_1 + 1x1_2 + 1x1_3 + 1x1_4 + 1x1_5 + 1x1_6 + 1x1_7 + 1x1_8 + 1x1_9 AS allsum FROM players ORDER BY allsum DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT *, 1x1_1w + 1x1_2w + 1x1_3w + 1x1_4w + 1x1_5w + 1x1_6w + 1x1_7w + 1x1_8w + 1x1_9w AS allwins FROM players ORDER BY allwins DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_1w + 1x1_2w + 1x1_3w + 1x1_4w + 1x1_5w + 1x1_6w + 1x1_7w + 1x1_8w + 1x1_9w)/(1x1_1 + 1x1_2 + 1x1_3 + 1x1_4 + 1x1_5 + 1x1_6 + 1x1_7 + 1x1_8 + 1x1_9) AS allsum FROM players ORDER BY allsum DESC");
			}
		}

		if($request_type == "1"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_1 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_1w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_1w)/(1x1_1) AS percent FROM players ORDER BY percent DESC");
			}
		}

		if($request_type == "2"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_2 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_2w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_2w)/(1x1_2) AS percent FROM players ORDER BY percent DESC");
			}
		}

		if($request_type == "3"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_3 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_3w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_3w)/(1x1_3) AS percent FROM players ORDER BY percent DESC");
			}
		}

		if($request_type == "4"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_4 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_4w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_4w)/(1x1_4) AS percent FROM players ORDER BY percent DESC");
			}
		}

		if($request_type == "5"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_5 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_5w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_5w)/(1x1_5) AS percent FROM players ORDER BY percent DESC");
			}
		}

		if($request_type == "6"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_6 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_6w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_6w)/(1x1_6) AS percent FROM players ORDER BY percent DESC");
			}
		}

		if($request_type == "7"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_7 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_7w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_7w)/(1x1_7) AS percent FROM players ORDER BY percent DESC");
			}
		}

		if($request_type == "8"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_8 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_8w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_8w)/(1x1_8) AS percent FROM players ORDER BY percent DESC");
			}
		}

		if($request_type == "9"){
			if($sort_type == "allgames"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_9 DESC");
			} else if($sort_type == "wins"){
				$mysqli->real_query("SELECT * FROM players ORDER BY 1x1_9w DESC");
			} else if($sort_type == "pwins"){
				$mysqli->real_query("SELECT *,(1x1_9w)/(1x1_9) AS percent FROM players ORDER BY percent DESC");
			}
		}
	}
}
//на вход этой функции подается строка БД игрока
function calculate_fav_race($row){
	$favRace = 0;
	$countWinRace = 0;
	if($countWinRace <  $row['1x1_1']){
		$favRace = 1;
		$countWinRace = $row['1x1_1'] ;
	}
	if($countWinRace <  $row['1x1_2'] ){
		$favRace = 2;
		$countWinRace = $row['1x1_2'] ;
	}
	if($countWinRace <  $row['1x1_3'] ){
		$favRace = 3;
		$countWinRace = $row['1x1_3'] ;
	}
	if($countWinRace <  $row['1x1_4'] ){
		$favRace = 4;
		$countWinRace = $row['1x1_4'] ;
	}
	if($countWinRace <  $row['1x1_5']){
		$favRace = 5;
		$countWinRace = $row['1x1_5'];
	}
	if($countWinRace <  $row['1x1_6'] ){
		$favRace = 6;
		$countWinRace = $row['1x1_6'] ;
	}
	if($countWinRace <  $row['1x1_7'] ){
		$favRace = 7;
		$countWinRace = $row['1x1_7'] ;
	}
	if($countWinRace <  $row['1x1_8']){
		$favRace = 8;
		$countWinRace = $row['1x1_8'] ;
	}
	if($countWinRace <  $row['1x1_9'] ){
		$favRace = 9;
		$countWinRace = $row['1x1_9'];
	}
	return $favRace;
}

function get_table_header_by_sort_type($sort_type){
?><TABLE   class="table table-striped table-hover text-center">
	<thead>
	<tr>
		<td>аватар</td>
		<td><a id = "sort_by_player" href = "#">
			игрок <?php if ($sort_type == "player") echo "&#8595;" ?>
		</a></td>
		<td><a id = "sort_by_allgames" href = "#">
			всего игр <?php if ($sort_type == "allgames") echo "&#8595;" ?>
		</a></td>
		<td><a id = "sort_by_wins" href = "#">
			побед <?php if ($sort_type == "wins") echo "&#8595;" ?>
		</a></td>
		<td><a id = "sort_by_pwins" href = "#">
			% побед <?php if ($sort_type == "pwins") echo "&#8595;" ?>
		</a></td>
		<td>любимая раса</td>
		<td><a id = "sort_by_mmr" href = "#">
			SOLO MMR <?php if ($sort_type == "mmr") echo "&#8595;" ?>
		</a></td>
	</tr>
	</thead>
<?php
}

header("Content-type: text/txt; charset=UTF-8");
?>
<script type="text/javascript" src="js/1x1.js"></script>
<?php
//----------соединение с базой--------------------
$startmt1 = microtime(true);
$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$endmt1 = microtime(true) - $startmt1;
$timeinfo .= "Соединение с базой - " . $endmt1 . "<br/>";

//----------тип запроса на вывод-----------------------
if(isset($_GET['request_type'])){
	$request_type = $_GET['request_type'];//если идет запрос от сортировки, а не от верхней панели, то тип статистики(общая, СМ, хаос и т.д) берется отсюда
}
if(isset($_GET['all1x1'])) $request_type = "all";
if(isset($_GET['11x1'])) $request_type = "1";
if(isset($_GET['21x1'])) $request_type = "2";
if(isset($_GET['31x1'])) $request_type = "3";
if(isset($_GET['41x1'])) $request_type = "4";
if(isset($_GET['51x1'])) $request_type = "5";
if(isset($_GET['61x1'])) $request_type = "6";
if(isset($_GET['71x1'])) $request_type = "7";
if(isset($_GET['81x1'])) $request_type = "8";
if(isset($_GET['91x1'])) $request_type = "9";
if(isset($_GET['sort'])){
	$sort_type = $_GET['sort'];
}else{
	if(isset($_GET['all1x1'])){$sort_type = "mmr";} else {$sort_type = "pwins";}
}
$searchname = "";
if(isset($_GET['playername'])){
	$searchname = $_GET['playername'];
}

//----------информация для дальнейшей сортировки-------------
?>
<span style = "display:none" id = "request_type_info"><?php echo $request_type; ?></span>
<span style = "display:none" id = "sort_type_info"><?php echo $sort_type; ?></span>

<?php


echo get_title_by_request_type($request_type);
$startmt1 = microtime(true);
echo calculate_and_show_winrate($request_type);
$endmt1 = microtime(true) - $startmt1;
$timeinfo .= "Расчёт винрейта - " . $endmt1 . "<br/>";

?>
<br/>
<div class="navbar-form navbar-left" style="width:400px;">
	<div class="form-group ">
	    <input id="player_name_input" onkeypress=" player_name_input_keypress1x1(event)" style="width:300px;" class="form-control" placeholder="Поиск по имени игрока/клана">
	</div>
	<a class="btn btn-default" id = "search_player" ><span class="glyphicon glyphicon-search"></span></a>
</div>
<?php


echo get_table_header_by_sort_type($sort_type);
make_query($sort_type,$searchname,$request_type);




if($request_type == "all") {
		
	          
		$res = $mysqli->use_result();
		$startmt1 = microtime(true);

        while ($row = $res->fetch_assoc()) {
			echo "<tr>";
			echo "<td>";
				echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
				echo "</td>";
			echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
			$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
			$all = $all1x1;

			$win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
			$win = $win1x1;

			echo "<td>" . $all . "</td>";
			echo "<td>" . $win . "</td>";
			if($all!= 0){
				echo "<td>" . round(100 * $win/$all) . "%</td>";
			}else{
				echo "<td>" . 0 . "</td>";
			};


			echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
			echo "<td>" .  $row['mmr'] . "</td>";
			echo "</tr>";
			echo "</tr>";
		}
		$endmt1 = microtime(true) - $startmt1;
		$timeinfo .= "Вывод всех игроков - " . $endmt1;
		echo "
			</TABLE>";
}

if($request_type == "1") {		
		$res = $mysqli->use_result();
        while ($row = $res->fetch_assoc()) {
			echo "<tr>";
			echo "<td>";
				echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
				echo "</td>";
			echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
			$all = $row['1x1_1'];

			$win = $row['1x1_1w'] ;

			echo "<td>" . $all . "</td>";
			echo "<td>" . $win . "</td>";
			if($all!= 0){
				echo "<td>" . round(100 * $win/$all) . "%</td>";
			}else{
				echo "<td>" . 0 . "</td>";
			};
			echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
			echo "<td>" .  $row['mmr'] . "</td>";

			echo "</tr>";
		}
		echo "
			</TABLE>";
	
}
if($request_type == "2") {
	$res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
		echo "<tr>";
		echo "<td>";
			echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
			echo "</td>";
		echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
		$all = $row['1x1_2'] ;

		$win = $row['1x1_2w'] ;

		echo "<td>" . $all . "</td>";
		echo "<td>" . $win . "</td>";
		if($all!= 0){
			echo "<td>" . round(100 * $win/$all) . "%</td>";
		}else{
			echo "<td>" . 0 . "</td>";
		};
		echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
		echo "<td>" .  $row['mmr'] . "</td>";
		echo "</tr>";
	}
	echo "</TABLE>";

}

if($request_type == "3") {      
	$res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
		echo "<tr>";
		echo "<td>";
			echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
			echo "</td>";
		echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
		$all = $row['1x1_3'] ;

		$win = $row['1x1_3w'] ;

		echo "<td>" . $all . "</td>";
		echo "<td>" . $win . "</td>";
		if($all!= 0){
			echo "<td>" . round(100 * $win/$all) . "%</td>";
		}else{
			echo "<td>" . 0 . "</td>";
		};
		echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
		echo "<td>" .  $row['mmr'] . "</td>";
		echo "</tr>";
	}
	echo "</TABLE>";
}

if($request_type == "4") {     
	$res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
		echo "<tr>";
		echo "<td>";
			echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
			echo "</td>";
		echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
		$all = $row['1x1_4'];

		$win = $row['1x1_4w'];

		echo "<td>" . $all . "</td>";
		echo "<td>" . $win . "</td>";
		if($all!= 0){
			echo "<td>" . round(100 * $win/$all) . "%</td>";
		}else{
			echo "<td>" . 0 . "</td>";
		};
		echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
		echo "<td>" .  $row['mmr'] . "</td>";
		echo "</tr>";
	}
	echo "</TABLE>";
}

if($request_type == "5") {     
	$res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
		echo "<tr>";
		echo "<td>";
			echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
			echo "</td>";
		echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
		$all = $row['1x1_5'] ;

		$win = $row['1x1_5w'] ;

		echo "<td>" . $all . "</td>";
		echo "<td>" . $win . "</td>";
		if($all!= 0){
			echo "<td>" . round(100 * $win/$all) . "%</td>";
		}else{
			echo "<td>" . 0 . "</td>";
		};
		echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
		echo "<td>" .  $row['mmr'] . "</td>";
		echo "</tr>";
	}
	echo "</TABLE>";
}

if($request_type == "6") {     
	$res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
		echo "<tr>";
		echo "<td>";
			echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
			echo "</td>";
		echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
		$all = $row['1x1_6'] ;

		$win = $row['1x1_6w'] ;

		echo "<td>" . $all . "</td>";
		echo "<td>" . $win . "</td>";
		if($all!= 0){
			echo "<td>" . round(100 * $win/$all) . "%</td>";
		}else{
			echo "<td>" . 0 . "</td>";
		};
		echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
		echo "<td>" .  $row['mmr'] . "</td>";
		echo "</tr>";
	}
	echo "</TABLE>";
}

if($request_type == "7") {     
	$res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
		echo "<tr>";
		echo "<td>";
			echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
			echo "</td>";
		echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
		$all = $row['1x1_7'] ;

		$win = $row['1x1_7w'];

		echo "<td>" . $all . "</td>";
		echo "<td>" . $win . "</td>";
		if($all!= 0){
			echo "<td>" . round(100 * $win/$all) . "%</td>";
		}else{
			echo "<td>" . 0 . "</td>";
		};
		echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
		echo "<td>" .  $row['mmr'] . "</td>";
		echo "</tr>";
	}
	echo "</TABLE>";
}

if($request_type == "8") {
	$res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
		echo "<tr>";
		echo "<td>";
			echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
			echo "</td>";
		echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
		$all = $row['1x1_8'] ;

		$win = $row['1x1_8w'] ;

		echo "<td>" . $all . "</td>";
		echo "<td>" . $win . "</td>";
		if($all!= 0){
			echo "<td>" . round(100 * $win/$all) . "%</td>";
		}else{
			echo "<td>" . 0 . "</td>";
		};
		echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
		echo "<td>" .  $row['mmr'] . "</td>";
		echo "</tr>";
	}
	echo "</TABLE>";
}

if($request_type == "9") {
	$res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
		echo "<tr>";
		echo "<td>";
			echo "<img class = 'avatar' src='" . $row['avatar_url'] . "'>";
			echo "</td>";
		echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row['name'] ."'>" . NickDecode::decodeNick($row['name']) . "</a></td>";
		$all = $row['1x1_9'];

		$win = $row['1x1_9w'] ;

		echo "<td>" . $all . "</td>";
		echo "<td>" . $win . "</td>";
		if($all!= 0){
			echo "<td>" . round(100 * $win/$all) . "%</td>";
		}else{
			echo "<td>" . 0 . "</td>";
		};
		echo "<td>" . getRace(calculate_fav_race($row)) . "</td>";
		echo "<td>" .  $row['mmr'] . "</td>";
		echo "</tr>";
	}
	echo "</TABLE>";

}
$stopmt = microtime(true) - $startmt;
echo "общее время расчёта: " . $stopmt . "</br>" . $timeinfo;
?>
