<?

header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');


$key = $_GET["key"];
if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	echo "неверный ключ";
	return;
}

$mysqligame = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
$mysqligame->real_query("TRUNCATE TABLE games");
$mysqligame->real_query("TRUNCATE TABLE players");
$mysqligame->real_query("TRUNCATE TABLE url_logs");
$mysqligame->real_query("TRUNCATE TABLE connectors");


?>