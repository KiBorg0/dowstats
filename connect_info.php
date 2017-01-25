<?

header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE HTML>";
$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');


$mysqligame = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$mysqligame->set_charset("utf8");

$mysqligame->real_query("SELECT * FROM url_logs ORDER BY id DESC LIMIT 10");
$res = $mysqligame->use_result();

?>
<head>
	<title>Логи статистики</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php		

echo "<table border='1' ><tr><th>id</th><th>url</th><th>информация по реплею</th><th>информация по действиям запроса</th></tr>";
while ($row = $res->fetch_assoc()) {
	
	echo "<tr><td>".$row['id'] . "</td><td>" . str_replace("&", "&amp;", $row['url']) ."</td><td>" . $row['replay_var_dump']. "</td><td>" . $row['apm_calc']. "</td></tr>";
	
}
echo "</table>";