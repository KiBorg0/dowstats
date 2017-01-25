<?php

	$key = $_GET["key"];
	$steamid = $_GET["steamid"];
	$type = $_GET["type"];
	$version = $_GET['version'];
	if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
		echo "неверный ключ";
		return;
	}

	global $_FILES;

	$version = $version."/";
	$uploaddir  = "logfiles/";
	$warnings_l = "warnings/";
	$udates_l    = "updates/";
	$uploaddir .= $version;
	if(!is_dir($uploaddir)) mkdir($uploaddir);
	if(!is_dir($uploaddir.$warnings_l)) mkdir($uploaddir.$warnings_l);
	if(!is_dir($uploaddir.$udates_l)) mkdir($uploaddir.$udates_l);
	// если это warning, то в имени файла путь к папке warnings
	if($type==1)
		$uploadfile = $uploaddir.$warnings_l.$steamid.".log";
	// иначе, если этот update, то в имени файла путь к папке updates
	else if($type==2)
		$uploadfile = $uploaddir.$udates_l.$steamid.".log";
	// иначе это обычный лог
	else
		$uploadfile = $uploaddir.$steamid.".log";
	

	if (move_uploaded_file($_FILES['logfile']['tmp_name'], $uploadfile)) {
	    echo $steamid . " лог файл был успешно загружен.\n";
	} else {
	    echo $steamid . " = не удалось загузить лог файл!\n";
	}

?>
