<?php

header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE HTML>";
$host = $_SERVER['HTTP_HOST'];
setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');

?>
<head>
    <title>Логи статистики</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css"/>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
    <script type="text/javascript" src="js/info.js"></script>
    <script type="text/javascript" src="js/scrollup.js"></script>
</head> 
<style type="text/css">
    table {
    table-layout: fixed;
    width:100%
    }
    td {
        word-wrap:break-word;
    }
</style>
<body>
    <div class="toggle-content text-center">
        <center>
            <?php echo '<table class="table table-striped table-hover text-left" id = "info_result">
            </table>'?>
        </center>   
    </div>
    <div id="scrollup"><img alt=<?php echo "'"._('Scroll Up')."'"?> src="images/arrows7.png"><br/><?php echo _('Up')?></div>
</body>