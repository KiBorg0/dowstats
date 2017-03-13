<?
header('Content-Type: text/html; charset=utf-8');
echo " - скрипт записи статистики начал выполнение<br/>\n";

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");

$apm_info = "";
$is_obs_or_leaver = false;

function calculate_and_change_apm($mysqligame, $sid, $apm){
	global $apm_info; 
	$mysqligame->real_query("SELECT apm, apm_game_counter, name FROM players WHERE sid = '$sid'");
	$res = $mysqligame->store_result();
	if($row = $res->fetch_assoc())
	{
		$apm_info.= "апм игрока ".NickDecode::decodeNick($row['name'])."<br/>";
		$apm_info.= "sid: ".$sid."<br/>";
		$apm_info.= "был: ".$row['apm'] . "<br/>";
		$apm_info.= "новой игры: " . $apm . " всего игр с апм: " . $row['apm_game_counter'] . "<br/>";
		$apm1new = ($row['apm'] * $row['apm_game_counter'] + $apm) / ($row['apm_game_counter'] + 1);
		$apm_info.= "стал: " . round($apm1new, 2)."<br/>";

		$mysqligame->real_query("UPDATE players SET apm = '$apm1new', apm_game_counter = apm_game_counter + 1 WHERE sid = '$sid'");
	}
}

function create_replay_file($last_game_id){
	global $_FILES, $replay_info;
	$replay_info .= $_FILES['file']['name'];
	$uploaddir =  "replays/";
	if(!is_dir($uploaddir)) mkdir($uploaddir);
	$uploadfile = $uploaddir.substr($_FILES['file']['name'],0,-4)."#".$last_game_id.".rec";

	// это условие нужно поменять, на случай, если первые реплеи придут от ливеров или обозревателей
	if(file_exists($uploadfile))
		unlink($uploadfile);
	$href = str_replace("#", "%23", $uploadfile);
	
	
	if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
	    echo " - файл реплея с id ".$last_game_id." был успешно сохранен.\n";
	else{
	    echo "<br/> - не удалось загузить реплей с id ".$last_game_id."<br/>\n" ;
	    return '';
	}
	$replay_info .= '<br/><a href = "'.$href.'">скачать реплей</a>';
	return $href;
}

function update_players($mysqligame)
{
    $n = $type*2;  // количество игроков
    $K = 50 / ($n - 1);
    $apm_info .= "<br/>".$n." players<br/>";
    $mmr_changes = array();
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
			$mmr_changes[$sid] = $curELO;
			// если изменение ммр делать на этом этапе, то для следующих игроков будут считаться не верные изменения
			// $mysqligame->real_query("UPDATE players SET mmr = '$curELO' WHERE sid = '$sid'");
		}
    }
    	//-------записываем победу и поражение в базу---------
	for($i=0; $i<$type*2; $i++){
		$mysqligame->real_query("UPDATE players SET ".$type."x".$type."_".$races[$i]." = ".$type."x".$type."_".$races[$i]." + 1, time = time + $gTime  WHERE (name = '".$players[$i]."' )");
		if(in_array($players[$i], $winners))
        	$mysqligame->real_query("UPDATE players SET ".$type."x".$type."_".$races[$i]."w = ".$type."x".$type."_".$races[$i]."w + 1  WHERE (name = '".$players[$i]."')");
	}

    foreach ($mmr_changes as $key => $value){
    	$mysqligame->real_query("UPDATE players SET mmr = '$value' WHERE sid = '$key'");
    }
}

$mysqligame = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$mysqligame->set_charset("utf8");
$type = $_GET["type"];

// показывает имена игроков в массиве по индексам, если игрока нет, то NULL
// var_dump($players);


$apm = $_GET["apm"];
$sid = $_GET["sid"];
$map = $_GET["map"];
$winby = $_GET["winby"];
$gTime = $_GET["gtime"];
$mod = $_GET["mod"];
$key = $_GET["key"];
$date = date('Y-m-d H:i:s', time());
$ipreal = $_SERVER['REMOTE_ADDR'];
$cTimeMAX = date('Y-m-d H:i:s', time()-180);

if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	return;
}

$players = array();
$races = array();
$winners = array();
for($i=1; $i<=8; $i++)
{
	$races[]   = isset($_GET["r".$i]) ? $_GET["r".$i] : 0;
    $players[] = isset($_GET["p".$i]) ? $_GET["p".$i] : '';
    $winners[] = $i<=4&&isset($_GET["w".$i]) ? $_GET["w".$i] : '';
}

