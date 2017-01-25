<?

header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');



/*

Directory Listing Script - Version 2

====================================

Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net

Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk

*/

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

    <head>

        <title>Soulstorm - статистика</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta charset="utf-8">
        <link href="css/main.css" rel="stylesheet"/>
        <link href="css/battles.css" rel="stylesheet"/>
        <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css" rel="stylesheet"/>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script type="text/javascript" src="js/battles.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
            $('#battles').addClass('active');
        });
        </script>



    </head>

<body>
<?php include "header.php"; ?>
    <div class="container">
        <div class="row">
            
            

            <div class="col-md-12">
                
                <!--<ul class="tabs">
                    <li class="col-md-4 col-sm-4">
                        <a href="#tab4" class="icon-item">
                            <i class="fa fa-cogs"></i>
                        </a> 
                    </li>
                    <li class="col-md-4 col-sm-4">
                        <a href="#tab5" class="icon-item">
                            <i class="fa fa-leaf"></i>
                        </a> 
                    </li>
                    <li class="col-md-4 col-sm-4">
                        <a href="#tab6" class="icon-item">
                            <i class="fa fa-users"></i>
                        </a> 
                    </li>
                </ul>  -->
                <div class="col-md-12 col-sm-12">
                    <div class="toggle-content text-center">

                    	<!-- поиск поиск поиск поиск поиск поиск поиск поиск поиск поиск поиск поиск поиск поиск поиск поиск -->
	                    
	                    <br/>
						<div class="navbar-form navbar-left" style="width:400px;">
							<div class="form-group ">
							    <input id="player_name_input" onkeydown=" player_name_input_keypress_battles(event)" style="width:300px;" class="form-control autocomplete" placeholder="Поиск по имени игрока/клана" >
							</div>
							<a class="btn btn-default" onclick = "search_player_battles()"><span class="glyphicon glyphicon-search"></span></a>
						</div>
						<span id = "search_advice_wrapper"></span>

						<div style = "clear:both"/>
                        <h3>Недавние сражения</h3>
                        <div id = "fight_result">
                        
                        </div>
                        <div id="scrollup"><img alt="Прокрутить вверх" src="images/arrows7.png"><br/>Вверх</div>
                    </div>

                </div> <!-- /.col-md-12 -->

            </div> <!-- /.row -->
	    </div> <!-- /.container-fluid -->
	    
	    <div class="container-fluid">   
	        <div class="row">
	            <div class="col-md-12 footer">
	                <h4 id="footer-text">
	                разработчик - <a href="https://vk.com/id59975761">Anibus</a> & <a href="https://vk.com/lebedkooa">New .</a><br>
	                </h4>
	            </div>
	        </div>
	    </div> 
    </div>
</body>

</html>
