<?

header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');



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
$version = $_GET["v"];
$name = $_GET["name"];
$ip = $_GET["ip"];
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
$sid = $_GET["sid"];
$map = $_GET["map"];
$gTime = $_GET["gTime"];
$tungle = $_GET["tungle"];
$key = $_GET["key"];
$cTimeMAX = date('Y-m-d H:i:s', time()-120);

if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	return;
}

$all = $p1 . " " . $p2 . " " .  $ip . " " . $name . " " . $w1 . " " . $r1 . " " . $r2 . " " . $map . " " . $gTime . " " . $cTimeMAX . " " . $_SERVER['REMOTE_ADDR'];
$mysqligame->real_query("INSERT INTO connectors (connectorsT) values ('$all')  ");

if(stripos($p1, "\"") !== false ){
	return;
}
if(stripos($p1, "<") !== false ){
	return;
}
if(stripos($p1, ">") !== false ){
	return;
}
if(stripos($p2, "\"") !== false ){
	return;
}
if(stripos($p2, ">") !== false ){
	return;
}
if(stripos($p2, "<") !== false ){
	return;
}
if(stripos($p3, "\"") !== false ){
	return;
}
if(stripos($p3, "<") !== false ){
	return;
}
if(stripos($p3, ">") !== false ){
	return;
}
if(stripos($p4, "\"") !== false ){
	return;
}
if(stripos($p4, ">") !== false ){
	return;
}
if(stripos($p4, "<") !== false ){
	return;
}
if(stripos($p5, "\"") !== false ){
	return;
}
if(stripos($p5, "<") !== false ){
	return;
}
if(stripos($p5, ">") !== false ){
	return;
}
if(stripos($p6, "\"") !== false ){
	return;
}
if(stripos($p6, ">") !== false ){
	return;
}
if(stripos($p6, "<") !== false ){
	return;
}
if(stripos($p7, "\"") !== false ){
	return;
}
if(stripos($p7, "<") !== false ){
	return;
}
if(stripos($p7, ">") !== false ){
	return;
}
if(stripos($p8, "\"") !== false ){
	return;
}
if(stripos($p8, ">") !== false ){
	return;
}
if(stripos($p8, "<") !== false ){
	return;
}


if(stripos($map, "\"") !== false ){
	return;
}
if(stripos($map, ">") !== false ){
	return;
}
if(stripos($map, "<") !== false ){
	return;
}




if($p1 == "Компьютер 1" or  $p2 == "Компьютер 1" or $p3 == "Компьютер 1" or $p4 == "Компьютер 1" or $p5 == "Компьютер 1" or $p6 == "Компьютер 1" or $p7 == "Компьютер 1" or $p8 == "Компьютер 1"){
	exit();
}



$ipCurrent = $_SERVER['REMOTE_ADDR'];

$mysqligame->real_query("SELECT * FROM ipBans WHERE ipBansstr = '$ipCurrent' LIMIT 1");
$res = $mysqligame->use_result();
$isFound = false;
while ($row = $res->fetch_assoc()) {
	exit();
	return;
}




//-----------проверяем на наличие такой же игры с этого IP минуту назад, если есть то баним
$ipreal = $_SERVER['REMOTE_ADDR'];
$mysqligame->real_query("SELECT * FROM games WHERE ( '$ipreal' = ipreal  AND '$cTimeMAX' < cTime) LIMIT 1");
$res = $mysqligame->use_result();
$isFound = false;
while ($row = $res->fetch_assoc()) {
	$isFound = true;
}

if($isFound == true){
	//$mysqligame->real_query("INSERT INTO ipBans (ipBansstr) values ('$ipreal')  ");
}







//-----Записываем игру
$mysqligame->real_query("SELECT * FROM games WHERE (p1 = '$p1' AND p2 = '$p2'  AND '$cTimeMAX' < cTime)");
$res = $mysqligame->use_result();

