<?
header('Content-Type: text/html; charset=utf-8');
echo " - скрипт записи статистики начал выполнение\n";
$startmt = microtime(true);

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");

$apm_info = "";

function calculate_and_change_apm($mysqligame, $player, $apm){
	global $apm_info; 
	$mysqligame->real_query("SELECT apm, apm_game_counter FROM players WHERE name = '$player'");
	$res = $mysqligame->store_result();
	$row = $res->fetch_assoc();
	
	$apm_info.= $row['apm'] . "- был<br>";
	$apm_info.= "апм новой игры: " . $apm . " всего игр с апм: " . $row['apm_game_counter'] . "<br/>";
	$apm1new = ($row['apm'] * $row['apm_game_counter'] + $apm) / ($row['apm_game_counter'] + 1);
	$apm_info.= "апм игрока ". NickDecode::decodeNick($player) . " стал: " . $apm1new;
	$apm_info.= "<br/>";
	$apm_info.= "<br/>";
	$mysqligame->real_query("UPDATE players SET apm = '$apm1new', apm_game_counter = apm_game_counter + 1 WHERE  (name = '$player') ");
}

function create_replay_file($last_game_id){
	global $_FILES, $replay_info;
	$replay_info .= $_FILES['replay']['name'];
	$uploaddir =  "replays/";
	$uploadfile = $uploaddir . $last_game_id .".rec";
	$replay_info .= "<a href = \"".$uploadfile."\">скачать реплей</a>";
	if (move_uploaded_file($_FILES['replay']['tmp_name'], $uploadfile)) {
	    echo " - файл реплея с id ".$last_game_id." был успешно сохранен.\n";
	} else {
	    echo " - не удалось загузить реплей с id ".$last_game_id."\n" ;
	}
}

/*
Directory Listing Script - Version 2
====================================
Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net
Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk
$win = $_GET["win"];
$loose = $_GET["loose"];
$percentwin = intval($win/($win + $loose));
*/

$mysqligame = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$mysqligame->set_charset("utf8");
$type = $_GET["type"];

// показывает имена игроков в массиве по индексам, если игрока нет, то NULL
// var_dump($players);

$players = array();
$races = array();
$apmrs = array();
for($i=1; $i<=8; $i++)
{
	$races[] =   isset($_GET["r".$i]) ? $_GET["r".$i] : 0;
    $players[] = isset($_GET["p".$i]) ? $_GET["p".$i] : 0;
    $apmrs[] =   isset($_GET["apm".$i."r"]) ? $_GET["apm".$i."r"] : 0;
}
$winners = array();
for($i=1; $i<=4; $i++)
{
	$winners[] = $_GET["w".$i];
}


$sid = $_GET["sid"];
$map = $_GET["map"];
$winby = $_GET["winby"];
$gTime = $_GET["gtime"];
$mod = $_GET["mod"];
$key = $_GET["key"];
$cTimeMAX = date('Y-m-d H:i:s', time()-120);

//--------------

if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	return;
}

if(strtolower($winby) == strtolower("Disconnect")){
	echo " - статистика не была записана, причина: Disconnect\n";
	return;
}


//-----------обновляем аватарку в стиме ----------------
$avatar_url = Steam::get_avatar_url_by_id($sid);
$mysqligame->real_query("UPDATE players SET avatar_url = '$avatar_url' WHERE sid = '$sid'");


$ipCurrent = $_SERVER['REMOTE_ADDR'];

$mysqligame->real_query("SELECT * FROM ipBans WHERE ipBansstr = '$ipCurrent' LIMIT 1");
$res = $mysqligame->store_result();
// $isFound = false;
// while ($row = $res->fetch_assoc()) {
// 	//если ip игрока есть в бан листе, то скрипт останавливается
// 	exit();
// 	return;
// }

//-----------проверяем на наличие такой же игры с этого IP минуту назад, если есть то баним
// $ipreal = $_SERVER['REMOTE_ADDR'];
// $mysqligame->real_query("SELECT * FROM games WHERE ( '$ipreal' = ipreal  AND '$cTimeMAX' < cTime) LIMIT 1");
// $res = $mysqligame->store_result();
// $isFound = false;
// while ($row = $res->fetch_assoc()) {
// 	$isFound = true;
// }

// if($isFound == true){
// 	//$mysqligame->real_query("INSERT INTO ipBans (ipBansstr) values ('$ipreal')  ");
// }


//-----Записываем игру
$mysqligame->real_query("SELECT * FROM games WHERE (p1 = '".$players[0]."' AND p2 = '".$players[0]."'  AND '$cTimeMAX' < cTime)");
$res = $mysqligame->store_result();

// проверим, нет ли такой игры в базе
$isFound = false;
while ($row = $res->fetch_assoc()) {

	$ipnew = $row['statsendsid'] . ", " . $sid;

	for($i = 1; $i < 9; $i++){
		$varname = "apm" . $i . "r";
		if ($row[$varname] != 0) $$varname = 0;
	}

	$mysqligame2 = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
	$mysqligame2->real_query("UPDATE games SET statsendsid = '$ipnew', w1 = '".$winners[0]."',apm1r = apm1r + '".$apmrs[0]."',apm2r = apm2r + '".$apmrs[1]."',apm3r = apm3r + '".$apmrs[2]."',apm4r = apm4r + '".$apmrs[3]."',apm5r = apm5r + '".$apmrs[4]."',apm6r = apm6r + '".$apmrs[5]."',apm7r = apm7r + '".$apmrs[6]."',apm8r = apm8r + '".$apmrs[7]."'  WHERE (p1 = '".$players[0]."' AND p2 = '".$players[0]."'  AND '$cTimeMAX' < cTime)");
	$isFound = true;
}

