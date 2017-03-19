<?php
header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");


$key = $_GET["key"];
if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	echo "wrong key";
	return;
}

$outlog = "";

$mysqligame = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
for($i=0;$i<sizeof($_GET)/2-1;$i++)
{
	if(isset($_GET['name'.$i]))
		$name = $_GET['name'.$i];
	else if(isset($_GET['name']))
		$name = $_GET['name'];
	else break;
	if(isset($_GET['sid'.$i]))
		$sid = $_GET['sid'.$i];
	else if(isset($_GET['sid']))
		$sid = $_GET['sid'];
	else break;
	$mysqligame->real_query("SELECT * FROM players WHERE sid = '$sid'");
	$res = $mysqligame->store_result();
	if($row = $res->fetch_assoc())
	{
		$outlog .= " the player ".NickDecode::decodeNick($name)." is already in the database<br/>";
		$nicknames = unserialize(base64_decode($row['last_nicknames']));

		if($nicknames?(!in_array($name, $nicknames)):true)
		{
			$nicknames[]=$name;
			$nicknames_str = base64_encode(serialize($nicknames));
			$mysqligame->real_query("UPDATE players SET last_nicknames = '$nicknames_str' WHERE sid = '$sid'");
		}

		if($row['name']!=$name)
		{
			// $mysqligame2 = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");

			$mysqligame->real_query("UPDATE players SET name = '$name' WHERE sid = '$sid'");
			$outlog .= "player nick changed: from ".NickDecode::decodeNick($row['name'])." to ". NickDecode::decodeNick($name) ."<br/>";
		}
		//-----------обновляем аватарку в стиме ----------------
		$avatar_url = Steam::get_avatar_url_by_id($sid);
		$mysqligame->real_query("UPDATE players SET avatar_url = '$avatar_url' WHERE sid = '$sid'");
	}
	else
	{
		$getted_avatar = Steam::get_avatar_url_by_id($sid);
		$avatar_url = ($getted_avatar != "") ? $getted_avatar : "images/inq.png";
		$query_str="";
		for($i=1;$i<=4;$i++)
			for($j=1;$j<=9;$j++)
			{
				$query_str.=$i.'x'.$i.'_'.$j.',';
				$query_str.=$i.'x'.$i.'_'.$j.'w,';
			}

		if($mysqligame->real_query("INSERT INTO players (name,avatar_url, time, sid, ".$query_str."mmr) values ('$name', '$avatar_url', 0,'$sid',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1500)"))
			$outlog .= "the player with nick: ". NickDecode::decodeNick($name) ." and steamid: " . $sid . " was written to the database";
		else
			$outlog .= "sql error";
	}
}
echo $outlog;
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','-', '$outlog') ");

?>