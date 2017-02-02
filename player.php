<?
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];
setlocale(LC_TIME, "ru_RU.utf8");
date_default_timezone_set('Europe/Moscow');
require_once("lib/steam.php");
require_once("lib/NickDecode.php");
require_once("lib/RaceSwitcher.php");
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

<!--         <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/player.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script> -->

        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
        <link rel="stylesheet" href="css/main.css"/>
        <link rel="stylesheet" href="css/battles.css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css"/>

        <script type="text/javascript">
            var userName = '<?php echo $name;?>';
        </script>

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/player.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script type="text/javascript" src="js/battlesPlayer.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
            $('#battles').addClass('active');
        });
        </script>

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
                        $favRaceAll = 0;
						$countWinRace = 0;
                        $countWinRaceAll = 0;
                        for($i=1; $i<=9; $i++)
                        {
                            if($countWinRace<$row['1x1_'.$i])
                            {
                                $favRace = $i;
                                $countWinRace = $row['1x1_'.$i];
                            }
                            $sum = $row['1x1_'.$i]+$row['2x2_'.$i]+$row['3x3_'.$i]+$row['4x4_'.$i];
                            if($countWinRaceAll<$sum)
                            {
                                $favRaceAll = $i;
                                $countWinRaceAll = $sum;
                            }
                        }
                        echo "Любимая раса: " . RaceSwitcher::getRace($favRaceAll) . "</br>";
						echo "Любимая раса 1x1: " . RaceSwitcher::getRace($favRace) . "<br/>" ;
                        echo 'апм: ' . $row['apm'] . "</h5>";

                        echo '<TABLE   class="table table-striped table-hover text-center">
                            <thead><tr>
                            <td>раса</td><td>всего игр</td><td>побед</td><td>поражений</td><td>% побед</td>
                            </tr>
                            </thead>
                            ';
                            
                        for($i=1; $i<=9; $i++)
                        {
                            $perc = 0;
                            $all_sum = 0; 
                            $win_sum = 0;
                            $lose_sum = 0;
                            for($j=1; $j<=4; $j++)
                                if($row[$j.'x'.$j.'_'.$i]!=0)
                                {
                                    $all_sum += $row[$j.'x'.$j.'_'.$i]; 
                                    $win_sum += $row[$j.'x'.$j.'_'.$i.'w'];
                                }
                            $lose_sum = $all_sum-$win_sum;
                            $perc = round (100* $win_sum/$all_sum);    
                            if($all_sum!=0)
                                echo "<tr><td>".RaceSwitcher::getRace($i)."</td><td>".$all_sum."</td><td>".$win_sum."</td><td>".$lose_sum."</td> <td>".$perc.'%</td></tr>';
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
                    // $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");
                    // $res = $mysqli->use_result();
                    // $isPlExist = false;
                    // while ($row = $res->fetch_assoc()) {
                    //     $isPlExist = true;
                    // }
                    // if(!$isPlExist){
                    //     echo "<h1>Игрок не найден в базе</h1>";
                    //     echo "<img src = 'images/notFound.png'>";
                    // }
                    $all = 0;
                    $win = 0;
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");        
                    $res = $mysqli->use_result();
                    while ($row = $res->fetch_assoc()) {
                        echo '<TABLE   class="table table-striped table-hover text-center">
                            <thead><tr>
                            <td>раса</td><td>всего игр</td><td>побед</td><td>поражений</td><td>% побед</td>
                            </tr>
                            </thead>
                            ';
                            for($i=1; $i<=9; $i++)
                            {
                                $perc = 0;
                                if($row['1x1_'.$i] != 0){
                                    $all += $row['1x1_'.$i];
                                    $win += $row['1x1_'.$i.'w'];
                                    echo "<tr>";
                                    $perc = round (100* $row['1x1_'.$i.'w']/$row['1x1_'.$i] );
                                    echo "<td>".RaceSwitcher::getRace($i)."</td><td>". $row['1x1_'.$i]  .  "</td><td>" . $row['1x1_'.$i.'w']  . "</td><td>" . ($row['1x1_'.$i] - $row['1x1_'.$i.'w']) . "</td> <td>" .$perc.  '%</td>';
                                    echo "</tr>";
                                }
                            }
                            $Wnr8 =  50;
                            if($all != 0)
                                $Wnr8 =  round (100 * $win/$all);
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
                    $all = 0;
                    $win = 0;
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");        
                    $res = $mysqli->use_result();
                    while ($row = $res->fetch_assoc()) {

                        echo '<TABLE   class="table table-striped table-hover text-center">
                            <thead><tr>
                            <td>раса</td><td>всего игр</td><td>побед</td><td>поражений</td><td>% побед</td>
                            </tr>
                            </thead>
                            ';
                        for($i=1; $i<=9; $i++)
                        {
                            $perc = 0;
                            if($row['2x2_'.$i] != 0){
                                $all += $row['2x2_'.$i];
                                $win += $row['2x2_'.$i.'w'];
                                echo "<tr>";
                                $perc = round (100* $row['2x2_'.$i.'w']/$row['2x2_'.$i] );
                                echo "<td>".RaceSwitcher::getRace($i)."</td><td>". $row['2x2_'.$i]  .  "</td><td>" . $row['2x2_'.$i.'w']  . "</td><td>" . ($row['2x2_'.$i] - $row['2x2_'.$i.'w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                        }
                        $Wnr8 =  50;
                        if($all != 0)
                            $Wnr8 =  round (100 * $win/$all);
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
                    $all = 0;
                    $win = 0;
                    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");        
                    $res = $mysqli->use_result();
                    while ($row = $res->fetch_assoc()) {
                        echo '<TABLE   class="table table-striped table-hover text-center">
                            <thead><tr>
                            <td>раса</td><td>всего игр</td><td>побед</td><td>поражений</td><td>% побед</td>
                            </tr>
                            </thead>
                            ';
                        for($i=1; $i<=9; $i++)
                        {
                            $perc = 0;
                            if($row['3x3_'.$i] != 0 or $row['4x4_'.$i] != 0){
                                $all += $row['3x3_'.$i]+$row['4x4_'.$i];
                                $win += $row['3x3_'.$i.'w']+$row['4x4_'.$i.'w'];
                                echo "<tr>";
                                $perc = round (100* ($row['3x3_'.$i.'w'] + $row['4x4_'.$i.'w'])/( $row['3x3_'.$i]+ $row['4x4_'.$i]) );
                                echo "<td>".RaceSwitcher::getRace($i)."</td><td>". ($row['3x3_'.$i] + $row['4x4_'.$i])  .  "</td><td>" . ($row['3x3_'.$i.'w'] + $row['4x4_'.$i.'w'] ) . "</td><td>" . ($row['3x3_'.$i] - $row['3x3_'.$i.'w'] + $row['4x4_'.$i] - $row['4x4_'.$i.'w']) . "</td> <td>" .$perc.  '%</td>';
                                echo "</tr>";
                            }
                        }
                        $Wnr8 =  50;
                        if($all != 0)
                            $Wnr8 =  round (100 * $win/$all);
                        echo "<tr>";
                        echo "<td>всего</td><td>". $all .  "</td><td>" . $win  . "</td><td>" . ($all - $win) . "</td> <td>" .$Wnr8.  '%</td>';
                        echo "</tr>";
                        echo "</TABLE>";
                    }
                    ?>
                </div>

                <!-- Суммирование  -->
                <div class="toggle-content text-center tabs container" id = "tab5">
                    <br/>
                    <div class="navbar-form navbar-left" style="width:400px;">
                        <div class="form-group ">
                            <input id="player_name_input" onkeydown=" player_name_input_keypress_battles(event)" style="width:300px;" class="form-control autocomplete" placeholder="Поиск по имени игрока/клана" >
                        </div>
                        <a class="btn btn-default" onclick = "search_player_battles()"><span class="glyphicon glyphicon-search"></span></a>
                    </div>
                    <span id = "search_advice_wrapper"></span>

                    <div style = "clear:both"/>
                    
                    <?
                        echo '<h3>Последние игры - ' . NickDecode::decodeNick($name) . '</h3>';
                    ?>
                    <div id = "fight_result">
                    </div>
                </div>
                <div id="scrollup"><img alt="Прокрутить вверх" src="images/arrows7.png"><br/>Вверх</div>
    		</div> <!-- /.col-md-12 col-sm-12 -->
    	</div> 
    </div> 

       

    </body>

</html>



<!-- перенос, то, что ниже - нужно стереть -->





