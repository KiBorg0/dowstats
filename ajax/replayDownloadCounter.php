<?php
$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
$game_id = mysqli_real_escape_string($mysqli, $_GET["game_id"]);
$mysqli->real_query("UPDATE games SET rep_download_counter = rep_download_counter + 1 WHERE id = '$game_id'");
?>