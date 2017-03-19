<?php
require_once("../lib/NickDecode.php");

$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
if ($mysqli->connect_error) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_error . ") " ;
}
//ищем по кодируем ник, который пришел от поля ввода и защищаем от sql инъекции
$searchname = NickDecode::codeNick(mysql_real_escape_string($_GET["playername"]));

$mysqli->real_query("SELECT name FROM players WHERE name LIKE '%$searchname%' ");
$res = $mysqli->store_result();
$nick_array[] = array();	
while ($row = $res->fetch_assoc()) {
	echo NickDecode::decodeNick($row["name"]) . ",";
}


?>