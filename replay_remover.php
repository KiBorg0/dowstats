<?php
header('Content-Type: text/html; charset=utf-8');
$key = $_GET["key"];
if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	echo "wrong key";
	return;
}

$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");

$mysqli->real_query(" SELECT * FROM games");

$res = $mysqli->store_result();
$counter = 0;
$filesize = 0;
while ($row = $res->fetch_assoc()) {
	if(file_exists(urldecode($row['replay_link']))&&($row['type']>=2||$row['gTime']<=120||$row['game_mod']!='dxp2')&&$row['rep_download_counter']==0){
		if(unlink(urldecode($row['replay_link'])))
		{
			$id = $row['id'];
			echo "file ".urldecode($row['replay_link'])	."successfully removed<br/>";
			$mysqli->real_query("UPDATE games SET replay_link='' WHERE id='$id'");
		}
	}
	// файл не существует, проверим пуста ли ссылка на него, если нет, то удалим ее
	else if($row['replay_link']!=''&&($row['type']>=2||$row['gTime']<=120||$row['game_mod']!='dxp2')&&$row['rep_download_counter']==0){
		echo $row['replay_link'].' link removed '.$row['id'].'<br/>';
		$mysqli->real_query("UPDATE games SET replay_link='' WHERE id = '".$row['id']."'");
	}
	// файл не сущестует и ссылка пуста, проверим реплеи которые именовались по старому
	// когда не останется сомнений в том что реплеи больше не именуются подобным образом, это код можно будет удалить
	else if(file_exists("replays/".$row['id'].".rec")&&($row['type']>=2||$row['gTime']<=120||$row['game_mod']!='dxp2')&&$row['rep_download_counter']==0){
		if(unlink("replays/".$row['id'].".rec"))
			echo "file "."replays/".$row['id'].".rec"."successfully removed<br/>";
	}
	// если одно из условий не выполнилось, значит реплей не подходит под критерии удаления,
	// выведем реплеи которые хранятся на сервере и посчитаем их количество, а так же сколько места они занимают
	else if(file_exists("replays/".$row['id'].".rec"))
	{
		$filesize += filesize("replays/".$row['id'].".rec");
		$counter++;
		echo "replays/".$row['id'].".rec<br/>";
	}
	else if(file_exists(urldecode($row['replay_link']))){
		$filesize += filesize(urldecode($row['replay_link']));
		$counter++;
		echo urldecode($row['replay_link']).'</br>';
	}
}
echo $filesize." байт</br>";  
// Если размер больше 1 Кб
if($filesize > 1024)
{
	$filesize = ($filesize/1024);
	// Если размер файла больше Килобайта
	// то лучше отобразить его в Мегабайтах. Пересчитываем в Мб
	if($filesize > 1024)
	{
	    $filesize = ($filesize/1024);
	   // А уж если файл больше 1 Мегабайта, то проверяем
	   // Не больше ли он 1 Гигабайта
	   if($filesize > 1024)
	   {
	       $filesize = ($filesize/1024);
	       $filesize = round($filesize, 1);
	       echo $filesize." ГБ</br>";       
	   }
	   else
	   {
	       $filesize = round($filesize, 1);
	       echo $filesize." MБ</br>";   
	   }       
	}
	else
	{
	   $filesize = round($filesize, 1);
	   echo $filesize." Кб</br>";   
	}  
}
else
{
    $filesize = round($filesize, 1);
    echo $filesize." байт</br>";   
}
echo $counter.' replays on server';
?>
