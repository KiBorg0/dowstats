<?php

	$key = $_GET["key"];
	$steamid = isset($_GET["steamid"])?$_GET["steamid"]:"temp";
	$type = $_GET["type"];
	$version = isset($_GET['version'])?$_GET['version']:"temp";
	if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
		echo "wrong key";
		return;
	}

	global $_FILES;

	$uploaddir  = "logfiles/";
	$warnings_l = "warnings/";
	$udates_l    = "updates/";
	$uploaddir .= $version."/";
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
	

	if (move_uploaded_file($_FILES['logfile']['tmp_name'], $uploadfile))
	    echo $uploadfile . " the log file has been successfully downloaded.";
	else
	    echo $uploadfile . " failed to load a log file!";
?>