$isFound = false;
while ($row = $res->fetch_assoc()) {

	$ipsender = "(".$sid." - ". $name . ") ";
	$ipnew = $row['statsendsid'] . ", " . $ipsender;

	$mysqligame2 = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
	if($mysqligame2->real_query("UPDATE games SET statsendsid = '$ipnew', w1 = '$w1'  WHERE (p1 = '$p1' AND p2 = '$p2'  AND '$cTimeMAX' < cTime)")){

	}else{

	}
	$isFound = true;
}
if(!$isFound){

	if($type == 1 && $w1 != "NULL" ){


		//----------записываем игру в базу-------------
		date_default_timezone_set( 'Europe/Moscow' );
		$date = date('Y-m-d H:i:s', time());

		$ipsender = "(".$sid." - ". $name . ") ";
		$ipreal = $_SERVER['REMOTE_ADDR'];
		if($mysqligame->real_query("INSERT INTO games (type,p1, p2,w1,r1,r2,map,gTime,cTime,statsendsid, tungle,ipreal) values (1, '$p1','$p2','$w1','$r1','$r2','$map','$gTime','$date','$ipsender','$tungle','$ipreal')")){


		}else{

		}
		//-------записываем победу и поражение в базу---------

		//------для игрока 1
		switch ($r1) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 1x1_1 = 1x1_1 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_1w = 1x1_1w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 1x1_2 = 1x1_2 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_2w = 1x1_2w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 1x1_3 = 1x1_3 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_3w = 1x1_3w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 1x1_4 = 1x1_4 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_4w = 1x1_4w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 1x1_5 = 1x1_5 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_5w = 1x1_5w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 1x1_6 = 1x1_6 + 1, time = time + $gTime WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_6w = 1x1_6w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 1x1_7 = 1x1_7 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_7w = 1x1_7w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 1x1_8 = 1x1_8 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_8w = 1x1_8w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 1x1_9 = 1x1_9 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_9w = 1x1_9w + 1  WHERE (name = '$w1' AND name = '$p1')");
				}
		        break;
		}

		//------для игрока 2
		switch ($r2) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 1x1_1 = 1x1_1 + 1, time = time + $gTime   WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_1w = 1x1_1w + 1 WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 1x1_2 = 1x1_2 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_2w = 1x1_2w + 1  WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 1x1_3 = 1x1_3 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_3w = 1x1_3w + 1  WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 1x1_4 = 1x1_4 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_4w = 1x1_4w + 1  WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 1x1_5 = 1x1_5 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_5w = 1x1_5w + 1  WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 1x1_6 = 1x1_6 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_6w = 1x1_6w + 1  WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 1x1_7 = 1x1_7 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_7w = 1x1_7w + 1  WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 1x1_8 = 1x1_8 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_8w = 1x1_8w + 1  WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 1x1_9 = 1x1_9 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1){
		        	$mysqligame->real_query("UPDATE players SET 1x1_9w = 1x1_9w + 1  WHERE (name = '$w1' AND name = '$p2')");
				}
		        break;
	    }

	    //-----------------запись рейтинга---------------------------------------
	    $mysqligame->real_query("SELECT * FROM players WHERE name = '$p1'");
		$res = $mysqligame->use_result();
		$isFound1 = false;
		while ($row = $res->fetch_assoc()) {

			$isFound1 = true;
		}

		$isFound2 = false;
		$mysqligame->real_query("SELECT * FROM players WHERE name = '$p2'");
		$res = $mysqligame->use_result();
		while ($row = $res->fetch_assoc()) {

			$isFound2 = true;
		}

		if($isFound1 and $isFound2){

			$mmr1 = 1500;
			$mmr2 = 1500;

			$mysqligame->real_query("SELECT * FROM players WHERE name = '$p1'");
			$res = $mysqligame->use_result();
			$isFound = false;
			while ($row = $res->fetch_assoc()) {
				$mmr1 = $row['mmr'] ;
			}

			$mysqligame->real_query("SELECT * FROM players WHERE name = '$p2'");
			$res = $mysqligame->use_result();
			$isFound = false;
			while ($row = $res->fetch_assoc()) {
				$mmr2 = $row['mmr'] ;
			}

			$amb = $mmr2 - $mmr1;
			$ea = 1/(1 + pow( 10 , $amb/400 ));
			$f1 = round(50*(1 - $ea));

			if($p1 == $w1){
				$mysqligame->real_query("UPDATE players SET mmr = '$mmr1' + '$f1'  WHERE name = '$p1'");
				$res = $mysqligame->use_result();
				$mysqligame->real_query("UPDATE players SET mmr = '$mmr2' - '$f1'  WHERE name = '$p2'");
			}

			$amb = $mmr1 - $mmr2;
			$eb = 1/(1 + pow( 10 , $amb/400 ));
			$f1 = round(50*(1 - $eb));

			if($p2 == $w1){
				$mysqligame->real_query("UPDATE players SET mmr = '$mmr1' - '$f1'  WHERE name = '$p1'");
				$res = $mysqligame->use_result();
				$mysqligame->real_query("UPDATE players SET mmr = '$mmr2' + '$f1'  WHERE name = '$p2'");
			}
		}


		
	}
	if($type == 2 &&( $w1 != "NULL" and  $w2 != "NULL" )){

		//----------записываем игру в базу-------------
		date_default_timezone_set( 'Europe/Moscow' );
		$date = date('Y-m-d H:i:s', time());

		$ipsender = "(".$sid." - ". $name . ") ";
		$ipreal = $_SERVER['REMOTE_ADDR'];
		if($mysqligame->real_query("INSERT INTO games (type, p1, p2, p3, p4, w1, w2, r1, r2, r3, r4, map,gTime,cTime,statsendsid, tungle,ipreal) values (2, '$p1','$p2','$p3','$p4','$w1', '$w2','$r1','$r2','$r3','$r4', '$map','$gTime','$date','$ipsender','$tungle','$ipreal')")){


		}else{


		}
		if($tungle == 1){
			exit();
		}
		//-------записываем победу и поражение в базу---------

		//------для игрока 1
		switch ($r1) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 2x2_1 = 2x2_1 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_1w = 2x2_1w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 2x2_2 = 2x2_2 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_2w = 2x2_2w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 2x2_3 = 2x2_3 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_3w = 2x2_3w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 2x2_4 = 2x2_4 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_4w = 2x2_4w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 2x2_5 = 2x2_5 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_5w = 2x2_5w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 2x2_6 = 2x2_6 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_6w = 2x2_6w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 2x2_7 = 2x2_7 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_7w = 2x2_7w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 2x2_8 = 2x2_8 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_8w = 2x2_8w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 2x2_9 = 2x2_9 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_9w = 2x2_9w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p1')");
				}
		        break;
	    }

		//------для игрока 2
		switch ($r2) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 2x2_1 = 2x2_1 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_1w = 2x2_1w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 2x2_2 = 2x2_2 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_2w = 2x2_2w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 2x2_3 = 2x2_3 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_3w = 2x2_3w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 2x2_4 = 2x2_4 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_4w = 2x2_4w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 2x2_5 = 2x2_5 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_5w = 2x2_5w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 2x2_6 = 2x2_6 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_6w = 2x2_6w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 2x2_7 = 2x2_7 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_7w = 2x2_7w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 2x2_8 = 2x2_8 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_8w = 2x2_8w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 2x2_9 = 2x2_9 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_9w = 2x2_9w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p2')");
				}
		        break;
	    }

	    //------для игрока 3

		switch ($r3) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 2x2_1 = 2x2_1 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_1w = 2x2_1w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 2x2_2 = 2x2_2 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_2w = 2x2_2w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 2x2_3 = 2x2_3 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_3w = 2x2_3w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 2x2_4 = 2x2_4 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_4w = 2x2_4w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 2x2_5 = 2x2_5 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_5w = 2x2_5w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 2x2_6 = 2x2_6 + 1, time = time + $gTime WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_6w = 2x2_6w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 2x2_7 = 2x2_7 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_7w = 2x2_7w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 2x2_8 = 2x2_8 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_8w = 2x2_8w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 2x2_9 = 2x2_9 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_9w = 2x2_9w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p3')");
				}
		        break;
	    }


		//------для игрока 4

		switch ($r4) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 2x2_1 = 2x2_1 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_1w = 2x2_1w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 2x2_2 = 2x2_2 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_2w = 2x2_2w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 2x2_3 = 2x2_3 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_3w = 2x2_3w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 2x2_4 = 2x2_4 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_4w = 2x2_4w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 2x2_5 = 2x2_5 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_5w = 2x2_5w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 2x2_6 = 2x2_6 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_6w = 2x2_6w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 2x2_7 = 2x2_7 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_7w = 2x2_7w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 2x2_8 = 2x2_8 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_8w = 2x2_8w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 2x2_9 = 2x2_9 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2){
		        	$mysqligame->real_query("UPDATE players SET 2x2_9w = 2x2_9w + 1  WHERE ((name = '$w1' OR name = '$w2') AND name = '$p4')");
				}
		        break;
	    }



	};

	if($type == 3 &&( $w1 != "NULL" and  $w2 != "NULL" and  $w3 != "NULL" )){

		//----------записываем игру в базу-------------
		date_default_timezone_set( 'Europe/Moscow' );
		$date = date('Y-m-d H:i:s', time());

		$ipsender = "(".$sid." - ". $name . ") ";
		$ipreal = $_SERVER['REMOTE_ADDR'];
		if($mysqligame->real_query("INSERT INTO games (type,p1, p2, p3, p4, p5, p6, w1, w2, w3, r1, r2, r3, r4, r5, r6, map,gTime,cTime,statsendsid, tungle, ipreal) values (3, '$p1','$p2', '$p3','$p4', '$p5','$p6','$w1', '$w2', '$w3', '$r1','$r2','$r3','$r4', '$r5','$r6', '$map','$gTime','$date','$ipsender','$tungle','$ipreal')")){


		}else{

		}
		if($tungle == 1){
			exit();
		}
		//-------записываем победу и поражение в базу---------

		//------для игрока 1
		switch ($r1) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 3x3_1 = 3x3_1 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_1w = 3x3_1w + 1, time = time + $gTime  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 3x3_2 = 3x3_2 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_2w = 3x3_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 3x3_3 = 3x3_3 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_3w = 3x3_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 3x3_4 = 3x3_4 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_4w = 3x3_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 3x3_5 = 3x3_5 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_5w = 3x3_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 3x3_6 = 3x3_6 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_6w = 3x3_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 3x3_7 = 3x3_7 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_7w = 3x3_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 3x3_8 = 3x3_8 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_8w = 3x3_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 3x3_9 = 3x3_9 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_9w = 3x3_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p1')");
				}
		        break;
	    }

		//------для игрока 2
		switch ($r2) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 3x3_1 = 3x3_1 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_1w = 3x3_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 3x3_2 = 3x3_2 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_2w = 3x3_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 3x3_3 = 3x3_3 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_3w = 3x3_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 3x3_4 = 3x3_4 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_4w = 3x3_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 3x3_5 = 3x3_5 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_5w = 3x3_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 3x3_6 = 3x3_6 + 1, time = time + $gTime   WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_6w = 3x3_6w + 1 WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 3x3_7 = 3x3_7 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_7w = 3x3_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 3x3_8 = 3x3_8 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_8w = 3x3_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 3x3_9 = 3x3_9 + 1, time = time + $gTime WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_9w = 3x3_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p2')");
				}
		        break;
	    }

	    //------для игрока 3

		switch ($r3) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 3x3_1 = 3x3_1 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_1w = 3x3_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 3x3_2 = 3x3_2 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_2w = 3x3_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 3x3_3 = 3x3_3 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_3w = 3x3_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 3x3_4 = 3x3_4 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_4w = 3x3_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 3x3_5 = 3x3_5 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_5w = 3x3_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 3x3_6 = 3x3_6 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_6w = 3x3_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 3x3_7 = 3x3_7 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_7w = 3x3_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 3x3_8 = 3x3_8 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_8w = 3x3_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 3x3_9 = 3x3_9 + 1, time = time + $gTime WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_9w = 3x3_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p3')");
				}
		        break;
	    }


		//------для игрока 4

		switch ($r4) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 3x3_1 = 3x3_1 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_1w = 3x3_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 3x3_2 = 3x3_2 + 1, time = time + $gTime   WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_2w = 3x3_2w + 1 WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 3x3_3 = 3x3_3 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_3w = 3x3_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 3x3_4 = 3x3_4 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_4w = 3x3_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 3x3_5 = 3x3_5 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_5w = 3x3_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 3x3_6 = 3x3_6 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_6w = 3x3_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 3x3_7 = 3x3_7 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_7w = 3x3_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 3x3_8 = 3x3_8 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_8w = 3x3_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 3x3_9 = 3x3_9 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_9w = 3x3_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p4')");
				}
		        break;
	    }

	    //------для игрока 5

	    switch ($r5) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 3x3_1 = 3x3_1 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_1w = 3x3_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 3x3_2 = 3x3_2 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_2w = 3x3_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 3x3_3 = 3x3_3 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_3w = 3x3_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 3x3_4 = 3x3_4 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_4w = 3x3_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 3x3_5 = 3x3_5 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_5w = 3x3_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 3x3_6 = 3x3_6 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_6w = 3x3_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 3x3_7 = 3x3_7 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_7w = 3x3_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 3x3_8 = 3x3_8 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_8w = 3x3_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 3x3_9 = 3x3_9 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_9w = 3x3_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p5')");
				}
		        break;
	    }

	    //------для игрока 6

	    switch ($r6) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 3x3_1 = 3x3_1 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_1w = 3x3_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 3x3_2 = 3x3_2 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_2w = 3x3_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 3x3_3 = 3x3_3 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_3w = 3x3_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 3x3_4 = 3x3_4 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_4w = 3x3_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 3x3_5 = 3x3_5 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_5w = 3x3_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 3x3_6 = 3x3_6 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_6w = 3x3_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 3x3_7 = 3x3_7 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_7w = 3x3_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 3x3_8 = 3x3_8 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_8w = 3x3_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 3x3_9 = 3x3_9 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3){
		        	$mysqligame->real_query("UPDATE players SET 3x3_9w = 3x3_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3') AND name = '$p6')");
				}
		        break;
	    }


	};
	if($type == 4 &&( $w1 != "NULL" and  $w2 != "NULL" and  $w3 != "NULL" and  $w4 != "NULL" )){

		//----------записываем игру в базу-------------
		date_default_timezone_set( 'Europe/Moscow' );
		$date = date('Y-m-d H:i:s', time());

		$ipsender = "(".$sid." - ". $name . ") ";
		$ipreal = $_SERVER['REMOTE_ADDR'];
		if($mysqligame->real_query("INSERT INTO games (type,p1, p2, p3, p4, p5, p6, p7, p8, w1, w2, w3, w4, r1, r2, r3, r4, r5, r6, r7, r8, map,gTime,cTime,statsendsid, tungle, ipreal) values (4, '$p1','$p2', '$p3','$p4', '$p5','$p6', '$p7', '$p8','$w1', '$w2', '$w3', '$w4', '$r1','$r2','$r3','$r4', '$r5','$r6', '$r7', '$r8', '$map','$gTime','$date','$ipsender','$tungle','$ipreal')")){


		}else{

		}
		if($tungle == 1){
			exit();
		}
		//-------записываем победу и поражение в базу---------
		//------для игрока 1
		switch ($r1) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 4x4_1 = 4x4_1 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_1w = 4x4_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 4x4_2 = 4x4_2 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_2w = 4x4_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 4x4_3 = 4x4_3 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_3w = 4x4_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 4x4_4 = 4x4_4 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_4w = 4x4_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 4x4_5 = 4x4_5 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_5w = 4x4_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 4x4_6 = 4x4_6 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_6w = 4x4_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 4x4_7 = 4x4_7 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_7w = 4x4_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 4x4_8 = 4x4_8 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_8w = 4x4_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 4x4_9 = 4x4_9 + 1, time = time + $gTime  WHERE (name = '$p1' )");
				if($p1 == $w1 or $p1 == $w2 or $p1 == $w3 or $p1 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_9w = 4x4_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p1')");
				}
		        break;
	    }

		//------для игрока 2
		switch ($r2) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 4x4_1 = 4x4_1 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_1w = 4x4_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 4x4_2 = 4x4_2 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_2w = 4x4_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 4x4_3 = 4x4_3 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_3w = 4x4_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 4x4_4 = 4x4_4 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_4w = 4x4_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 4x4_5 = 4x4_5 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_5w = 4x4_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 4x4_6 = 4x4_6 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_6w = 4x4_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 4x4_7 = 4x4_7 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_7w = 4x4_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 4x4_8 = 4x4_8 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_8w = 4x4_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 4x4_9 = 4x4_9 + 1, time = time + $gTime  WHERE (name = '$p2' )");
				if($p2 == $w1 or $p2 == $w2 or $p2 == $w3 or $p2 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_9w = 4x4_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p2')");
				}
		        break;
	    }

	    //------для игрока 3

		switch ($r3) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 4x4_1 = 4x4_1 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_1w = 4x4_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 4x4_2 = 4x4_2 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_2w = 4x4_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 4x4_3 = 4x4_3 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_3w = 4x4_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 4x4_4 = 4x4_4 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_4w = 4x4_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 4x4_5 = 4x4_5 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_5w = 4x4_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 4x4_6 = 4x4_6 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_6w = 4x4_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 4x4_7 = 4x4_7 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_7w = 4x4_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 4x4_8 = 4x4_8 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_8w = 4x4_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 4x4_9 = 4x4_9 + 1, time = time + $gTime  WHERE (name = '$p3' )");
				if($p3 == $w1 or $p3 == $w2 or $p3 == $w3 or $p3 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_9w = 4x4_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p3')");
				}
		        break;
	    }


		//------для игрока 4

		switch ($r4) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 4x4_1 = 4x4_1 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_1w = 4x4_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 4x4_2 = 4x4_2 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_2w = 4x4_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 4x4_3 = 4x4_3 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_3w = 4x4_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 4x4_4 = 4x4_4 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_4w = 4x4_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 4x4_5 = 4x4_5 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_5w = 4x4_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 4x4_6 = 4x4_6 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_6w = 4x4_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 4x4_7 = 4x4_7 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_7w = 4x4_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 4x4_8 = 4x4_8 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_8w = 4x4_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 4x4_9 = 4x4_9 + 1, time = time + $gTime  WHERE (name = '$p4' )");
				if($p4 == $w1 or $p4 == $w2 or $p4 == $w3 or $p4 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_9w = 4x4_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p4')");
				}
		        break;
	    }

	    //------для игрока 5

	    switch ($r5) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 4x4_1 = 4x4_1 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_1w = 4x4_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 4x4_2 = 4x4_2 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_2w = 4x4_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 4x4_3 = 4x4_3 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_3w = 4x4_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 4x4_4 = 4x4_4 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_4w = 4x4_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 4x4_5 = 4x4_5 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_5w = 4x4_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 4x4_6 = 4x4_6 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_6w = 4x4_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 4x4_7 = 4x4_7 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_7w = 4x4_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 4x4_8 = 4x4_8 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_8w = 4x4_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 4x4_9 = 4x4_9 + 1, time = time + $gTime  WHERE (name = '$p5' )");
				if($p5 == $w1 or $p5 == $w2 or $p5 == $w3 or $p5 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_9w = 4x4_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p5')");
				}
		        break;
	    }

	    //------для игрока 6

	    switch ($r6) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 4x4_1 = 4x4_1 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_1w = 4x4_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 4x4_2 = 4x4_2 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_2w = 4x4_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 4x4_3 = 4x4_3 + 1, time = time + $gTime WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_3w = 4x4_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 4x4_4 = 4x4_4 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_4w = 4x4_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 4x4_5 = 4x4_5 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_5w = 4x4_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 4x4_6 = 4x4_6 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_6w = 4x4_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 4x4_7 = 4x4_7 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_7w = 4x4_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 4x4_8 = 4x4_8 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_8w = 4x4_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 4x4_9 = 4x4_9 + 1, time = time + $gTime  WHERE (name = '$p6' )");
				if($p6 == $w1 or $p6 == $w2 or $p6 == $w3 or $p6 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_9w = 4x4_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p6')");
				}
		        break;
	    }

	    //------для игрока 7

	    switch ($r7) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 4x4_1 = 4x4_1 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_1w = 4x4_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 4x4_2 = 4x4_2 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_2w = 4x4_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 4x4_3 = 4x4_3 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_3w = 4x4_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 4x4_4 = 4x4_4 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_4w = 4x4_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 4x4_5 = 4x4_5 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_5w = 4x4_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 4x4_6 = 4x4_6 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_6w = 4x4_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 4x4_7 = 4x4_7 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_7w = 4x4_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 4x4_8 = 4x4_8 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_8w = 4x4_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 4x4_9 = 4x4_9 + 1, time = time + $gTime  WHERE (name = '$p7' )");
				if($p7 == $w1 or $p7 == $w2 or $p7 == $w3 or $p7 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_9w = 4x4_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p7')");
				}
		        break;
	    }

	    //------для игрока 8

	    switch ($r8) {
		    case 1:
		        $mysqligame->real_query("UPDATE players SET 4x4_1 = 4x4_1 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_1w = 4x4_1w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
		    case 2:
		        $mysqligame->real_query("UPDATE players SET 4x4_2 = 4x4_2 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_2w = 4x4_2w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
		    case 3:
		        $mysqligame->real_query("UPDATE players SET 4x4_3 = 4x4_3 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_3w = 4x4_3w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
		    case 4:
		        $mysqligame->real_query("UPDATE players SET 4x4_4 = 4x4_4 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_4w = 4x4_4w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
		    case 5:
		        $mysqligame->real_query("UPDATE players SET 4x4_5 = 4x4_5 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_5w = 4x4_5w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
		    case 6:
		        $mysqligame->real_query("UPDATE players SET 4x4_6 = 4x4_6 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_6w = 4x4_6w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
		    case 7:
		        $mysqligame->real_query("UPDATE players SET 4x4_7 = 4x4_7 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_7w = 4x4_7w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
		    case 8:
		        $mysqligame->real_query("UPDATE players SET 4x4_8 = 4x4_8 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_8w = 4x4_8w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
		    case 9:
		        $mysqligame->real_query("UPDATE players SET 4x4_9 = 4x4_9 + 1, time = time + $gTime  WHERE (name = '$p8' )");
				if($p8 == $w1 or $p8 == $w2 or $p8 == $w3 or $p8 == $w4){
		        	$mysqligame->real_query("UPDATE players SET 4x4_9w = 4x4_9w + 1  WHERE ((name = '$w1' OR name = '$w2' OR name = '$w3' OR name = '$w4') AND name = '$p8')");
				}
		        break;
	    }




	};

};


?>