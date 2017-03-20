<?php

$key = isset($_GET["key"])?$_GET["key"]:'';
$name = isset($_GET["name"])?$_GET["name"]:'';
if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	echo "неверный ключ";
	return;
}
$ssstatsdir =  "ssstats/";
if($name == ''){
	
	$versionfile = $ssstatsdir . "stats.ini";
	// echo $versionfile . "\n";
	$stats_ini = parse_ini_file($versionfile, true);
	$stats_ver = $stats_ini['info']['version'] . "\n";
	$stats_ver = str_replace(".", "", $stats_ver);
	echo $stats_ver;
}
else {
	$file = $ssstatsdir . $name;
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=' . $name);
	readfile($file);
}

?>
