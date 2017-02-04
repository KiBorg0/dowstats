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

if(isset($_GET["name"]))
{
	$name = $_GET["name"];
	$mysqli->real_query("SELECT * FROM games WHERE (p1 = '$name' or p2 = '$name' or p3 = '$name' or p4 = '$name' or p5 = '$name' or p6 = '$name' or p7 = '$name' or p8 = '$name' ) ORDER BY cTime DESC limit {$startFrom}, 10");
}
if(isset($_GET["searchname"]))
{
	$searchname = NickDecode::codeNick($_GET["searchname"]);

	$mysqli->real_query(" SELECT * FROM games WHERE p1 LIKE '%$searchname%' or p2 LIKE '%$searchname%' or p3 LIKE '%$searchname%' or p4 LIKE '%$searchname%' or p5 LIKE '%$searchname%' or p6 LIKE '%$searchname%' or p7 LIKE '%$searchname%' or p8 LIKE '%$searchname%' ORDER BY cTime DESC limit {$startFrom}, 10");
}
else
	$mysqli->real_query("SELECT * FROM games WHERE (p1 = '$name' or p2 = '$name' or p3 = '$name' or p4 = '$name' or p5 = '$name' or p6 = '$name' or p7 = '$name' or p8 = '$name' ) ORDER BY cTime DESC limit {$startFrom}, 10");

$res = $mysqli->use_result();

while ($row = $res->fetch_assoc()) {

	$timehelpint = $row['gTime'] / 60;
	$timehours = intval($timehelpint / 60);
	echo "<b>" . $row['cTime'] . "</b><br>";
	echo "Время игры: " . $timehours . " ч.   " . $timehelpint % 60 .  " мин.   " . $row['gTime'] % 60 . " сек. ";
	if($row['map'][1] == "P")
		$newMap = substr($row['map'], 3); 
	else
		$newMap = $row['map'];
	
	echo "Карта: "  . $newMap . "<br>";
	echo "Steam id отправителей: "  . $row['statsendsid'];
	
	if(file_exists("../replays/".$row['id'].".rec"))
		echo "<br/><a class = 'btn btn-primary' href = 'replays/".$row['id'].".rec'>загрузить повтор</a>";
	else
		echo "<br/>повтор отсутствует";

	$type = $row['type'];

	$winners = array();
	for($i=1; $i<=$type; $i++)
		$winners[] = $row["w".$i];

	echo " <TABLE  class=\"table table-striped table-hover text-center table-games\">";
	echo "<thead><tr>
		<td>игрок</td><td>раса</td><td>апм<br/></td><td>итог</td>
			</tr>
		</thead>";
	for($i=1; $i<=$type*2; $i++)
	{
		echo "<TR>\n";
	    echo " <td><a href = 'http://dowstats.h1n.ru/player.php?name=". $row["p".$i] ."'>" . NickDecode::decodeNick($row["p".$i]) . "</a></td>\n";
	    echo " <td>" . RaceSwitcher::getRace($row["r".$i]) . "</td>\n";
	    if($i==1)
	    	" <td>" . $row["p".$i] . "</td>\n";
	    $apm = ($row["apm".$i."r"] == 0) ? "нет данных" : $row["apm".$i."r"];
	    echo " <td>" . $apm . "</td>\n";

	    if(in_array($row["p".$i], $winners))
			echo " <td>победа</td>\n";
		else
			echo " <td>поражение</td>\n";
	    echo "</TR>\n";
	}
	 echo "</TABLE>\n";
	 echo "<br><br>";
}

?>
									