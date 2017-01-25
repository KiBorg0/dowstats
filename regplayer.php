<?

header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");


$key = $_GET["key"];
$name = $_GET["name"];
$sid = $_GET["sid"];
if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	echo "неверный ключ";
	return;
}

$mysqligame = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");

$mysqligame->real_query("SELECT * FROM players WHERE name = '$name'");
$outlog = "";

$res = $mysqligame->use_result();
$isFound = false;
while ($row = $res->fetch_assoc()) {

	$isFound = true;
}
$mysqligame->real_query("SELECT * FROM players WHERE sid = '$sid'");
$res = $mysqligame->use_result();
$isFoundSid = false;
while ($row = $res->fetch_assoc()) {
	$isFoundSid = true;
}
if(!($isFound || $isFoundSid)){
	$getted_avatar = Steam::get_avatar_url_by_id($sid);
	($getted_avatar == "") ? $avatar_url = "http://dowstats.h1n.ru/images/inq.png" : $avatar_url = $getted_avatar;
	if($mysqligame->real_query("INSERT INTO players (name,avatar_url, time, sid, 1x1_1,1x1_1w,1x1_2,1x1_2w,1x1_3,1x1_3w,1x1_4,1x1_4w,1x1_5,1x1_5w,1x1_6,1x1_6w,1x1_7,1x1_7w,1x1_8,1x1_8w,1x1_9,1x1_9w,2x2_1,2x2_1w,2x2_2,2x2_2w,2x2_3,2x2_3w,2x2_4,2x2_4w,2x2_5,2x2_5w,2x2_6,2x2_6w,2x2_7,2x2_7w,2x2_8,2x2_8w,2x2_9,2x2_9w,3x3_1,3x3_1w,3x3_2,3x3_2w,3x3_3,3x3_3w,3x3_4,3x3_4w,3x3_5,3x3_5w,3x3_6,3x3_6w,3x3_7,3x3_7w,3x3_8,3x3_8w,3x3_9,3x3_9w,4x4_1,4x4_1w,4x4_2,4x4_2w,4x4_3,4x4_3w,4x4_4,4x4_4w,4x4_5,4x4_5w,4x4_6,4x4_6w,4x4_7,4x4_7w,4x4_8,4x4_8w,4x4_9,4x4_9w,mmr) values ('$name', '$avatar_url', 0,'$sid',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1500)")){
		$outlog .= "игрок с раскодированным ником: ". NickDecode::decodeNick($name) ." со steamid: " . $sid . " записан в базу";

	}else{
		$outlog .= "ошибка sql запроса";
	}
}else{
	$outlog .= "Данный игрок уже есть в базе<br/>";
}

if($isFoundSid && !$isFound){
	$mysqligame->real_query("UPDATE players SET name = '$name' WHERE sid = '$sid'");
	$outlog .= "игрок " . $name . " поменял свой ник";
}

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','-', '$outlog') ");

?>