if(strtolower($winby) == strtolower("Disconnect")){
	$apm_info .= "сендер обозреватель или ливер<br/>";
	echo " - статистику обозреватель или ливер<br/>\n";
	$is_obs_or_leaver = true;
}


$sender_index = 0;
// нужно получить номер игрока, чтобы узнать кому писать apm
$mysqligame->real_query("SELECT name FROM players WHERE sid = '$sid'");
$res = $mysqligame->store_result();
if($row = $res->fetch_assoc())
{
	$mysqligame->real_query("UPDATE players SET last_active = '$date' WHERE sid = '$sid'");
	$sender_index = array_search($row['name'], $players);
	if($sender_index===false)
		$sender_index = 0;
	else{
		$sender_index +=1;
		echo " - отправитель статистики: ".NickDecode::decodeNick($row['name'])."<br/>\n";
		echo " - индекс:".$sender_index."<br/>\n";
	}
}

//-----Записываем игру
$mysqligame->real_query("SELECT * FROM games WHERE (p1 = '".$players[0]."' AND p2 = '".$players[1]."') AND ('$cTimeMAX' < cTime OR confirmed = 0)");
$res = $mysqligame->store_result();

// обновим апм у игрока приславшего статистику
calculate_and_change_apm($mysqligame, $sid, $apm);

// проверим, нет ли такой игры в базе
$isFound = false;
while ($row = $res->fetch_assoc()) {
	echo " - данная игра уже находится в базе<br/>\n";
	$sid = $row['statsendsid'] . ", " . $sid;	

	// кто нибудь, расскажите мне что творится в этом участке кода, почему здесь $$?
	for($i = 1; $i < 9; $i++){
		$varname = "apm" . $i . "r";
		if ($row[$varname] != 0) $$varname = 0;
	}
	// запишем файл реплея, если он не пришел от первого игрока
	$href = create_replay_file($row['id']);
	$update_str = "";
	for($i=1; $i<=$type; $i++)
		$update_str .= "w".$i."='".$winners[$i-1]."',";
	if($sender_index!=0)
		$update_str .= "apm".$sender_index."r='".$apm."',";
	$update_str .= "cTime='$date', statsendsid='$sid', replay_link = '$href', ipreal='$ipreal'";

	// если  игра записанная в базе не подтвержденная (от ливера или обсервера)
	if(!$row['confirmed']){
		// подтвердим игру, если мы не обс или ливер, обновим и запишем статистику игрокам
		if(!$is_obs_or_leaver){
			echo "подтверждение статистики <br/>";
			$update_str .= ",confirmed = 1";
			$mysqligame->real_query("UPDATE games SET ".$update_str." WHERE (p1 = '".$players[0]."' AND p2 = '".$players[1]."'  AND confirmed = 0)");
			update_players($mysqligame);
		}
		else
			$mysqligame->real_query("UPDATE games SET ".$update_str." WHERE (p1 = '".$players[0]."' AND p2 = '".$players[1]."'  AND confirmed = 0)");
	}
	else
		// если найденная игра уже потверждена, то если игрок не обс (ливер к этому моменту уже не присылает)
		// обновляем игру (обновим виннеров на всякий случай, апм, дату, сид, ссылку на реплей и ip)
		if(!$is_obs_or_leaver)
 			$mysqligame->real_query("UPDATE games SET ".$update_str." WHERE (p1 = '".$players[0]."' AND p2 = '".$players[1]."'  AND '$cTimeMAX' < cTime)");

	$isFound = true;
}

if(!$isFound)
{
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
	if($sender_index!=0){
		$insert_str .= "apm".$sender_index."r,";
		$values_str .= "'".$apm."',";
	}
	$insert_str .= "map,gTime,cTime,statsendsid, game_mod,ipreal";
	$values_str .= "'$map','$gTime','$date','$sid','$mod','$ipreal'";
	if($is_obs_or_leaver){
		$insert_str .= ",confirmed";
		$values_str .= ", '0'";
	}
	// echo $insert_str . " - " . $values_str . "<br/>";
	$mysqligame->real_query("INSERT INTO games (".$insert_str.") VALUES (".$values_str.")");

	echo " - запись игры в базу завершена\n";
	$href = create_replay_file($mysqligame->insert_id);
    $mysqligame->real_query("UPDATE games SET replay_link = '$href' WHERE id = '$mysqligame->insert_id'");

    if(!$is_obs_or_leaver)
		update_players($mysqligame);
}

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");

?>