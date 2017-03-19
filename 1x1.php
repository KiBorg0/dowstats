<?
session_start();
header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

$lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
putenv('LC_ALL=' . $lang);
setlocale(LC_ALL, $lang, $lang . '.utf8');
bind_textdomain_codeset($lang, 'UTF-8');
bindtextdomain($lang, 'locale');
textdomain($lang);

date_default_timezone_set('Europe/Moscow');

// echo $_SESSION['lang'];

/*

Directory Listing Script - Version 2

====================================

Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net

Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk

*/

$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

    <head>

        <title><?php echo _('Soulstorm Ladder')?></title>

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
        <script type="text/javascript">
            var lang = '<?php echo $lang?>';
        </script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/1x1.js"></script>
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
        <button class="btn btn-primary" onclick="SendAllStat();" role="group"><?php echo _('General')?></button>
      	<button class="btn btn-primary" onclick="SendRaceStat(1);" role="group"><?php echo _('SM')?></button>
      	<button class="btn btn-primary" onclick="SendRaceStat(2);" role="group"><?php echo _('Chaos')?></button>
      	<button class="btn btn-primary" onclick="SendRaceStat(3);" role="group"><?php echo _('Orks')?></button>
     	<button class="btn btn-primary" onclick="SendRaceStat(4);" role="group"><?php echo _('Eldar')?></button>
     	<button class="btn btn-primary" onclick="SendRaceStat(5);" role="group"><?php echo _('IG')?></button>
     	<button class="btn btn-primary" onclick="SendRaceStat(6);" role="group"><?php echo _('Necrons')?></button>
     	<button class="btn btn-primary" onclick="SendRaceStat(7);" role="group"><?php echo _('Tau Empire')?></button>
     	<button class="btn btn-primary" onclick="SendRaceStat(8);" role="group"><?php echo _('SoB')?></button>
     	<button class="btn btn-primary" onclick="SendRaceStat(9);" role="group"><?php echo _('DE')?></button>
                                    </div>
                                </div>



                                </div>


                            </div> <!-- /.col-md-12 -->
                        </div> <!-- /.row -->


                    </div> <!-- /.about -->


                </div> <!-- /#menu-container -->

            </div> <!-- /.col-md-8 -->

        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
    <center>
        <div id="result"></div>
    </center>
    </body>

</html>
