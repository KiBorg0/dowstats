<?php
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];
setlocale(LC_TIME, "ru_RU.utf8");
date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");

echo "реплей: ". $_POST['replay'];

?>

<style>
.vyrovnyat {
  position: relative;
  height: 400px;
  background: #fff5d7;
}
.vyrovnyat img { /* для IE8+ */
  position: absolute;  /* подробнее про position: absolute; */
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  margin: auto;
  max-width: 100%;
  max-height: 100%;
}
</style>

<div class="vyrovnyat"> 
  <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/43/43fb106b175fdc36c29d188017aadbd2741532bd_full.jpg" alt="">
</div>