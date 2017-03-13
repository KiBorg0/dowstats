<?php

$key = $_GET["key"];
if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	echo "wrong key";
	return;
}

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");

$mysqli->real_query(" SELECT * FROM games");

$res = $mysqli->use_result();

while ($row = $res->fetch_assoc()) {
	if(file_exists("replays/".$row['id'].".rec")&&$row['type']>=2)
	{
		if(unlink("replays/".$row['id'].".rec"))
			echo "file "."replays/".$row['id'].".rec"."successfully removed<br/>";
	}
	else
		echo "replays/".$row['id'].".rec<br/>";
}
?>
