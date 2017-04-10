<?php

$key = isset($_GET["key"])?$_GET["key"]:'';
$name = isset($_GET["name"])?$_GET["name"]:'';
$filetype = isset($_GET["filetype"])?$_GET["filetype"]:'';
if($key !== "80bc7622e3ae9980005f936d5f0ac6cd"){
	echo "неверный ключ";
	return;
}
if($filetype == 'map')
	$ssstatsdir =  "maps/";
else
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
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($file));
    header('Content-Type: application/octet-stream');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
	readfile($file);
}

?>
