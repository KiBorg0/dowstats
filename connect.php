<?
header('Content-Type: text/html; charset=utf-8');
echo " - скрипт записи статистики начал выполнение<br/>\n";

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");

$replay_info = "";
$apm_info = "";
$is_obs_or_leaver = false;
$apm = 0;
for($i=1;$i<=8;$i++)
	if(isset($_GET["apm".$i."r"]))
		if($_GET["apm".$i."r"]!=0){
			$apm = $_GET["apm".$i."r"];
			break;
		}

$apm = $apm!=0?$apm:(isset($_GET["apm"])?$_GET["apm"]:0);

$mysqligame = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
$mysqligame->set_charset("utf8");

$type = isset($_GET["type"])?$_GET["type"]:0;
$sid = isset($_GET["sid"])?$_GET["sid"]:'';
$map = isset($_GET["map"])?$_GET["map"]:'';
$winby = isset($_GET["winby"])?$_GET["winby"]:'';
$gTime = isset($_GET["gtime"])?$_GET["gtime"]:'';

$mod = isset($_GET["mod"])?$_GET["mod"]:'';
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strtolower($mod)!='dxp2'){
	$apm_info .= 'not supported game mod '.$mod;
	$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");
	return;
}

$key = isset($_GET["key"])?$_GET["key"]:'';
if($key != "80bc7622e3ae9980005f936d5f0ac6cd"){
	$apm_info .= 'bad key';
	$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");
	return;
}

$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");
$last_url_log = $mysqligame->insert_id;

$players = array();
$races = array();
$winners = array();
for($i=1; $i<=8; $i++)
{
	$races[]   = isset($_GET["r".$i]) ? $_GET["r".$i] : 0;
    $players[] = isset($_GET["p".$i]) ? $_GET["p".$i] : '';
    $winners[] = $i<=4&&isset($_GET["w".$i]) ? $_GET["w".$i] : '';
}

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
	if(!isset($_FILES['file']['name'])){
		echo "<br/> - не удалось загузить реплей с id ".$last_game_id."<br/>\n" ;
	    return '';
	}

	$filename = $_FILES['file']['name'];	
	$replay_info .= $filename;
	$uploaddir =  "replays/";
	if(!is_dir($uploaddir)) mkdir($uploaddir);
	$uploadfile = $uploaddir.substr($filename,0,-4)."#".$last_game_id.".rec";

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
	global $apm_info;
	global $players;
	global $winners;
	global $races;
	global $sid;
	global $type;
	global $gTime;
    $n = $type*2;  // количество игроков
    $K = 50 / ($n - 1);
    
    $apm_info .= "<br/>".$n." players<br/>";
    $mmr_changes = array();
    // для каждого игрока
    for($i = 0; $i < $n; $i++)
    {
		$result = (in_array($i+1, $winners)||in_array($players[$i], $winners));
	    $mysqligame->real_query("SELECT * FROM players WHERE name = '".$players[$i]."'");
		$res = $mysqligame->store_result();
		// если игрок есть в базе, то посчитаем для него новый ммр
		if($row = $res->fetch_assoc())
		{
			$overall_curELO = 0;
			$overall_eloChange = 0;
			$curELO = $type==1?$row['mmr']:$row['overall_mmr'];
			if($type==1)
				$overall_curELO = $row['overall_mmr'];

			// получим тут sid игрока, пригодится, емае
			$sid = $row['sid'];
			$eloChange = 0;
			for($j = 0; $j < $n; $j++)
			{
				// ищем противников данного игрока и если такие есть, то рассчитываем изменение ммр
				if(($i!=$j)&&($result!=(in_array($j+1, $winners)||in_array($players[$j], $winners))))
				{
				    $mysqligame->real_query("SELECT * FROM players WHERE name = '".$players[$j]."'");
					$res = $mysqligame->store_result();
					// если противник есть в базе, то посчитаем изменение ММР для него
					if($row = $res->fetch_assoc())
					{
						$apm_info .= "<br/>".NickDecode::decodeNick($players[$i])." vs ".NickDecode::decodeNick($players[$j])." рейтинг до: " . $curELO.' '.$overall_curELO;
						$opponentELO = $type==1?$row['mmr']:$row['overall_mmr'];

						if($type==1){
							$overall_opponentELO = $row['overall_mmr'];
							$EA = 1 / (1 + pow(10, ($overall_opponentELO - $overall_curELO) / 400));
							$overall_eloChange += round($K * (($result?1:0) - $EA));
						}
					
						//work out EA
						$EA = 1 / (1 + pow(10, ($opponentELO - $curELO) / 400));
						//calculate ELO change vs this one opponent, add it to our change bucket  
						//I currently round at this point, this keeps rounding changes symetrical between EA and EB, but changes K more than it should
						$eloChange += round($K * (($result?1:0) - $EA));
						$apm_info .= "<br/> итоговое изменение рейтинга: " . $eloChange .' '.$overall_eloChange. "<br/>";
					}
				}
			}
			$overall_curELO += $overall_eloChange;
			$curELO += $eloChange;
			// из-за этого условия ммр пишется всем, где ник равен текущему и поэтому у обоих зоргов одинаковый ммр, но о чудо, я додумался
			// сейчас я изменю эту срань господню, отлично, я поменял проверку по имени на проверку по sid
			// все равно у нас ммр считается только для тех кто в базе есть
			$mmr_changes[$sid] = $curELO;
			$overall_mmr_changes[$sid] = $overall_curELO;
			// если изменение ммр делать на этом этапе, то для следующих игроков будут считаться не верные изменения
			// $mysqligame->real_query("UPDATE players SET mmr = '$curELO' WHERE sid = '$sid'");
		}
    }
	if($type==1){
	    foreach ($mmr_changes as $key => $value){
	    	$mysqligame->real_query("UPDATE players SET mmr = '$value' WHERE sid = '$key'");
	    }
	    foreach ($overall_mmr_changes as $key => $value){
	    	$mysqligame->real_query("UPDATE players SET overall_mmr = '$value' WHERE sid = '$key'");
	    }
	}
	else
		foreach ($mmr_changes as $key => $value){
    		$mysqligame->real_query("UPDATE players SET overall_mmr = '$value' WHERE sid = '$key'");
    	}

	//-------записываем победу и поражение в базу---------
	for($i=0; $i<$type*2; $i++){
		$cell = $type."x".$type."_".$races[$i];
		$mysqligame->real_query("UPDATE players SET ".$cell." = ".$cell." + 1, time = time + $gTime  WHERE (name = '".$players[$i]."' )");
		if(in_array($i+1, $winners)||in_array($players[$i], $winners))
        	$mysqligame->real_query("UPDATE players SET ".$cell."w = ".$cell."w + 1  WHERE (name = '".$players[$i]."')");
	}
}


