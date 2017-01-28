<?
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];
setlocale(LC_TIME, "ru_RU.utf8");
date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");

/*

Directory Listing Script - Version 2

====================================

Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net

Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk

*/
$steamid = "";
$name = $_GET["name"];
$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
if ($mysqli->connect_error) {
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
        <script type="text/javascript" src="js/player.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script>



    </head>

    <body>

    <div class="container-fluid">
        <div class="row">
            <?php include "header.php"; ?>
            <center>
            	<?php
            	$mysqli->real_query("SELECT * FROM players WHERE name = '$name'");//----------здесь делается запрос на игрока------------(1)
                $res = $mysqli->use_result();
                $row = $res->fetch_assoc();
                $steamid = $row['sid'];
                $big_avatar_url = Steam::get_big_avatar_url_by_id($row['sid']);
                echo '<a href="https://steamcommunity.com/profiles/'. $steamid . '">'."<img class = 'avatar_big' src='" . $big_avatar_url . "'>".'</a>';	
                ?>
            	<h1><?php echo NickDecode::decodeNick($name); ?></h1>

            </center>
			<div class="toggle-content text-center">
	            <div   role="group" >
	                <div class="btn-group" role="group">
	                	<button class="btn btn-primary"  onclick="show_tab('tab1');"  role="group">Общая статистика</button>
	                    <button class="btn btn-primary"  onclick="show_tab('tab2');"  role="group">1x1</button>
	                  	<button class="btn btn-primary" onclick="show_tab('tab3');" role="group">2x2</button>
	                  	<button class="btn btn-primary" onclick="show_tab('tab4');" role="group">3x3 & 4x4</button>
	                  	<button class="btn btn-primary"  onclick="show_tab('tab5');"  role="group">Последние игры</button>
	                </div>
	            </div>
	        </div>  

            <div class="col-md-12 col-sm-12">
                
                <div class="toggle-content text-center tabs" id="tab1" >

                    <?
                    echo '<a href="http://vk.com/share.php?url=http://dowstats.h1n.ru/player.php?name='. $name . '" target="_blank" class="btn right"> <i class="fa fa-comments"></i> Поделиться статистикой в ВК</a>';
                    $cTimeMAX = date('Y-m-d H:i:s', time());
                    
                    echo '<h3>общая статистика - '. '<a href="https://steamcommunity.com/profiles/'. $steamid . '">' . NickDecode::decodeNick($name) .'</a>'. '</h3>';
                    $all = "ip_adr = " . $_SERVER['REMOTE_ADDR'] . " " .$name . " uAgent = " . $_SERVER['HTTP_USER_AGENT'] . "t= " . $cTimeMAX ;
                    $mysqli->real_query("INSERT INTO connectors (connectorsT) values ('$all')  ");
                    //из запроса (1)
                    $isPlExist = false;
                    $all = 0;
                    $win = 0;
                        $all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
                        $all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
                        $all3x3 =  $row['3x3_1'] +  $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9']; 
                        $all4x4 =  $row['4x4_1'] +  $row['4x4_2'] + $row['4x4_3']  +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9']; 
                        $all = $all3x3 + $all4x4 + $all2x2 + $all1x1;

                        $win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
                        $win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
                        $win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w']; 
                        $win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w']; 
                        $win = $win1x1 + $win2x2 + $win3x3 + $win4x4;
                        $isPlExist = true;
                    $Wnr8 =  50;
                    if($all != 0){
                        $Wnr8 =  round (100 * $win/$all);
                    }

                    if(!$isPlExist){
                        echo "<h1>Игрок не найден в базе</h1>";
                        echo "<img src = 'images/notFound.png'>";
                    }
                    
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");        
                    $res = $mysqli->use_result();

                        echo '<h5>SOLO MMR: ' . $row['mmr'] . '<br>';
                        $timehelpint = $row['time'] / 60;
    					$timehours = intval($timehelpint / 60);
                    	echo 'игровое время: ' . $timehours . " ч.   " . $timehelpint % 60 .  " мин.   " . $row['time'] % 60 . ' сек.<br>';
                    	//---------любимая раса -----------------
                    	$favRace = 0;
						$countWinRace = 0;
						if($countWinRace <  $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1']){
							$favRace = 1;
							$countWinRace = $row['1x1_1'] +  $row['2x2_1'] +  $row['3x3_1'] + $row['4x4_1'];
						}
						if($countWinRace <  $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2']){
							$favRace = 2;
							$countWinRace = $row['1x1_2'] +  $row['2x2_2'] +  $row['3x3_2'] + $row['4x4_2'];
						}
						if($countWinRace <  $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3']){
							$favRace = 3;
							$countWinRace = $row['1x1_3'] +  $row['2x2_3'] +  $row['3x3_3'] + $row['4x4_3'];
						}
						if($countWinRace <  $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4']){
							$favRace = 4;
							$countWinRace = $row['1x1_4'] +  $row['2x2_4'] +  $row['3x3_4'] + $row['4x4_4'];
						}
						if($countWinRace <  $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5']){
							$favRace = 5;
							$countWinRace = $row['1x1_5'] +  $row['2x2_5'] +  $row['3x3_5'] + $row['4x4_5'];
						}
						if($countWinRace <  $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6']){
							$favRace = 6;
							$countWinRace = $row['1x1_6'] +  $row['2x2_6'] +  $row['3x3_6'] + $row['4x4_6'];
						}
						if($countWinRace <  $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7']){
							$favRace = 7;
							$countWinRace = $row['1x1_7'] +  $row['2x2_7'] +  $row['3x3_7'] + $row['4x4_7'];
						}
						if($countWinRace <  $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8']){
							$favRace = 8;
							$countWinRace = $row['1x1_8'] +  $row['2x2_8'] +  $row['3x3_8'] + $row['4x4_8'];
						}
						if($countWinRace <  $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9']){
							$favRace = 9;
							$countWinRace = $row['1x1_9'] +  $row['2x2_9'] +  $row['3x3_9'] + $row['4x4_9'];
						}
						echo "Любимая раса: " . getRace($favRace) . "</br>";


						$favRace = 0;
						$countWinRace = 0;
						if($countWinRace <  $row['1x1_1']){
							$favRace = 1;
							$countWinRace = $row['1x1_1'] ;
						}
						if($countWinRace <  $row['1x1_2'] ){
							$favRace = 2;
							$countWinRace = $row['1x1_2'] ;
						}
						if($countWinRace <  $row['1x1_3'] ){
							$favRace = 3;
							$countWinRace = $row['1x1_3'] ;
						}
						if($countWinRace <  $row['1x1_4'] ){
							$favRace = 4;
							$countWinRace = $row['1x1_4'] ;
						}
						if($countWinRace <  $row['1x1_5']){
							$favRace = 5;
							$countWinRace = $row['1x1_5'];
						}
						if($countWinRace <  $row['1x1_6'] ){
							$favRace = 6;
							$countWinRace = $row['1x1_6'] ;
						}
						if($countWinRace <  $row['1x1_7'] ){
							$favRace = 7;
							$countWinRace = $row['1x1_7'] ;
						}
						if($countWinRace <  $row['1x1_8']){
							$favRace = 8;
							$countWinRace = $row['1x1_8'] ;
						}
						if($countWinRace <  $row['1x1_9'] ){
							$favRace = 9;
							$countWinRace = $row['1x1_9'];
						}
						echo "Любимая раса 1x1: " . getRace($favRace) . "<br/>" ;
                        echo 'апм: ' . $row['apm'] . "</h5>";

                        echo '<TABLE   class="table table-striped table-hover text-center">
                            <thead><tr>
                            <td>раса</td><td>всего игр</td><td>побед</td><td>поражений</td><td>% побед</td>
                            </tr>
                            </thead>
                            ';
                            
                            $perc = 0;
                            if($row['3x3_1'] != 0 or $row['4x4_1'] != 0 or $row['2x2_1'] != 0 or $row['1x1_1'] != 0){
                            	echo "<tr>";
                                $perc = round (100* ($row['1x1_1w'] +  $row['2x2_1w'] +  $row['3x3_1w'] + $row['4x4_1w'])/( $row['1x1_1']+ $row['2x2_1']+ $row['3x3_1']+ $row['4x4_1']) );
                            	echo "<td>космодесант</td><td>". ($row['1x1_1'] + $row['2x2_1'] + $row['3x3_1'] + $row['4x4_1'])  .  "</td><td>" . ($row['1x1_1w'] + $row['2x2_1w'] + $row['3x3_1w'] + $row['4x4_1w'] ) . "</td><td>" . ($row['1x1_1'] - $row['1x1_1w'] + $row['2x2_1'] - $row['2x2_1w'] + $row['3x3_1'] - $row['3x3_1w'] + $row['4x4_1'] - $row['4x4_1w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                                
                            }
                            
                            $perc = 0;
                            if($row['3x3_2'] != 0 or $row['4x4_2'] != 0 or $row['2x2_2'] != 0 or $row['1x1_2'] != 0){
                            	echo "<tr>";
                                $perc = round (100* ($row['1x1_2w'] +  $row['2x2_2w'] +  $row['3x3_2w'] + $row['4x4_2w'])/( $row['1x1_2']+ $row['2x2_2']+ $row['3x3_2']+ $row['4x4_2']) );
                            	echo "<td>хаос</td><td>". ($row['1x1_2'] + $row['2x2_2'] + $row['3x3_2'] + $row['4x4_2'])  .  "</td><td>" . ($row['1x1_2w'] + $row['2x2_2w'] + $row['3x3_2w'] + $row['4x4_2w'] ) . "</td><td>" . ($row['1x1_2'] - $row['1x1_2w'] + $row['2x2_2'] - $row['2x2_2w'] + $row['3x3_2'] - $row['3x3_2w'] + $row['4x4_2'] - $row['4x4_2w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['3x3_3'] != 0 or $row['4x4_3'] != 0 or $row['2x2_3'] != 0 or $row['1x1_3'] != 0){
                                echo "<tr>";
                                $perc = round (100* ($row['1x1_3w'] +  $row['2x2_3w'] +  $row['3x3_3w'] + $row['4x4_3w'])/( $row['1x1_3']+ $row['2x2_3']+ $row['3x3_3']+ $row['4x4_3']) );
                            	echo "<td>орки</td><td>". ($row['1x1_3'] + $row['2x2_3'] + $row['3x3_3'] + $row['4x4_3'])  .  "</td><td>" . ($row['1x1_3w'] + $row['2x2_3w'] + $row['3x3_3w'] + $row['4x4_3w'] ) . "</td><td>" . ($row['1x1_3'] - $row['1x1_3w'] + $row['2x2_3'] - $row['2x2_3w'] + $row['3x3_3'] - $row['3x3_3w'] + $row['4x4_3'] - $row['4x4_3w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['3x3_4'] != 0 or $row['4x4_4'] != 0 or $row['2x2_4'] != 0 or $row['1x1_4'] != 0){
                            	echo "<tr>";
                                $perc = round (100* ($row['1x1_4w'] +  $row['2x2_4w'] +  $row['3x3_4w'] + $row['4x4_4w'])/( $row['1x1_4']+ $row['2x2_4']+ $row['3x3_4']+ $row['4x4_4']) );
                            	echo "<td>эльдары</td><td>". ($row['1x1_4'] + $row['2x2_4'] + $row['3x3_4'] + $row['4x4_4'])  .  "</td><td>" . ($row['1x1_4w'] + $row['2x2_4w'] + $row['3x3_4w'] + $row['4x4_4w'] ) . "</td><td>" . ($row['1x1_4'] - $row['1x1_4w'] + $row['2x2_4'] - $row['2x2_4w'] + $row['3x3_4'] - $row['3x3_4w'] + $row['4x4_4'] - $row['4x4_4w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['3x3_5'] != 0 or $row['4x4_5'] != 0 or $row['2x2_5'] != 0 or $row['1x1_5'] != 0){
                            	echo "<tr>";
                                $perc = round (100* ($row['1x1_5w'] +  $row['2x2_5w'] +  $row['3x3_5w'] + $row['4x4_5w'])/( $row['1x1_5']+ $row['2x2_5']+ $row['3x3_5']+ $row['4x4_5']) );
                                echo "<td>имперская гвардия</td><td>". ($row['1x1_5'] + $row['2x2_5'] + $row['3x3_5'] + $row['4x4_5'])  .  "</td><td>" . ($row['1x1_5w'] + $row['2x2_5w'] + $row['3x3_5w'] + $row['4x4_5w'] ) . "</td><td>" . ($row['1x1_5'] - $row['1x1_5w'] + $row['2x2_5'] - $row['2x2_5w'] + $row['3x3_5'] - $row['3x3_5w'] + $row['4x4_5'] - $row['4x4_5w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['3x3_6'] != 0 or $row['4x4_6'] != 0 or $row['2x2_6'] != 0 or $row['1x1_6'] != 0){
                                echo "<tr>";
                                $perc = round (100* ($row['1x1_6w'] +  $row['2x2_6w'] +  $row['3x3_6w'] + $row['4x4_6w'])/( $row['1x1_6']+ $row['2x2_6']+ $row['3x3_6']+ $row['4x4_6']) );
                                echo "<td>некроны</td><td>". ($row['1x1_6'] + $row['2x2_6'] + $row['3x3_6'] + $row['4x4_6'])  .  "</td><td>" . ($row['1x1_6w'] + $row['2x2_6w'] + $row['3x3_6w'] + $row['4x4_6w'] ) . "</td><td>" . ($row['1x1_6'] - $row['1x1_6w'] + $row['2x2_6'] - $row['2x2_6w'] + $row['3x3_6'] - $row['3x3_6w'] + $row['4x4_6'] - $row['4x4_6w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['3x3_7'] != 0 or $row['4x4_7'] != 0 or $row['2x2_7'] != 0 or $row['1x1_7'] != 0){
                                echo "<tr>";
                                $perc = round (100* ($row['1x1_7w'] +  $row['2x2_7w'] +  $row['3x3_7w'] + $row['4x4_7w'])/( $row['1x1_7']+ $row['2x2_7']+ $row['3x3_7']+ $row['4x4_7']) );
                                echo "<td>империя тау</td><td>". ($row['1x1_7'] + $row['2x2_7'] + $row['3x3_7'] + $row['4x4_7'])  .  "</td><td>" . ($row['1x1_7w'] + $row['2x2_7w'] + $row['3x3_7w'] + $row['4x4_7w'] ) . "</td><td>" . ($row['1x1_7'] - $row['1x1_7w'] + $row['2x2_7'] - $row['2x2_7w'] + $row['3x3_7'] - $row['3x3_7w'] + $row['4x4_7'] - $row['4x4_7w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['3x3_8'] != 0 or $row['4x4_8'] != 0 or $row['2x2_8'] != 0 or $row['1x1_8'] != 0){
                            	echo "<tr>";
                                $perc = round (100* ($row['1x1_8w'] +  $row['2x2_8w'] +  $row['3x3_8w'] + $row['4x4_8w'])/( $row['1x1_8']+ $row['2x2_8']+ $row['3x3_8']+ $row['4x4_8']) );
                            	echo "<td>сёстры битвы</td><td>". ($row['1x1_8'] + $row['2x2_8'] + $row['3x3_8'] + $row['4x4_8'])  .  "</td><td>" . ($row['1x1_8w'] + $row['2x2_8w'] + $row['3x3_8w'] + $row['4x4_8w'] ) . "</td><td>" . ($row['1x1_8'] - $row['1x1_8w'] + $row['2x2_8'] - $row['2x2_8w'] + $row['3x3_8'] - $row['3x3_8w'] + $row['4x4_8'] - $row['4x4_8w']) . "</td> <td>" .$perc.  '%</td>';
                            	echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['3x3_9'] != 0 or $row['4x4_9'] != 0 or $row['2x2_9'] != 0 or $row['1x1_9'] != 0){
                            	echo "<tr>";
                                $perc = round (100* ($row['1x1_9w'] +  $row['2x2_9w'] +  $row['3x3_9w'] + $row['4x4_9w'])/( $row['1x1_9']+ $row['2x2_9']+ $row['3x3_9']+ $row['4x4_9']) );
                                echo "<td>тёмные эльдары</td><td>". ($row['1x1_9'] + $row['2x2_9'] + $row['3x3_9'] + $row['4x4_9'])  .  "</td><td>" . ($row['1x1_9w'] + $row['2x2_9w'] + $row['3x3_9w'] + $row['4x4_9w'] ) . "</td><td>" . ($row['1x1_9'] - $row['1x1_9w'] + $row['2x2_9'] - $row['2x2_9w'] + $row['3x3_9'] - $row['3x3_9w'] + $row['4x4_9'] - $row['4x4_9w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }

                            
                            echo "<tr>";
                            echo "<td>всего</td><td>". $all .  "</td><td>" . $win  . "</td><td>" . ($all - $win) . "</td> <td>" .$Wnr8.  '%</td>';
                            echo "</tr>";
                            echo "</TABLE>";
                            
                        

                    ?>



                </div>

                <div class="toggle-content text-center tabs" id="tab2">
                   

                    <?
                    echo '<a href="http://vk.com/share.php?url=http://dowstats.h1n.ru/player.php?name='. $name . '" target="_blank" class="btn right"> <i class="fa fa-comments"></i> Поделиться статистикой в ВК</a>';
                    echo '<h3>статистика 1x1 - ' . NickDecode::decodeNick($name) . '</h3>';
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");
                    $res = $mysqli->use_result();

                    $isPlExist = false;

                    $all = 0;
                    $win = 0;

                    while ($row = $res->fetch_assoc()) {
                        $all1x1 =  $row['1x1_1'] + $row['1x1_2'] +  $row['1x1_3'] +  $row['1x1_4'] +  $row['1x1_5'] +  $row['1x1_6'] + $row['1x1_7'] +  $row['1x1_8'] +  $row['1x1_9']; 
                        $all = $all1x1;

                        $win1x1 =  $row['1x1_1w'] + $row['1x1_2w'] +  $row['1x1_3w'] +  $row['1x1_4w'] +  $row['1x1_5w'] +  $row['1x1_6w'] + $row['1x1_7w'] +  $row['1x1_8w'] +  $row['1x1_9w']; 
                        $win = $win1x1;
                        $isPlExist = true;
                    }
                    $Wnr8 =  50;
                    if($all != 0){
                        $Wnr8 =  round (100 * $win/$all);
                    }

                    if(!$isPlExist){
                        echo "<h1>Игрок не найден в базе</h1>";
                        echo "<img src = 'images/notFound.png'>";
                    }
                    
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");        
                    $res = $mysqli->use_result();
                    while ($row = $res->fetch_assoc()) {
                        echo '<TABLE   class="table table-striped table-hover text-center">
                            <thead><tr>
                            <td>раса</td><td>всего игр</td><td>побед</td><td>поражений</td><td>% побед</td>
                            </tr>
                            </thead>
                            ';
                            $perc = 0;
                            if($row['1x1_1'] != 0){
                            	echo "<tr>";
                                $perc = round (100* $row['1x1_1w']/$row['1x1_1'] );
                                echo "<td>космодесант</td><td>". $row['1x1_1']  .  "</td><td>" . $row['1x1_1w']  . "</td><td>" . ($row['1x1_1'] - $row['1x1_1w']) . "</td> <td>" .$perc.  '%</td>';
                            	echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['1x1_2'] != 0){
                            	echo "<tr>";
                                $perc = round (100* $row['1x1_2w']/$row['1x1_2'] );
                                echo "<td>хаос</td><td>". $row['1x1_2']  .  "</td><td>" . $row['1x1_2w']  . "</td><td>" . ($row['1x1_2'] - $row['1x1_2w']) . "</td> <td>" .$perc.  '%</td>';
                            	echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['1x1_3'] != 0){
                            	echo "<tr>";
                                $perc = round (100* $row['1x1_3w']/$row['1x1_3'] );
                                echo "<td>орки</td><td>". $row['1x1_3']  .  "</td><td>" . $row['1x1_3w']  . "</td><td>" . ($row['1x1_3'] - $row['1x1_3w']) . "</td> <td>" .$perc.  '%</td>';
                            	echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['1x1_4'] != 0){
                            	echo "<tr>";
                                $perc = round (100* $row['1x1_4w']/$row['1x1_4'] );
                                echo "<td>эльдары</td><td>". $row['1x1_4']  .  "</td><td>" . $row['1x1_4w']  . "</td><td>" . ($row['1x1_4'] - $row['1x1_4w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                                
                            $perc = 0;
                            if($row['1x1_5'] != 0){
                            	echo "<tr>";
                                $perc = round (100* $row['1x1_5w']/$row['1x1_5'] );
                                echo "<td>имперская гвардия</td><td>". $row['1x1_5']  .  "</td><td>" . $row['1x1_5w']  . "</td><td>" . ($row['1x1_5'] - $row['1x1_5w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                                
                            $perc = 0;
                            if($row['1x1_6'] != 0){
                            	echo "<tr>";
                                $perc = round (100* $row['1x1_6w']/$row['1x1_6'] );
                                echo "<td>некроны</td><td>". $row['1x1_6']  .  "</td><td>" . $row['1x1_6w']  . "</td><td>" . ($row['1x1_6'] - $row['1x1_6w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                                
                            $perc = 0;
                            if($row['1x1_7'] != 0){
                            	echo "<tr>";
                                $perc = round (100* $row['1x1_7w']/$row['1x1_7'] );
                                echo "<td>империя тау</td><td>". $row['1x1_7']  .  "</td><td>" . $row['1x1_7w']  . "</td><td>" . ($row['1x1_7'] - $row['1x1_7w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                                
                            $perc = 0;
                            if($row['1x1_8'] != 0){
                            	echo "<tr>";
                                $perc = round (100* $row['1x1_8w']/$row['1x1_8'] );
                                echo "<td>сёстры битвы</td><td>". $row['1x1_8']  .  "</td><td>" . $row['1x1_8w']  . "</td><td>" . ($row['1x1_8'] - $row['1x1_8w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                                
                            $perc = 0;
                            if($row['1x1_9'] != 0){
                           		echo "<tr>";
                                $perc = round (100* $row['1x1_9w']/$row['1x1_9'] );
                                 echo "<td>тёмные эльдары</td><td>". $row['1x1_9']  .  "</td><td>" . $row['1x1_9w']  . "</td><td>" . ($row['1x1_9'] - $row['1x1_9w']) . "</td> <td>" .$perc.  '%</td>';
                            	echo "</tr>";
                            }
                           
                             echo "<tr>";
                            echo "<td>всего</td><td>". $all .  "</td><td>" . $win  . "</td><td>" . ($all - $win) . "</td> <td>" .$Wnr8.  '%</td>';
                            echo "</tr>";
                            echo "</TABLE>";
                            }
                            
                        

                    ?>
                </div>

                <div class="toggle-content text-center tabs" id="tab3">


                    <?
                    echo '<a href="http://vk.com/share.php?url=http://dowstats.h1n.ru/player.php?name='. $name . '" target="_blank" class="btn right"> <i class="fa fa-comments"></i> Поделиться статистикой в ВК</a>';
                    echo '<h3>статистика 2x2 - ' . NickDecode::decodeNick($name) . '</h3>';
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");
                    $res = $mysqli->use_result();

                    $all = 0;
                    $win = 0;
                    $isPlExist = false;
                    while ($row = $res->fetch_assoc()) {
                        $all2x2 =  $row['2x2_1'] + $row['2x2_2'] +  $row['2x2_3'] +  $row['2x2_4'] +  $row['2x2_5'] +  $row['2x2_6'] + $row['2x2_7'] +  $row['2x2_8'] +  $row['2x2_9']; 
                        $all = $all + $all2x2;

                        $win2x2 =  $row['2x2_1w'] + $row['2x2_2w'] +  $row['2x2_3w'] +  $row['2x2_4w'] +  $row['2x2_5w'] +  $row['2x2_6w'] + $row['2x2_7w'] +  $row['2x2_8w'] +  $row['2x2_9w']; 
                        $win = $win + $win2x2;
                        $isPlExist = true;
                    }
                    $Wnr8 =  50;
                    if($all != 0){
                        $Wnr8 =  round (100 * $win/$all);
                    }

                    if(!$isPlExist){
                        echo "<h1>Игрок не найден в базе</h1>";
                        echo "<img src = 'images/notFound.png'>";
                    }
                    
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");        
                    $res = $mysqli->use_result();
                    while ($row = $res->fetch_assoc()) {
                        echo '<TABLE   class="table table-striped table-hover text-center">
                            <thead><tr>
                            <td>раса</td><td>всего игр</td><td>побед</td><td>поражений</td><td>% побед</td>
                            </tr>
                            </thead>
                            ';
                            
                            $perc = 0;
                            if($row['2x2_1'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_1w']/$row['2x2_1'] );
                                echo "<td>космодесант</td><td>". $row['2x2_1']  .  "</td><td>" . $row['2x2_1w']  . "</td><td>" . ($row['2x2_1'] - $row['2x2_1w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                                
                            }
                            
                            $perc = 0;
                            if($row['2x2_2'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_2w']/$row['2x2_2'] );
                                echo "<td>хаос</td><td>". $row['2x2_2']  .  "</td><td>" . $row['2x2_2w']  . "</td><td>" . ($row['2x2_2'] - $row['2x2_2w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['2x2_3'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_3w']/$row['2x2_3'] );
                                echo "<td>орки</td><td>". $row['2x2_3']  .  "</td><td>" . $row['2x2_3w']  . "</td><td>" . ($row['2x2_3'] - $row['2x2_3w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['2x2_4'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_4w']/$row['2x2_4'] );
                                echo "<td>эльдары</td><td>". $row['2x2_4']  .  "</td><td>" . $row['2x2_4w']  . "</td><td>" . ($row['2x2_4'] - $row['2x2_4w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            $perc = 0;
                            if($row['2x2_5'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_5w']/$row['2x2_5'] );
                                echo "<td>имперская гвардия</td><td>". $row['2x2_5']  .  "</td><td>" . $row['2x2_5w']  . "</td><td>" . ($row['2x2_5'] - $row['2x2_5w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                           
                            
                            $perc = 0;
                            if($row['2x2_6'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_6w']/$row['2x2_6'] );
                                echo "<td>некроны</td><td>". $row['2x2_6']  .  "</td><td>" . $row['2x2_6w']  . "</td><td>" . ($row['2x2_6'] - $row['2x2_6w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['2x2_7'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_7w']/$row['2x2_7'] );
                                echo "<td>империя тау</td><td>". $row['2x2_7']  .  "</td><td>" . $row['2x2_7w']  . "</td><td>" . ($row['2x2_7'] - $row['2x2_7w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['2x2_8'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_8w']/$row['2x2_8'] );
                                echo "<td>сёстры битвы</td><td>". $row['2x2_8']  .  "</td><td>" . $row['2x2_8w']  . "</td><td>" . ($row['2x2_8'] - $row['2x2_8w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['2x2_9'] != 0){
                                echo "<tr>";
                                $perc = round (100* $row['2x2_9w']/$row['2x2_9'] );
                                echo "<td>тёмные эльдары</td><td>". $row['2x2_9']  .  "</td><td>" . $row['2x2_9w']  . "</td><td>" . ($row['2x2_9'] - $row['2x2_9w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                             echo "<tr>";
                            echo "<td>всего</td><td>". $all .  "</td><td>" . $win  . "</td><td>" . ($all - $win) . "</td> <td>" .$Wnr8.  '%</td>';
                            echo "</tr>";
                            echo "</TABLE>";
                            }
                            
                        

                    ?>
                </div>

                <div class="toggle-content text-center tabs" id="tab4">

                    <?
                    echo '<a href="http://vk.com/share.php?url=http://dowstats.h1n.ru/player.php?name='. $name . '" target="_blank" class="btn right"> <i class="fa fa-comments"></i> Поделиться статистикой в ВК</a>';
                    echo '<h3>статистика 3x3 & 4x4 - ' . NickDecode::decodeNick($name) . '</h3>';
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");
                    $res = $mysqli->use_result();

                    $all = 0;
                    $win = 0;
                    $isPlExist = false;
                    while ($row = $res->fetch_assoc()) {
                        $all3x3 =  $row['3x3_1'] +  $row['3x3_2'] +  $row['3x3_3'] +  $row['3x3_4'] +  $row['3x3_5'] +  $row['3x3_6'] + $row['3x3_7'] +  $row['3x3_8'] +  $row['3x3_9']; 
                        $all4x4 =  $row['4x4_1'] +  $row['4x4_2'] + $row['4x4_3']  +  $row['4x4_4'] +  $row['4x4_5'] +  $row['4x4_6'] + $row['4x4_7'] +  $row['4x4_8'] +  $row['4x4_9']; 
                        $all = $all3x3 + $all4x4;

                        $win3x3 =  $row['3x3_1w'] + $row['3x3_2w'] +  $row['3x3_3w'] +  $row['3x3_4w'] +  $row['3x3_5w'] +  $row['3x3_6w'] + $row['3x3_7w'] +  $row['3x3_8w'] +  $row['3x3_9w']; 
                        $win4x4 =  $row['4x4_1w'] + $row['4x4_2w'] +  $row['4x4_3w'] +  $row['4x4_4w'] +  $row['4x4_5w'] +  $row['4x4_6w'] + $row['4x4_7w'] +  $row['4x4_8w'] +  $row['4x4_9w']; 
                        $win = $win3x3 + $win4x4;
                        $isPlExist = true;
                    }
                    $Wnr8 =  50;
                    if($all != 0){
                        $Wnr8 =  round (100 * $win/$all);
                    }

                    if(!$isPlExist){
                        echo "<h1>Игрок не найден в базе</h1>";
                        echo "<img src = 'images/notFound.png'>";
                    }
                    
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");        
                    $res = $mysqli->use_result();
                    while ($row = $res->fetch_assoc()) {
                        echo '<TABLE   class="table table-striped table-hover text-center">
                            <thead><tr>
                            <td>раса</td><td>всего игр</td><td>побед</td><td>поражений</td><td>% побед</td>
                            </tr>
                            </thead>
                            ';
                            
                            $perc = 0;
                            if($row['3x3_1'] != 0 or $row['4x4_1'] != 0){
                                echo "<tr>";
                                $perc = round (100* ($row['3x3_1w'] + $row['4x4_1w'])/( $row['3x3_1']+ $row['4x4_1']) );
                                echo "<td>космодесант</td><td>". ($row['3x3_1'] + $row['4x4_1'])  .  "</td><td>" . ($row['3x3_1w'] + $row['4x4_1w'] ) . "</td><td>" . ($row['3x3_1'] - $row['3x3_1w'] + $row['4x4_1'] - $row['4x4_1w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['3x3_2'] != 0 or $row['4x4_2'] != 0 ){
                                echo "<tr>";
                                $perc = round (100*( $row['3x3_2w'] + $row['4x4_2w'])/($row['3x3_2']+$row['4x4_2']) );
                                echo "<td>хаос</td><td>". ($row['3x3_2'] + $row['4x4_2'])  .  "</td><td>" . ($row['3x3_2w'] + $row['4x4_2w'] ) . "</td><td>" . ($row['3x3_2'] - $row['3x3_2w'] + $row['4x4_2'] - $row['4x4_2w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['3x3_3'] != 0 or $row['4x4_3'] != 0){
                                echo "<tr>";
                                $perc = round (100*( $row['3x3_3w'] + $row['4x4_3w'])/($row['3x3_3']+$row['4x4_3']) );
                                echo "<td>орки</td><td>". ($row['3x3_3'] + $row['4x4_3'])  .  "</td><td>" . ($row['3x3_3w'] + $row['4x4_3w'] ) . "</td><td>" . ($row['3x3_3'] - $row['3x3_3w'] + $row['4x4_3'] - $row['4x4_3w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['3x3_4'] != 0 or $row['4x4_4'] != 0){
                                echo "<tr>";
                                $perc = round (100*( $row['3x3_4w'] + $row['4x4_4w'])/($row['3x3_4']+$row['4x4_4']) );
                                echo "<td>эльдары</td><td>". ($row['3x3_4'] + $row['4x4_4'])  .  "</td><td>" . ($row['3x3_4w'] + $row['4x4_4w'] ) . "</td><td>" . ($row['3x3_4'] - $row['3x3_4w'] + $row['4x4_4'] - $row['4x4_4w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['3x3_5'] != 0 or $row['4x4_5'] != 0){
                                echo "<tr>";
                                $perc = round (100*( $row['3x3_5w'] + $row['4x4_5w'])/($row['3x3_5']+$row['4x4_5']) );
                                echo "<td>имперская гвардия</td><td>". ($row['3x3_5'] + $row['4x4_5'])  .  "</td><td>" . ($row['3x3_5w'] + $row['4x4_5w'] ) . "</td><td>" . ($row['3x3_5'] - $row['3x3_5w'] + $row['4x4_5'] - $row['4x4_5w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['3x3_6'] != 0 or $row['4x4_6'] != 0){
                                echo "<tr>";
                                $perc = round (100*( $row['3x3_6w'] + $row['4x4_6w'])/($row['3x3_6']+$row['4x4_6']) );
                                echo "<td>некроны</td><td>". ($row['3x3_6'] + $row['4x4_6'])  .  "</td><td>" . ($row['3x3_6w'] + $row['4x4_6w'] ) . "</td><td>" . ($row['3x3_6'] - $row['3x3_6w'] + $row['4x4_6'] - $row['4x4_6w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['3x3_7'] != 0 or $row['4x4_7'] != 0){
                                echo "<tr>";
                                $perc = round (100*( $row['3x3_7w'] + $row['4x4_7w'])/($row['3x3_7']+$row['4x4_7']) );
                                echo "<td>империя тау</td><td>". ($row['3x3_7'] + $row['4x4_7'])  .  "</td><td>" . ($row['3x3_7w'] + $row['4x4_7w'] ) . "</td><td>" . ($row['3x3_7'] - $row['3x3_7w'] + $row['4x4_7'] - $row['4x4_7w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['3x3_8'] != 0 or $row['4x4_8'] != 0){
                                echo "<tr>";
                                $perc = round (100*( $row['3x3_8w'] + $row['4x4_8w'])/($row['3x3_8']+$row['4x4_8']) );
                                echo "<td>сёстры битвы</td><td>". ($row['3x3_8'] + $row['4x4_8'])  .  "</td><td>" . ($row['3x3_8w'] + $row['4x4_8w'] ) . "</td><td>" . ($row['3x3_8'] - $row['3x3_8w'] + $row['4x4_8'] - $row['4x4_8w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                            
                            $perc = 0;
                            if($row['3x3_9'] != 0 or $row['4x4_9'] != 0){
                                echo "<tr>";
                                $perc = round (100*( $row['3x3_9w'] + $row['4x4_9w'])/($row['3x3_9']+$row['4x4_9']) );
                                echo "<td>тёмные эльдары</td><td>". ($row['3x3_9'] + $row['4x4_9'])  .  "</td><td>" . ($row['3x3_9w'] + $row['4x4_9w'] ) . "</td><td>" . ($row['3x3_9'] - $row['3x3_9w'] + $row['4x4_9'] - $row['4x4_9w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                            
                             echo "<tr>";
                            echo "<td>всего</td><td>". $all .  "</td><td>" . $win  . "</td><td>" . ($all - $win) . "</td> <td>" .$Wnr8.  '%</td>';
                            echo "</tr>";
                            echo "</TABLE>";
                            }
                            
                        

                    ?>
                </div>

                <!-- Суммирование  -->

                <div class="toggle-content text-center tabs container" id = "tab5">
                    
                    <?

                    echo '<h3>Последние игры - ' . NickDecode::decodeNick($name) . '</h3>';
                    include 'view/allGamesPlayer.php';   

                    ?>
                </div>
                <div id="scrollup"><img alt="Прокрутить вверх" src="images/arrows7.png"><br/>Вверх</div>
    		</div> <!-- /.col-md-12 col-sm-12 -->
    	</div> 
    </div> 

       

    </body>

</html>



<!-- перенос, то, что ниже - нужно стереть -->





