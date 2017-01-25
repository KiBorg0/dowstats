
<?php 

$mysqligame = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
$replay_info = "данные пост запроса: ";
ob_start();
var_dump($_FILES);
$replay_info .= ob_get_clean();
$replay_info .= $_FILES['replay']['name'];
echo $replay_info;

$rep_num = rand(1,1000);

$uploaddir =  "replays/";
$uploadfile = $uploaddir . $rep_num .".rec";
$replay_info .= "<a href = \"".$uploadfile."\">скачать реплей</a>";
if (move_uploaded_file($_FILES['replay']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$mysqligame->real_query("INSERT INTO url_logs (url,replay_var_dump,apm_calc) VALUES ('$actual_link','$replay_info', '$apm_info') ");

?>
<form action=test.php method=post enctype=multipart/form-data>
<input type=file name=replay>
<input type=submit value=Загрузить></form>