$date = date('Y-m-d H:i:s', time());
$ipreal = $_SERVER['REMOTE_ADDR'];
$cTimeMAX = date('Y-m-d H:i:s', time()-120);

if(strtolower($winby) == "disconnect")
	$is_obs_or_leaver = true;



$sender_index = 0;
// нужно получить номер игрока, чтобы узнать кому писать apm
$mysqligame->real_query("SELECT name FROM players WHERE sid = '$sid'");
$res = $mysqligame->store_result();
if($row = $res->fetch_assoc())
{
	$mysqligame->real_query("UPDATE players SET last_active = '$date' WHERE sid = '$sid'");
	$sender_index = array_search($row['name'], $players);
	// индекс 0 зарезервирован под обозревателя, поэтому индексы игроков будем брать на 1 больше
	if($sender_index===false)
	{
		$sender_index = 0;
		$is_obs_or_leaver = true;
	}
	else{
		$sender_index +=1;
		echo " - отправитель статистики: ".NickDecode::decodeNick($row['name'])."<br/>\n";
		echo " - индекс:".$sender_index."<br/>\n";
	}
}
else
	$is_obs_or_leaver = true;

if($is_obs_or_leaver){
	if($sender_index==0){
		echo " - статистику отправил обозреватель<br/>\n";
		$apm_info .= "статистику отправил обозреватель<br/>\n";
	}
	else{
		echo " - статистику отправил ливер<br/>\n";
		$apm_info .= "статистику отправил ливер<br/>\n";
	}
}
// $cTimeMAX = date('Y-m-d H:i:s', time()-120);
//-----Записываем игру
$mysqligame->real_query("SELECT * FROM games WHERE (p1 = '".$players[0]."' AND p2 = '".$players[1]."') AND ('$cTimeMAX' < cTime OR (confirmed=0 AND map='$map' AND r1='".$races[0]."'))");
$res = $mysqligame->store_result();

// обновим апм у игрока приславшего статистику
if($apm&&$sender_index!=0)
	calculate_and_change_apm($mysqligame, $sid, $apm);
	

// проверим, нет ли такой игры в базе
$isFound = false;
while ($row = $res->fetch_assoc()) {
	echo " - данная игра уже находится в базе<br/>\n";
	$statsendsid = unserialize(base64_decode($row['statsendsid']));	
	$statsendsid[$sender_index] = $sid;
	$statsendsid_str = base64_encode(serialize($statsendsid));


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
	// если индекс не обсервера, то обновим апм
	if($sender_index!=0&&$row["apm".$sender_index."r"]==0)
		$update_str .= "apm".$sender_index."r='".$apm."',";
	$update_str .= "gTime='$gTime', cTime='$date', statsendsid='$statsendsid_str', replay_link='$href', ipreal='$ipreal'";

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
 		else
 			$mysqligame->real_query("UPDATE games SET statsendsid='$statsendsid_str' WHERE (p1 = '".$players[0]."' AND p2 = '".$players[1]."'  AND '$cTimeMAX' < cTime)");

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
	$statsendsid = array();
	$statsendsid[$sender_index] = $sid;
	$statsendsid_str = base64_encode(serialize($statsendsid));
	$insert_str .= "map,gTime,cTime,statsendsid, game_mod,ipreal";
	$values_str .= "'$map','$gTime','$date','$statsendsid_str','$mod','$ipreal'";
	if($is_obs_or_leaver){
		$insert_str .= ",confirmed";
		$values_str .= ", '0'";
	}
	// echo $insert_str . " - " . $values_str . "<br/>";
	$mysqligame->real_query("INSERT INTO games (".$insert_str.") VALUES (".$values_str.")");

	echo " - запись игры в базу завершена\n";
	$last_game_id = $mysqligame->insert_id;
	$href = create_replay_file($last_game_id);
    $mysqligame->real_query("UPDATE games SET replay_link='$href' WHERE id = '$last_game_id'");

    if(!$is_obs_or_leaver)
		update_players($mysqligame);
}

$mysqligame->real_query("UPDATE url_logs SET replay_var_dump='$replay_info', apm_calc='$apm_info', cTime='$date' WHERE id = '$last_url_log'");

// $mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");

?>