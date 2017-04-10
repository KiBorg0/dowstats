<?php
require_once("lib/NickDecode.php");
$str = "YToxOntpOjA7czoxNzoiNzY1NjExOTgwMjY1MzM0NDAiO30=";
echo base64_decode($str).'</br>';
// echo NickDecode::decodeNick("656363686920616e696d65206769726c73").'</br>';
$nicknames = unserialize("a:1:{i:2;s:17:\"76561198026533440\";}");
// $nicknames[0] = 76561198137623178;
// $nicknames[1] = 76561198005373955; 52616d706167657c457a
// $nicknames[2] = 76561198116829514; 476f6f645e47723054
// $nicknames[3] = 76561198223453744; 4261645e47723054
   
var_dump($nicknames);
echo base64_encode(serialize($nicknames));

$str = "";
for($i=1;$i<=4;$i++)
	for($j=1;$j<=9;$j++)
		$str .= '`'.$i.'x'.$i.'_'.$j.'w`>`'.$i.'x'.$i.'_'.$j.'`'."or";
echo $str;
// `1x1_1`
echo '</br>';
// $name = "Grqg|Ez";
echo NickDecode::codeNick('Tooodesschnitzel');
// for($j=0;$j<sizeof($nicknames);$j++) {
// 	echo NickDecode::decodeNick($nicknames[$j]).'</br>';
// }
// if($nicknames?(!in_array($name, $nicknames)):true)
// {
// 	$nicknames[]=$name;
// 	$nicknames_str = base64_encode(serialize($nicknames));
// 	echo $nicknames_str.'</br>';
// 	// $mysqligame->real_query("UPDATE players SET last_nicknames = '$nicknames_str' WHERE sid = '$sid'");
// }

echo '</br>';
?>
<!-- Grqg </br>
Grqg|Ez </br>
http://www.dowstats.h1n.ru/regplayer.php?=&key=80bc7622e3ae9980005f936d5f0ac6cd&name0=656363686920616e696d65206769726c73&sid0=76561198345985647 -->