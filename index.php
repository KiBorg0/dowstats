<?php

header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

setlocale(LC_TIME, "ru_RU.utf8");

date_default_timezone_set('Europe/Moscow');

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
if ($mysqli->connect_error) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_error . ") " ;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

    <head>

        <title>Soulstorm - статистика</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
        <title>Circle by templatemo</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <!-- 
        Circle Template 
        http://www.templatemo.com/preview/templatemo_410_circle 
        -->

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
        	$(document).ready(function () {
            $('#overall_stat').addClass('active');
        });
        </script>



    </head>

    <body>


    <div class="container-fluid">
        <div class="row">
            
            <?php include "header.php"; ?>

            <div class="col-md-12">
                
                <div id="menu-container">

                    <div id="menu-1" class="about content">
                        <div class="row">

                            <div class="col-xs-12 col-xs-12">
                                
                                <div class="toggle-content text-center">
                                <div   role="group" >
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-primary"  onclick="SendAllStat();"  role="group">Общая</button>
                                      	<button class="btn btn-primary" onclick="SendSmStat();" role="group">Космодесант</button>
                                      	<button class="btn btn-primary" onclick="SendChaosStat();" role="group">Хаос</button>
                                      	<button class="btn btn-primary"  onclick="SendOrkStat();"  role="group">Орки</button>
                                     	<button class="btn btn-primary" onclick="SendEldStat();" role="group">Эльдары</button>
                                     	<button class="btn btn-primary" onclick="SendIGStat();"  role="group">ИГ</button>
                                     	<button class="btn btn-primary" onclick="SendNecronStat();" role="group">Некроны</button>
                                     	<button class="btn btn-primary" onclick="SendTauStat();" role="group">Тау</button>
                                     	<button class="btn btn-primary" onclick="SendSistersOfBattleStat();" role="group">Сёстры</button>
                                     	<button class="btn btn-primary" onclick="SendDEStat();" role="group">ТЭ</button>
                                    </div>
                                </div>

                                	

                                     <center>
                                     <div id="result"></div>
                                     
                                    </center>
                                </div>


                            </div> <!-- /.col-md-12 -->
                        </div> <!-- /.row -->


                    </div> <!-- /.about -->


                </div> <!-- /#menu-container -->

            </div> <!-- /.col-md-8 -->

        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
    
    <div class="container-fluid">   
        <div class="row">
            <div class="col-md-12 footer">
                <h4 id="footer-text">
                разработчик - <a href="https://vk.com/id59975761">Anibus</a> & <a href="https://vk.com/lebedkooa">New .</a><br>
                </h4>
            </div><!-- /.footer --> 
        </div>
    </div> <!-- /.container-fluid -->


       

    </body>

</html>
