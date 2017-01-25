<?
echo " - скрипт записи статистики начал выполнение\n";
$startmt = microtime(true);
header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");

$apm_info = "";

function calculate_and_change_apm($mysqligame, $player,$apm){
	global $apm_info; 
	$mysqligame->real_query("SELECT apm, apm_game_counter FROM players WHERE name = '$player'");
	$res = $mysqligame->store_result();
	$row = $res->fetch_assoc();
	
	$apm_info.= $row['apm'] . "- был<br>";
	$apm_info.= "апм новой игры: " . $apm . " всего игр с апм: " . $row['apm_game_counter'] . "<br/>";
	$apm1new = ($row['apm'] * $row['apm_game_counter'] + $apm) / ($row['apm_game_counter'] + 1);
	$apm_info.= "апм игрока ". $player . " стал: " . $apm1new;
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
$percentwin = round($win/($win + $loose));
*/

$mysqligame = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$mysqligame->set_charset("utf8");
$type = $_GET["type"];

$p1 = $_GET["p1"];
$p2 = $_GET["p2"];
$p3 = $_GET["p3"];
$p4 = $_GET["p4"];
$p5 = $_GET["p5"];
$p6 = $_GET["p6"];
$p7 = $_GET["p7"];
$p8 = $_GET["p8"];

$r1 = $_GET["r1"];
$r2 = $_GET["r2"];
$r3 = $_GET["r3"];
$r4 = $_GET["r4"];
$r5 = $_GET["r5"];
$r6 = $_GET["r6"];
$r7 = $_GET["r7"];
$r8 = $_GET["r8"];

$w1 = $_GET["w1"];
$w2 = $_GET["w2"];
$w3 = $_GET["w3"];
$w4 = $_GET["w4"];

$races = array();
for($i=1; $i<=9; $i++)
{
	$races[] = $_GET["r".$i];
}
$players = array();
for($i=1; $i<9; $i++)
{
	$players[] = $_GET["p".$i];
}
// показывает имена игроков в массиве по индексам, если игрока нет, то NULL
// var_dump($players);

$winners = array();
for($i=1; $i<5; $i++)
{
	$winners[] = $_GET["w".$i];
}

$apm1r = isset($_GET["apm1r"]) ? $_GET["apm1r"] : 0;
$apm2r = isset($_GET["apm2r"]) ? $_GET["apm2r"] : 0;
$apm3r = isset($_GET["apm3r"]) ? $_GET["apm3r"] : 0;
$apm4r = isset($_GET["apm4r"]) ? $_GET["apm4r"] : 0;
$apm5r = isset($_GET["apm5r"]) ? $_GET["apm5r"] : 0;
$apm6r = isset($_GET["apm6r"]) ? $_GET["apm6r"] : 0;
$apm7r = isset($_GET["apm7r"]) ? $_GET["apm7r"] : 0;
$apm8r = isset($_GET["apm8r"]) ? $_GET["apm8r"] : 0;

$apmrs = array();
for($i=1; $i<9; $i++)
{
	$apmrs[] = isset($_GET["apm".$i."r"]) ? $_GET["apm".$i."r"] : 0;
}

$sid = $_GET["sid"];
$map = $_GET["map"];
$winby = $_GET["winby"];
$gTime = $_GET["gtime"];
$mod = $_GET["mod"];
$key = $_GET["key"];
$cTimeMAX = date('Y-m-d H:i:s', time()-120);


/*песочница*/
/*apm1*/




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
$isFound = false;
while ($row = $res->fetch_assoc()) {
	//если ip игрока есть в бан листе, то скрипт останавливается
	exit();
	return;
}

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
$mysqligame->real_query("SELECT * FROM games WHERE (p1 = '$p1' AND p2 = '$p2'  AND '$cTimeMAX' < cTime)");
$res = $mysqligame->store_result();

$isFound = false;
while ($row = $res->fetch_assoc()) {

	$ipnew = $row['statsendsid'] . ", " . $sid;

	for($i = 1; $i < 9; $i++){
		$varname = "apm" . $i . "r";
		if ($row[$varname] != 0) $$varname = 0;
	}
	
	$mysqligame2 = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");	
	if($mysqligame2->real_query("UPDATE games SET statsendsid = '$ipnew', w1 = '$w1',apm1r = apm1r + '$apm1r',apm2r = apm2r + '$apm2r',apm3r = apm3r + '$apm3r',apm4r = apm4r + '$apm4r',apm5r = apm5r + '$apm5r',apm6r = apm6r + '$apm6r',apm7r = apm7r + '$apm7r',apm8r = apm8r + '$apm8r'  WHERE (p1 = '$p1' AND p2 = '$p2'  AND '$cTimeMAX' < cTime)")){

	}else{

	}
	$isFound = true;
}

if(!$isFound){

	// echo "тип - ".$type."\n";
	//----------записываем игру в базу-------------
	date_default_timezone_set( 'Europe/Moscow' );
	$date = date('Y-m-d H:i:s', time());

	$ipreal = $_SERVER['REMOTE_ADDR'];
	
	$insert_str = "type,";
	$values_str = "'$type', ";
	for($i=1; $i<($type*2+1); $i++)
	{
		$values_str .= "'" . $players[$i-1]. "', ";
		$insert_str .= "p".$i.",";
	}
	for($i=1; $i<($type+1); $i++)
	{
		$values_str .= "'" . $winners[$i-1] . "', ";
		$insert_str .= "w".$i.",";
	}
	for($i=1; $i<($type*2+1); $i++)
	{
		$values_str .= "'" . $races[$i-1] . "', ";
		$insert_str .= "r".$i.",";
	}
	for($i=1; $i<($type*2+1); $i++)
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

		if($apmrs[$i-1]!=0)
			calculate_and_change_apm($mysqligame, $players[$i-1], $apmrs[$i-1]);

		$mysqligame->real_query("UPDATE players SET ".$type."x".$type."_".$races[$i-1]." = ".$type."x".$type."_".$races[$i-1]." + 1, time = time + $gTime  WHERE (name = '".$players[$i-1]."' )");
		if(in_array($players[$i-1], $winners)){
        	$mysqligame->real_query("UPDATE players SET ".$type."x".$type."_".$races[$i-1]."w = ".$type."x".$type."_".$races[$i-1]."w + 1  WHERE (name = '".$players[$i-1]."')");
		}
	}

	//-----------------запись рейтинга---------------------------------------
	if($type == 1){
		$pp1 = $players[0];
		$pp2 = $players[1];

	    $mysqligame->real_query("SELECT * FROM players WHERE name = '$pp1'");
		$res = $mysqligame->store_result();
		$isFound1 = false;
		while ($row = $res->fetch_assoc()) {

			$isFound1 = true;
		}

		$isFound2 = false;
		$mysqligame->real_query("SELECT * FROM players WHERE name = '$pp2'");
		$res = $mysqligame->store_result();
		while ($row = $res->fetch_assoc()) {

			$isFound2 = true;
		}

		if($isFound1 and $isFound2){

			$mmr1 = 1500;
			$mmr2 = 1500;


			$mysqligame->real_query("SELECT * FROM players WHERE name = '$pp1'");
			$res = $mysqligame->store_result();
			$isFound = false;
			while ($row = $res->fetch_assoc()) {
				$mmr1 = $row['mmr'] ;
			}

			$mysqligame->real_query("SELECT * FROM players WHERE name = '$pp2'");
			$res = $mysqligame->store_result();
			$isFound = false;
			while ($row = $res->fetch_assoc()) {
				$mmr2 = $row['mmr'] ;
			}
			$apm_info .= "<br/> расчет рейтинга:<br/> рейтинг до: ".$pp1." - " . $mmr1 . " " . $pp2." - " . $mmr2;
			$amb = $mmr2 - $mmr1;
			$ea = 1/(1 + pow( 10 , $amb/400 ));
			$f1 = round(50*(1 - $ea));
			$apm_info .= "<br/> разница в рейтинге: " .$amb. "; вероятность победы игрока: " . $ea . "; итоговое изменение рейтинга: " . $f1 . "<br/>";

			if(in_array($pp1, $winners)){
				$mysqligame->real_query("UPDATE players SET mmr = '$mmr1' + '$f1'  WHERE name = '$pp1'");
				$res = $mysqligame->store_result();
				$mysqligame->real_query("UPDATE players SET mmr = '$mmr2' - '$f1'  WHERE name = '$pp2'");
			}

			$amb = $mmr1 - $mmr2;
			$eb = 1/(1 + pow( 10 , $amb/400 ));
			$f1 = round(50*(1 - $eb));

			if(in_array($pp2, $winners)){
				$mysqligame->real_query("UPDATE players SET mmr = '$mmr1' - '$f1'  WHERE name = '$pp1'");
				$res = $mysqligame->store_result();
				$mysqligame->real_query("UPDATE players SET mmr = '$mmr2' + '$f1'  WHERE name = '$pp2'");
			}
		}
	}
};

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");

$stopmt = microtime(true) - $startmt;
echo " - конец скрипта, время выполнения записи: " . $stopmt;

?>