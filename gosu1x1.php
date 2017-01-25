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
	    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet">

	    <link rel="stylesheet" href="css/bootstrap.min.css">
	    <link rel="stylesheet" href="css/normalize.min.css">
	    <link rel="stylesheet" href="css/font-awesome.min.css">
	    <link rel="stylesheet" href="css/animate.css">
	    <link rel="stylesheet" href="css/templatemo_misc.css">
	    <link rel="stylesheet" href="css/templatemo_style.css">

	    <script src="js/vendor/modernizr-2.6.2.min.js"></script>

    </head>

    <body>
 <div class="bg-overlay"></div>

    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-4 col-sm-12">
                <div class="sidebar-menu">
                    
                    <div class="logo-wrapper">
                        <h1 class="logo">
                            <a rel="nofollow" href="http://vk.com/warhammer_odessa"><img src="images/logo.png" alt="Circle Template"></a>
                            <span>Онлайн статистика<br><a href="https://drive.google.com/file/d/0B85g4F5ndVDRbHJPbFdJclRXTjA/view?usp=sharing">v 0.84-P - скачать</a></span>
                        </h1>
                    </div> <!-- /.logo-wrapper -->
                    
                    <div class="menu-wrapper">
                        <ul class="menu">
                            <li><a class="show-1" href="#">Общая статистика</a></li>
                            <li><a class="show-3" href="#">Gosu 1x1</a></li>
                            <li><a class="show-2" href="#">Cражения</a></li>
                        </ul>
                        <a href="#" class="toggle-menu"><i class="fa fa-bars"></i></a>
                    </div> <!-- /.menu-wrapper -->


                </div> <!-- /.sidebar-menu -->
            </div> <!-- /.col-md-4 -->

            <div class="col-md-8 col-sm-12">
                
                <div id="menu-container">

                    <div id="menu-1" class="about content">
                        <div class="row">
                            <ul class="tabs">
                                <li class="col-md-4 col-sm-4">
                                    <a href="#tab1" class="icon-item">
                                        <i class="fa fa-users"></i><br>

                                        общая статистика
                                    </a> <!-- /.icon-item -->
                                </li>
                                <li class="col-md-4 col-sm-4">
                                    <a href="#tab2" class="icon-item">
                                        <i class="fa fa-clock-o"></i><br>
                                        больше всего сыграно
                                    </a> <!-- /.icon-item -->
                                </li>
                                <li class="col-md-4 col-sm-4">
                                    <a href="#tab3" class="icon-item">
                                        <i class="fa fa-star-half-o"></i><br>
                                        топ 20 игроков
                                    </a> <!-- /.icon-item -->
                                </li>

                            </ul> <!-- /.tabs -->
                            <div class="col-md-12 col-sm-12">
	                            
                                <div class="toggle-content text-center" id="tab1">
                                	<div class="btn-group btn-group-justified"  role="group">
	                            	<div class="btn-group" role="group">
									  	<button class="btn"  onclick="SendAllStat();"  role="group">Общая</button>
								  	</div>
							  		<div class="btn-group" role="group">
									  <button class="btn btn-blue" onclick="SendSmStat();" role="group">Космодесант</button>
								  	</div>
									<div class="btn-group" role="group">
									  <button class="btn btn-blue" onclick="SendChaosStat();" role="group">Хаос</button>
								  	</div>
								  	<div class="btn-group" role="group">
									  <button class="btn btn-blue"  onclick="SendOrkStat();"  role="group">Орки</button>
								  	</div>
								  	<div class="btn-group" role="group">
									  <button class="btn btn-blue" onclick="SendEldStat();" role="group">Эльдары</button>
								  	</div>
								</div>
								<br>
								<div class="btn-group btn-group-justified"  role="group">
	                            	<div class="btn-group" role="group">
									  	<button class="btn" onclick="SendIGStat();"  role="group">ИГ</button>
								  	</div>
							  		<div class="btn-group" role="group">
									  <button class="btn btn-blue" onclick="SendNecronStat();" role="group">Некроны</button>
								  	</div>
									<div class="btn-group" role="group">
									  <button class="btn btn-blue" onclick="SendTauStat();" role="group">Тау</button>
								  	</div>
								  	<div class="btn-group" role="group">
									  <button class="btn btn-blue" onclick="SendSistersOfBattleStat();" role="group">Сёстры</button>
								  	</div>
								  	<div class="btn-group" role="group">
									  <button class="btn btn-blue" onclick="SendDEStat();" role="group">ТЭ</button>
								  	</div>
								</div>
								<br>
								
                                    

                                     <center>
                                     <div id="result"></div>
                                     
									</center>
                                </div>

                                <div class="toggle-content text-center" id="tab2">
                                    <h3>больше всего сыграно</h3>
                                     <TABLE  class="table table-striped table-hover text-center">
							            <thead><tr>
							            <td>игрок</td><td>игровое время</td><td>среднее за игру</td>
							            </tr>
							            </thead>
							            <?
							            $mysqli->real_query("SELECT * FROM players ORDER BY time DESC");
							            $res = $mysqli->use_result();
							            while ($row = $res->fetch_assoc()) {
											echo "<tr>";
											echo "<td>" . $row['name'] . "</td>";
											$timehelpint = $row['time'] / 60;
	                    					$timehours = floor($timehelpint / 60);
											echo "<td>" . $timehours . " ч.   " . $timehelpint % 60 .  " мин.   " . $row['time'] % 60 . " сек. </td>";
											$all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
											$all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
											$all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
											$all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
											$all = $all1x1 + $all2x2 + $all3x3 + $all4x4;
											if($all != 0){
												$allGamesTime =  round($row['time'] / $all);
											}else{
												$allGamesTime = 0;
											}
											$timehelpint = floor($allGamesTime / 60);
											echo "<td>" . $timehelpint  .  " мин.   " . $allGamesTime % 60 . " сек. </td>";
											echo "</tr>";
										}
							            ?>
									</TABLE>
                                </div>

                                <div class="toggle-content text-center" id="tab3">
                                    <h3>топ 20 игроков</h3>
                                    <TABLE  class="table table-striped table-hover text-center">
							            <thead><tr>
							            <td>место</td><td>игрок</td><td>всего игр</td><td>побед</td><td>% побед</td>
							            </tr>
							            </thead>
                                        <?
                                        $array = array();  
                                        $mysqli->real_query("SELECT * FROM players ORDER BY time DESC");
                                        $res = $mysqli->use_result();
                                        $int = 0;
                                        while ($row = $res->fetch_assoc()) {
                                            $all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
                                            $all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
                                            $all3x3 =  $row['3x3_1'] + $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9'];
                                            $all4x4 =  $row['4x4_1'] + $row['4x4_2'] +  $row['4x4_3'] +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9'];
                                            $all = $all1x1 + $all2x2 + $all3x3 + $all4x4;

                                            $win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
                                            $win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
                                            $win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w'];
                                            $win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w'];
                                            $win = $win1x1 + $win2x2 + $win3x3 + $win4x4;
                                            $row["all"] = $all;
                                            $row["win"] = $win;
                                            if($all != 0){
                                                $row['percent'] = round(100*$win/$all);
                                            }else{
                                                $row['percent'] = 0;
                                            }
                                            $array[$int] = $row;
                                            $int = $int + 1;
                                        }

                                        for($j = 0; $j < sizeof($array)-1;$j++)
                                        {
                                            for($i = 0; $i < sizeof($array) - $j - 1;$i++)
                                            {
                                                if ($array[$i]['percent'] > $array[$i+1]['percent']) {
                                                 $b = $array[$i]; //change for elements
                                                 $array[$i] = $array[$i+1];
                                                 $array[$i+1] = $b;
                                                }
                                            }
                                        }

                                        $limitTop = 20;
                                         $place = 1;
                                        for($j = sizeof($array)-1; $j > 0;$j--)
                                        {   
                                            if($array[$j]['all'] >= 10){
                                                echo "<tr>";
                                                echo "<td>". $place . "</td>";
                                                echo "<td>". $array[$j]['name'] . "</td>";
                                                 echo "<td>". $array[$j]['all'] . "</td>";
                                                 echo "<td>". $array[$j]['win'] . "</td>";
                                                echo "<td>". $array[$j]['percent'] . "%</td>";
                                                echo "</tr>";
                                                $place = $place + 1;
                                                if($limitTop <= 0){
                                                    break;
                                                }
                                            }
                                        }

                                        ?>

									</TABLE>
									ТОП 20 учитывается только после 10 сыгранных матчей
                                </div>
                            </div> <!-- /.col-md-12 -->
                        </div> <!-- /.row -->


                    </div> <!-- /.about -->

                    <div id="menu-2" class="services content">
                        <div class="row">
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
                                    <h3>Недавние сражения 1x1 2x2 3x3 4x4</h3>
                                    <?
                                    include 'view/allGames.php';
                                    ?>
                                </div>

                            </div> <!-- /.col-md-12 -->
                        </div> <!-- /.row -->
                    </div> <!-- /.services -->

                    <div id="menu-3" class="gallery content">

                        <div class="row">
                            <ul class="tabs">
                                <li class="col-md-6 col-sm-6">
                                    <a href="#tab4" class="icon-item">
                                        <i class="fa fa-users"></i><br>
                                        общая статистика 1x1
                                    </a> 
                                </li>
                                <li class="col-md-6 col-sm-6">
                                    <a href="#tab5" class="icon-item">
                                        <i class="fa fa-star-half-o"></i><br>
                                        топ 20 игроков 1x1
                                    </a> 
                                </li>
                               
                            </ul>
                        <div class="col-md-12 col-sm-12">
                                

                                <!--  1x1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                <div class="toggle-content text-center" id="tab4">
                                    <div class="btn-group btn-group-justified"  role="group">
                                    <div class="btn-group" role="group">
                                        <button class="btn"  onclick="SendAllStat1x1();"  role="group">Общая</button>
                                    </div>
                                    <div class="btn-group" role="group">
                                      <button class="btn btn-blue" onclick="SendSmStat1x1();" role="group">Космодесант</button>
                                    </div>
                                    <div class="btn-group" role="group">
                                      <button class="btn btn-blue" onclick="SendChaosStat1x1();" role="group">Хаос</button>
                                    </div>
                                    <div class="btn-group" role="group">
                                      <button class="btn btn-blue"  onclick="SendOrkStat1x1();"  role="group">Орки</button>
                                    </div>
                                    <div class="btn-group" role="group">
                                      <button class="btn btn-blue" onclick="SendEldStat1x1();" role="group">Эльдары</button>
                                    </div>
                                </div>
                                <br>
                                <div class="btn-group btn-group-justified"  role="group">
                                    <div class="btn-group" role="group">
                                        <button class="btn" onclick="SendIGStat1x1();"  role="group">ИГ</button>
                                    </div>
                                    <div class="btn-group" role="group">
                                      <button class="btn btn-blue" onclick="SendNecronStat1x1();" role="group">Некроны</button>
                                    </div>
                                    <div class="btn-group" role="group">
                                      <button class="btn btn-blue" onclick="SendTauStat1x1();" role="group">Тау</button>
                                    </div>
                                    <div class="btn-group" role="group">
                                      <button class="btn btn-blue" onclick="SendSistersOfBattleStat1x1();" role="group">Сёстры</button>
                                    </div>
                                    <div class="btn-group" role="group">
                                      <button class="btn btn-blue" onclick="SendDEStat1x1();" role="group">ТЭ</button>
                                    </div>
                                </div>
                                <br>
                                <center>
                                     <div id="result1x1">Тут будет ответ от сервера</div>
                                     
                                    </center>
                               

                                </div>
                                <!-- TOP 20 1x1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                                 <div class="toggle-content text-center" id="tab5">
                                    <h3>топ 20 игроков 1x1</h3>
                                    <TABLE  class="table table-striped table-hover text-center">
                                        <thead><tr>
                                        <td>место</td><td>игрок</td><td>всего игр</td><td>побед</td><td>% побед</td><td>SOLO MMR</td>
                                        </tr>
                                        </thead>
                                        <?
                                        $array = array();  
                                        $mysqli->real_query("SELECT * FROM players ORDER BY mmr DESC");
                                        $res = $mysqli->use_result();
                                        $int = 0;
                                        while ($row = $res->fetch_assoc()) {
                                            $all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
                                            $all = $all1x1 ;

                                            $win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
                                            $win = $win1x1;
                                            $row["all"] = $all;
                                            $row["win"] = $win;
                                            if($all != 0){
                                                $row['percent'] = round(100*$win/$all);
                                            }else{
                                                $row['percent'] = 0;
                                            }
                                            $array[$int] = $row;
                                            $int = $int + 1;
                                        }

                                        /*for($j = 0; $j < sizeof($array)-1;$j++)
                                        {
                                            for($i = 0; $i < sizeof($array) - $j - 1;$i++)
                                            {
                                                if ($array[$i]['percent'] > $array[$i+1]['percent']) {
                                                 $b = $array[$i]; //change for elements
                                                 $array[$i] = $array[$i+1];
                                                 $array[$i+1] = $b;
                                                }
                                            }
                                        }*/

                                        $limitTop = 20;
                                        $place = 1;
                                        for($j = 0; $j < sizeof($array);$j++)
                                        {   
                                            if($array[$j]['all'] >= 10){
                                                echo "<tr>";
                                                echo "<td>".  $place . "</td>";
                                                echo "<td><a href = 'http://dowstats.h1n.ru/player.php?name=".  $array[$j]['name']  ."'>" . $array[$j]['name']  . "</a></td>";
                                                 echo "<td>". $array[$j]['all'] . "</td>";
                                                 echo "<td>". $array[$j]['win'] . "</td>";
                                                echo "<td>". $array[$j]['percent'] . "%</td>";
                                                echo "<td>". $array[$j]['mmr'] . "</td>";

                                                echo "</tr>";
                                                 $place =  $place + 1;
                                                if($limitTop <= 0){
                                                    break;
                                                }
                                            }
                                        }

                                        ?>

                                    </TABLE>
                                    ТОП 20 учитывается только после 10 сыгранных матчей
                                </div>



                    </div> <!-- /.about -->
                    </div> <!-- /.gallery -->
                    </div> <!-- /.gallery -->

                    <div id="menu-4" class="contact content">
                       
                    </div> <!-- /.contact -->

                </div> <!-- /#menu-container -->

            </div> <!-- /.col-md-8 -->

        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
    
    <div class="container-fluid">   
        <div class="row">
            <div class="col-md-12 footer">
                <h4 id="footer-text">
                разработчик - <a href="https://vk.com/id59975761">Anibus</a><br>
                Copyright &copy; 2015 <a href="https://vk.com/warhammer_odessa">Warhammer_Odessa</a>
                </h4>
            </div><!-- /.footer --> 
        </div>
    </div> <!-- /.container-fluid -->


	<script type="text/javascript" src="http://scriptjava.net/source/scriptjava/scriptjava.js"></script>
    <script src="js/vendor/jquery-1.10.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
    <script src="js/jquery.easing-1.3.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
            
			jQuery(function ($) {

                $.supersized({

                    // Functionality
                    slide_interval: 25000, // Length between transitions
                    transition: 1, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed: 700, // Speed of transition

                    // Components                           
                    slide_links: 'blank', // Individual links for each slide (Options: false, 'num', 'name', 'blank')
                    slides: [ // Slideshow Images
                        {
                            image: 'images/templatemo-slide-1.jpg'
                        }, {
                            image: 'images/templatemo-slide-2.jpg'
                        }, {
                            image: 'images/templatemo-slide-3.jpg'
                        }, {
                            image: 'images/templatemo-slide-4.jpg'
                        }, {
                            image: 'images/templatemo-slide-5.jpg'
                        }, {
                            image: 'images/templatemo-slide-6.jpg'
                        }
                    ]

                });
            });
            
    </script>
    
    	<!-- Google Map -->
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="js/vendor/jquery.gmap3.min.js"></script>
        
        <!-- Google Map Init-->
        <script type="text/javascript">
           function templatemo_map() {
                $('.google-map').gmap3({
                    marker:{
                        address: '16.8496189,96.1288854' 
                    },
                        map:{
                        options:{
                        zoom: 15,
                        scrollwheel: false,
                        streetViewControl : true
                        }
                    }
                });
            }
        </script>

       

    </body>

</html>
