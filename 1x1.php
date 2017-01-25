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

function getRace($num){
    switch($num){
        case 1:
            return "Космодесант";
            break;
        case 2:
            return "Хаос";
            break;
        case 3:
            return "Орки";
            break;
        case 4:
            return "Эльдары";
            break;
        case 5:
            return "Имперская гвардия";
            break;
        case 6:
            return "Некроны";
            break;
        case 7:
            return "Империя Тау";
            break;
        case 8:
            return "Сёстры битвы";
            break;
        case 9:
            return "Темные эльдары";
            break;
    }
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
            $('#1x1_stat').addClass('active');
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
                                        <button class="btn btn-primary"  onclick="SendAllStat1x1();"  role="group">Общая</button>
                                      	<button class="btn btn-primary" onclick="SendSmStat1x1();" role="group">Космодесант</button>
                                      	<button class="btn btn-primary" onclick="SendChaosStat1x1();" role="group">Хаос</button>
                                      	<button class="btn btn-primary"  onclick="SendOrkStat1x1();"  role="group">Орки</button>
                                     	<button class="btn btn-primary" onclick="SendEldStat1x1();" role="group">Эльдары</button>
                                     	<button class="btn btn-primary" onclick="SendIGStat1x1();"  role="group">ИГ</button>
                                     	<button class="btn btn-primary" onclick="SendNecronStat1x1();" role="group">Некроны</button>
                                     	<button class="btn btn-primary" onclick="SendTauStat1x1();" role="group">Тау</button>
                                     	<button class="btn btn-primary" onclick="SendSistersOfBattleStat1x1();" role="group">Сёстры</button>
                                     	<button class="btn btn-primary" onclick="SendDEStat1x1();" role="group">ТЭ</button>
                                    </div>
                                </div>


                                     <center>
                                     <div id="result1x1"></div>
                                     
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
