<?
header('Content-Type: text/html; charset=utf-8');
echo " - скрипт записи статистики начал выполнение\n";

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");

$apm_info = "";
$is_obs_or_leaver = false;

function calculate_and_change_apm($mysqligame, $sid, $apm){
	global $apm_info; 
	$mysqligame->real_query("SELECT apm, apm_game_counter FROM players WHERE sid = '$sid'");
	$res = $mysqligame->store_result();
	if($row = $res->fetch_assoc())
	{
		$apm_info.= $row['apm'] . "- был<br>";
		$apm_info.= "апм новой игры: " . $apm . " всего игр с апм: " . $row['apm_game_counter'] . "<br/>";
		$apm1new = ($row['apm'] * $row['apm_game_counter'] + $apm) / ($row['apm_game_counter'] + 1);
		$apm_info.= "апм игрока ". NickDecode::decodeNick($row['name']) . " стал: " . round($apm1new, 2);
		$apm_info.= "<br/>";
		$mysqligame->real_query("UPDATE players SET apm = '$apm1new', apm_game_counter = apm_game_counter + 1 WHERE sid = '$sid'");
	}
}

function create_replay_file($last_game_id){
	global $_FILES, $replay_info;
	$replay_info .= $_FILES['file']['name'];
	$uploaddir =  "replays/";
	if(!is_dir($uploaddir)) mkdir($uploaddir);
	$uploadfile = $uploaddir.substr($replay_info,0,-4)."#".$last_game_id.".rec";

	// это условие нужно поменять, на случай, если первые реплеи придут от ливеров или обозревателей
	if(!file_exists($uploadfile))
	{
		$replay_info .= "<br/><a href = \"".$uploadfile."\">скачать реплей</a>";

		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
		    echo " - файл реплея с id ".$last_game_id." был успешно сохранен.\n";
		else
		    echo " - не удалось загузить реплей с id ".$last_game_id."\n" ;
	}
}

$mysqligame = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$mysqligame->set_charset("utf8");
$type = $_GET["type"];

// показывает имена игроков в массиве по индексам, если игрока нет, то NULL
// var_dump($players);

$players = array();
$races = array();
// $apmrs = array();
for($i=1; $i<=8; $i++)
{
	$races[] =   isset($_GET["r".$i]) ? $_GET["r".$i] : 0;
    $players[] = isset($_GET["p".$i]) ? $_GET["p".$i] : 0;
    // $apmrs[] =   isset($_GET["apm".$i."r"]) ? $_GET["apm".$i."r"] : 0;
}
$winners = array();
for($i=1; $i<=4; $i++)
{
	$winners[] = $_GET["w".$i];
}

$apm = $_GET["apm"];
$sid = $_GET["sid"];
$map = $_GET["map"];
$winby = $_GET["winby"];
$gTime = $_GET["gtime"];
$mod = $_GET["mod"];
$key = $_GET["key"];
$cTimeMAX = date('Y-m-d H:i:s', time()-180);

//--------------

if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	return;
}

if(strtolower($winby) == strtolower("Disconnect")){
	echo " - статистика не была записана, причина: Disconnect\n";
	// return;
	$is_obs_or_leaver = true;
}


// $ipCurrent = $_SERVER['REMOTE_ADDR'];

// $mysqligame->real_query("SELECT * FROM ipBans WHERE ipBansstr = '$ipCurrent' LIMIT 1");
// $res = $mysqligame->store_result();
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

// нужно получить номер игрока, чтобы узнать кому писать apm
$mysqligame->real_query("SELECT apm, apm_game_counter FROM players WHERE sid = '$sid'");
$res = $mysqligame->store_result();
if($row = $res->fetch_assoc())
	$sender_index = array_search($row['name'], $players)+1;

//-----Записываем игру
$mysqligame->real_query("SELECT * FROM games WHERE (p1 = '".$players[0]."' AND p2 = '".$players[1]."'  AND '$cTimeMAX' < cTime)");
$res = $mysqligame->store_result();

// обновим апм у игрока приславшего статистику
calculate_and_change_apm($mysqligame, $sid, $apm);

// проверим, нет ли такой игры в базе
$isFound = false;
while ($row = $res->fetch_assoc()) {
	echo " - данная игра уже находится в базе\n";
	$sid = $row['statsendsid'] . ", " . $sid;

	// кто нибудь, расскажите мне что творится в этом участке кода, почему здесь $$?
	for($i = 1; $i < 9; $i++){
		$varname = "apm" . $i . "r";
		if ($row[$varname] != 0) $$varname = 0;
	}

	$mysqligame2 = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");

    $mysqligame2->real_query("UPDATE games SET statsendsid = '$sid', w1 = '".$winners[0]."', apm".$sender_index."r = '".$apm."' WHERE (p1 = '".$players[0]."' AND p2 = '".$players[1]."'  AND '$cTimeMAX' < cTime)");

	// запишем файл реплея, если он не пришел от первого игрока
	create_replay_file($row['id']);

	$isFound = true;
}

