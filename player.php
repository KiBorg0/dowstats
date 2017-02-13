<?php
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];


// define('BASE_PATH', realpath(dirname(__FILE__)));
// define('LANGUAGES_PATH', BASE_PATH . '/locale');

// $locale = 'en_US';
// $lang = isset($_GET['lang'])?$_GET['lang']:'en';

// switch ($lang) {
//     case 'ru':
//         $locale = 'ru_RU';
//         break;
//     case 'en':
//         $locale = 'en_US';
//         break;
//     case 'ko':
//         $locale = 'ko_KR';
//         break;
//     default:
//         $locale = 'en_US';
//         break;
// }

// putenv('LC_ALL=' . $locale);
// setlocale(LC_ALL, $locale, $locale . '.utf8');
// date_default_timezone_set('Europe/Moscow');
// bind_textdomain_codeset($locale, 'UTF-8');
// bindtextdomain($locale, LANGUAGES_PATH);
// textdomain($locale);


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
        <link rel="stylesheet" href="css/player.css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css"/>

        <script type="text/javascript">
            var userName = '<?php echo $name;?>';
        </script>

        <script type="text/javascript" src="js/player.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script type="text/javascript" src="js/battlesPlayer.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#navbar_list').append("<li id = \"player_profile\"><a  href=\"player.php?name=<?php echo $name;?>\"><?php echo NickDecode::decodeNick($name); ?></a></li>");
                $('#player_profile').addClass('active');
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
                        <button class="btn btn-primary"  onclick="show_tab('tab0');"  role="group"><?php echo _('General stats')?></button>
                        <button class="btn btn-primary"  onclick="show_tab('tab1');"  role="group">1x1</button>
                        <button class="btn btn-primary" onclick="show_tab('tab2');" role="group">2x2</button>
                        <button class="btn btn-primary" onclick="show_tab('tab3');" role="group">3x3</button>
                        <button class="btn btn-primary" onclick="show_tab('tab4');" role="group">4x4</button>
                        <button class="btn btn-primary"  onclick="show_tab('tab5');"  role="group"><?php echo _('Last games')?></button>
                    </div>
                </div>
            </div>

            <?php
            //общие расчеты
            $timehelpint = $row['time'] / 60;
            $timehours = intval($timehelpint / 60);
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
            ?>

            <div class="col-md-12 col-sm-12">
                <div class="toggle-content text-center tabs" id="tab0" >

                    <?php
                    echo '<a href="http://vk.com/share.php?url=http://dowstats.h1n.ru/player.php?name='. $name . '" target="_blank" class="btn right"> <i class="fa fa-comments"></i>'._('Share stats in VK').'</a>';
                    $cTimeMAX = date('Y-m-d H:i:s', time());
                    
                    echo '<h3>'._('total stats').' - '. '<a href="https://steamcommunity.com/profiles/'. $steamid . '">' . NickDecode::decodeNick($name) .'</a>'. '</h3>';

                    echo '<h5>SOLO MMR: ' . $row['mmr'] . '<br>';

                    echo _('game time').": ". $timehours . " "._("h.")."   " . $timehelpint % 60 .  " "._("m.")."   " . $row['time'] % 60 . ' '._('s.').'<br>';
                    //---------любимая раса -----------------

                    echo _('favorite race').': '. RaceSwitcher::getRace($favRaceAll) . '</br>';
                    echo _('favorite race 1x1').': '. RaceSwitcher::getRace($favRace) . '<br/>' ;
                    echo _('apm').': '. $row['apm'] . '</h5>';

                    echo '<TABLE   class="table table-striped table-hover text-center">
                        <thead><tr>
                        <td>'._('race').'</td><td>'._('count of games').'</td><td>'._('wins').'</td><td>'._('losses').'</td><td>'._('wins ratio').'</td>
                        </tr>
                        </thead>';
                    $all_sum = 0; 
                    $win_sum = 0;    
                    for($i=1; $i<=9; $i++)
                    {
                        $perc = 0;
                        $all_sum_r = 0; 
                        $win_sum_r = 0;
                        $lose_sum_r = 0;
                        for($j=1; $j<=4; $j++)
                            if($row[$j.'x'.$j.'_'.$i]!=0)
                            {
                                $all_sum_r += $row[$j.'x'.$j.'_'.$i]; 
                                $win_sum_r += $row[$j.'x'.$j.'_'.$i.'w'];
                            }
                        $all_sum += $all_sum_r;
                        $win_sum += $win_sum_r;
                        $lose_sum_r = $all_sum_r-$win_sum_r;
                        $perc = ($all_sum_r == 0) ? 0 : round (100* $win_sum_r/$all_sum_r);
                        if($all_sum_r!=0)
                            echo "<tr><td>".RaceSwitcher::getRace($i)."</td>
                                <td>".$all_sum_r."</td>
                                <td>".$win_sum_r."</td>
                                <td>".$lose_sum_r."</td>
                                <td>".$perc.'%</td></tr>';
                    }
                    echo "<tr>";
                    if($all_sum != 0)
                        $Wnr8 =  round (100 * $win_sum/$all_sum);
                    echo "<td>всего</td>
                        <td>".$all_sum."</td>
                        <td>".$win_sum."</td>
                        <td>".($all_sum-$win_sum)."</td>
                        <td>".$Wnr8.'%</td>
                        </tr>
                        </TABLE>';
                    ?>
                </div>

                <?php
                for($type = 0;$type <= 4;$type++){
                    echo '<div class="toggle-content text-center tabs" id="tab'.$type.'">';
                    echo '<a href="http://vk.com/share.php?url=http://dowstats.h1n.ru/player.php?name='. $name . '" target="_blank" class="btn right"> <i class="fa fa-comments"></i>'._('Share stats in VK').'</a>';

                    echo '<h3>'._('stats').' '.$type.'x'.$type.' - ' . '<a href="https://steamcommunity.com/profiles/'. $steamid . '">' . NickDecode::decodeNick($name) .'</a>' . '</h3>';
                    echo '<h5>SOLO MMR: ' . $row['mmr'] . '<br>';
                    echo _('game time').": ". $timehours . " "._("h.")."   " . $timehelpint % 60 .  " "._("m.")."   " . $row['time'] % 60 . ' '._('s.').'<br>';
                    echo _("favorite race").": ". RaceSwitcher::getRace($favRaceAll) . "</br>";
                    echo _("favorite race 1x1").": ". RaceSwitcher::getRace($favRace) . "<br/>" ;
                    echo _('apm').": ". $row['apm'] . "</h5>";

                    $all = 0;
                    $win = 0;

                    echo '<TABLE   class="table table-striped table-hover text-center">
                        <thead><tr>
                        <td>'._('race').'</td>
                        <td>'._('count of games').'</td>
                        <td>'._('wins').'</td>
                        <td>'._('losses').'</td>
                        <td>'._('wins ratio').'</td>
                        </tr>
                        </thead>';
                    for($i=1; $i<=9; $i++)
                        if($row[$type.'x'.$type.'_'.$i] != 0){
                            $all += $row[$type.'x'.$type.'_'.$i];
                            $win += $row[$type.'x'.$type.'_'.$i.'w'];
                            echo "<tr>";
                            $perc = round (100* $row[$type.'x'.$type.'_'.$i.'w']/$row[$type.'x'.$type.'_'.$i] );
                            echo "<td>".RaceSwitcher::getRace($i)."</td>
                            <td>".$row[$type.'x'.$type.'_'.$i]."</td>
                            <td>".$row[$type.'x'.$type.'_'.$i.'w']."</td>
                            <td>".($row[$type.'x'.$type.'_'.$i] - $row[$type.'x'.$type.'_'.$i.'w'])."</td>
                            <td>".$perc.'%</td>';
                            echo "</tr>";
                        }

                    $Wnr8 = ($all != 0)?round (100 * $win/$all):0;
                    echo "<tr>
                        <td>"._('Total')."</td>
                        <td>".$all."</td>
                        <td>".$win."</td>
                        <td>".($all-$win)."</td>
                        <td>".$Wnr8.'%</td>
                        </tr>
                        </TABLE>
                        </div>';
                }
                ?>

                <!-- Суммирование  -->
                <div class="toggle-content text-center tabs container" id = "tab5">
                    <br/>
                    <div style = "clear:both"/>
                        <?php
                            echo '<h3>'._('Recent games').' - ' . NickDecode::decodeNick($name) . '</h3>';
                        ?>
                    </div>
                    <div class = "search_div">
                        <div class="form-group col-md-3" >
                            <label class="sr-only" for="player_name_input"><?php echo _('Player opponent/ally')?></label>
                            <input id="player_name_input" onkeydown=" player_name_input_keypress_battles(event)"  class="form-control autocomplete" placeholder=<?php echo "'"._("Enter opponent/ally")."'"?> >
                        </div>
                        <span id = "search_advice_wrapper"></span>

                        <div class="form-group col-md-3">
                            <label class="sr-only" for="race_option"><?php echo _('Player race')?></label>
                            <select class="form-control" id="race_option">
                            <option><?php echo _('Any race')?></option>
                            <?php
                                for($i = 1;$i <= 9;$i++){
                                    echo "<option>" . RaceSwitcher::getRace($i) . "</option>";
                                }
                            ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <!-- <label for="sel1">Тип игры</label> -->
                            <div class="checkbox">
                              <label><input id = "1x1_checkbox" type="checkbox" checked value="">1x1</label>
                              <label><input id = "2x2_checkbox" type="checkbox" checked value="">2x2</label>
<!--                             </div>
                            <div class="checkbox"> -->
                              <label><input id = "3x3_checkbox" type="checkbox" checked value="">3x3</label>
                              <label><input id = "4x4_checkbox" type="checkbox" checked value="">4x4</label>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <a class="btn btn-default" onclick = "search_player_battles()"><?php echo _('Find games')?> <span class="glyphicon glyphicon-search"></span></a>
                        </div>
                    </div>

                    
                    <span id = "search_advice_wrapper"></span>
                    <br/>
                    <div style = "clear:both"/>
                        <div id = "fight_result">
                        </div>
                    </div>
                    <div id="scrollup"><img alt=<?php echo "'"._('Scroll up')."'"?> src="images/arrows7.png"><br/><?php echo _('Up')?></div>

                </div> <!-- /.col-md-12 col-sm-12 -->
            </div> 
        </div> 

       

    </body>

</html>



<!-- перенос, то, что ниже - нужно стереть -->