// обновим апм у игроков
for($i=1; $i<=$type*2; $i++)
	if($apmrs[$i-1]!=0)
		calculate_and_change_apm($mysqligame, $players[$i-1], $apmrs[$i-1]);

// если такая игра не найдена, то запишем ее в базу
if(!$isFound)
{
	// echo "тип - ".$type."\n";
	//----------записываем игру в базу-------------
	date_default_timezone_set( 'Europe/Moscow' );
	$date = date('Y-m-d H:i:s', time());

	$ipreal = $_SERVER['REMOTE_ADDR'];

	$insert_str = "type,";
	$values_str = "'$type', ";
	for($i=1; $i<=$type*2; $i++)
	{
		$values_str .= "'" . $players[$i-1]. "', ";
		$insert_str .= "p".$i.",";
	}
	for($i=1; $i<=$type; $i++)
	{
		$values_str .= "'" . $winners[$i-1] . "', ";
		$insert_str .= "w".$i.",";
	}
	for($i=1; $i<=$type*2; $i++)
	{
		$values_str .= "'" . $races[$i-1] . "', ";
		$insert_str .= "r".$i.",";
	}
	for($i=1; $i<=$type*2; $i++)
	{
		$values_str .= "'" . $apmrs[$i-1] . "', ";
		$insert_str .= "apm".$i."r,";
	}
	$insert_str .= "map,gTime,cTime,statsendsid, game_mod, ipreal";
	$values_str .= "'$map','$gTime','$date','$sid','$mod','$ipreal'" ;
	// echo $insert_str . " - " . $values_str . "<br/>";
	$mysqligame->real_query("INSERT INTO games (".$insert_str.") VALUES (".$values_str.")");

	echo " - запись игры в базу завершена\n";
	create_replay_file($mysqligame->insert_id);
	// echo " - отработал скрипт расчёта реплея\n";

	//-------записываем апм, победу и поражение в базу---------
	for($i=1; $i<=$type*2; $i++){
		$mysqligame->real_query("UPDATE players SET ".$type."x".$type."_".$races[$i-1]." = ".$type."x".$type."_".$races[$i-1]." + 1, time = time + $gTime  WHERE (name = '".$players[$i-1]."' )");
		if(in_array($players[$i-1], $winners))
        	$mysqligame->real_query("UPDATE players SET ".$type."x".$type."_".$races[$i-1]."w = ".$type."x".$type."_".$races[$i-1]."w + 1  WHERE (name = '".$players[$i-1]."')");
	}

	//-----------------запись рейтинга---------------------------------------
	if($type == 1){
		$isFoundPlayers = true;
		$mmrs = array();
		for($i=0;$i<2;$i++)
		{
		    $mysqligame->real_query("SELECT * FROM players WHERE name = '".$players[$i]."'");
			$res = $mysqligame->store_result();
			if(!$row = $res->fetch_assoc())
				$isFoundPlayers = false;
			else
			{
				$mmrs[] = 1500;
				$mmrs[$i] = $row['mmr'] ;
				$apm_info .= "<br/> расчет рейтинга:<br/> рейтинг до: ".$players[$i]." - " . $mmrs[$i];
			}
		}
		// if($isFoundPlayers){
		// 	for($i=0;$i<2;$i++)
		// 		if(in_array($players[$i], $winners))
		// 		{
				$amb = $mmrs[1] - $mmrs[0];
				$ea = 1/(1 + pow( 10 , $amb/400 ));
				$f1 = round(50*(1 - $ea));
				
				if(in_array($players[0], $winners))
				{
					$apm_info .= "<br/> разница в рейтинге: " .$amb. "; вероятность победы игрока: " . $ea . "; итоговое изменение рейтинга: " . $f1 . "<br/>";
					$mysqligame->real_query("UPDATE players SET mmr = '".$mmrs[0]."' + '$f1'  WHERE name = '".$players[0]."'");
					$mysqligame->real_query("UPDATE players SET mmr = '".$mmrs[1]."' - '$f1'  WHERE name = '".$players[1]."'");
				}
				$amb = $mmrs[0] - $mmrs[1];
				$ea = 1/(1 + pow( 10 , $amb/400 ));
				$f1 = round(50*(1 - $ea));

				if(in_array($players[1], $winners))
				{
					$apm_info .= "<br/> разница в рейтинге: " .$amb. "; вероятность победы игрока: " . $ea . "; итоговое изменение рейтинга: " . $f1 . "<br/>";
					$mysqligame->real_query("UPDATE players SET mmr = '".$mmrs[1]."' + '$f1'  WHERE name = '".$players[1]."'");
					$mysqligame->real_query("UPDATE players SET mmr = '".$mmrs[0]."' - '$f1'  WHERE name = '".$players[0]."'");
				}
				
		
	}
};

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");

$stopmt = microtime(true) - $startmt;
echo " - конец скрипта, время выполнения записи: " . $stopmt;

?>