// если такая игра не найдена, то запишем ее в базу
if(!$isFound&&!$is_obs_or_leaver)
{
	// echo "тип - ".$type."\n";
	//----------записываем игру в базу-------------
	date_default_timezone_set( 'Europe/Moscow' );
	$date = date('Y-m-d H:i:s', time());
	$ipreal = $_SERVER['REMOTE_ADDR'];

	$insert_str = "type,";
	$values_str = "'$type',";
	for($i=1; $i<=$type*2; $i++){
		$insert_str .= "p".$i.",";
		$values_str .= "'".$players[$i-1]."',";
	}
	for($i=1; $i<=$type; $i++){
		$insert_str .= "w".$i.",";
		$values_str .= "'".$winners[$i-1]."',";
	}
	for($i=1; $i<=$type*2; $i++){
		$insert_str .= "r".$i.",";
		$values_str .= "'".$races[$i-1]."',";
	}
	for($i=1; $i<=$type*2; $i++){
		$insert_str .= "apm".$i."r,";
		$values_str .= ($sender_index==$i)?"'".$apm."',":"'0',";
	}
	$insert_str .= "map,gTime,cTime,statsendsid, game_mod, ipreal";
	$values_str .= "'$map','$gTime','$date','$sid','$mod','$ipreal'" ;
	// echo $insert_str . " - " . $values_str . "<br/>";
	$mysqligame->real_query("INSERT INTO games (".$insert_str.") VALUES (".$values_str.")");

	echo " - запись игры в базу завершена\n";
	create_replay_file($mysqligame->insert_id);
	// echo " - отработал скрипт расчёта реплея\n";

	//-------записываем победу и поражение в базу---------
	for($i=0; $i<$type*2; $i++){
		$mysqligame->real_query("UPDATE players SET ".$type."x".$type."_".$races[$i]." = ".$type."x".$type."_".$races[$i]." + 1, time = time + $gTime  WHERE (name = '".$players[$i]."' )");
		if(in_array($players[$i], $winners))
        	$mysqligame->real_query("UPDATE players SET ".$type."x".$type."_".$races[$i]."w = ".$type."x".$type."_".$races[$i]."w + 1  WHERE (name = '".$players[$i]."')");
	}

    $n = $type*2;  // количество игроков
    $K = 50 / ($n - 1);
    $apm_info .= $n." players<br/>";
    // для каждого игрока
    for($i = 0; $i < $n; $i++)
    {
		$result = in_array($players[$i], $winners);
	    $mysqligame->real_query("SELECT * FROM players WHERE name = '".$players[$i]."'");
		$res = $mysqligame->store_result();
		// если игрок есть в базе, то посчитаем для него новый ммр
		if($row = $res->fetch_assoc())
		{
			$curELO = $row['mmr'];
			// получим тут sid игрока, пригодится, емае
			$sid = $row['sid'];
			$eloChange = 0;
			for($j = 0; $j < $n; $j++)
			{
				// ищем противников данного игрока и если такие есть, то рассчитываем изменение ммр
				if(($i!=$j)&&($result!=in_array($players[$j], $winners)))
				{
				    $mysqligame->real_query("SELECT * FROM players WHERE name = '".$players[$j]."'");
					$res = $mysqligame->store_result();
					// если противник есть в базе, то посчитаем изменение ММР для него
					if($row = $res->fetch_assoc())
					{
						$apm_info .= "<br/>".NickDecode::decodeNick($players[$i])." vs ".NickDecode::decodeNick($players[$j])." рейтинг до: " . $curELO;
						$opponentELO = $row['mmr'];
					
						//work out EA
						$EA = 1 / (1 + pow(10, ($opponentELO - $curELO) / 400));
						//calculate ELO change vs this one opponent, add it to our change bucket  
						//I currently round at this point, this keeps rounding changes symetrical between EA and EB, but changes K more than it should
						$eloChange += round($K * (($result?1:0) - $EA));
						$apm_info .= "<br/> итоговое изменение рейтинга: " . $eloChange . "<br/>";
					}
				}
			}

			$curELO += $eloChange;
			// из-за этого условия ммр пишется всем, где ник равен текущему и поэтому у обоих зоргов одинаковый ммр, но о чудо, я додумался
			// сейчас я изменю эту срань господню, отлично, я поменял проверку по имени на проверку по sid
			// все равно у нас ммр считается только для тех кто в базе есть
			$mysqligame->real_query("UPDATE players SET mmr = '$curELO' WHERE sid = '$sid'");
		}
    }
}

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");

?>