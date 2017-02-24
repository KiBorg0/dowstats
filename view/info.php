<?php
$startFrom = isset($_GET['startFrom']) ? $_GET['startFrom'] : 0;

$mysqligame = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$mysqligame->set_charset("utf8");

$mysqligame->real_query("SELECT * FROM url_logs ORDER BY id DESC LIMIT {$startFrom},20");
$res = $mysqligame->store_result();

echo "<tr>
<td style = 'width:10%; '>id</td>
<td style = 'width:40%;'>url</td>
<td style = 'width:15%;'>информация по реплею</td>
<td style = 'width:35%;'>информация по действиям запроса</td></tr>";

while ($row = $res->fetch_assoc()) {
	
	echo "<tr>
	<td>" . $row['id'] 							  ."</td>
	<td>" . str_replace("&", "&amp;", $row['url'])."</td>
	<td>" . $row['replay_var_dump']			      ."</td>
	<td>" . $row['apm_calc']					  ."</td></tr>";
	
}

?>