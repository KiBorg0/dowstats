<?php
header('Content-Type: text/html; charset=utf-8');
$host = $_SERVER['HTTP_HOST'];


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


$lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
putenv('LC_ALL=' . $lang);
setlocale(LC_ALL, $lang, $lang . '.utf8');
bind_textdomain_codeset($lang, 'UTF-8');
bindtextdomain($lang, 'locale');
textdomain($lang);

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
if ($mysqli->connect_error) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if(isset($_GET["sid"]))
{
    $sid = $_GET["sid"];
    $mysqli->real_query("SELECT * FROM players WHERE sid = '$sid'");
    $res = $mysqli->store_result();
    $row = $res->fetch_assoc();
    $name = $row["name"];
}
else if(isset($_GET["name"]))
{
    $name = $_GET["name"];
    $mysqli->real_query("SELECT * FROM players WHERE name = '$name'");
    $res = $mysqli->store_result();
    $row = $res->fetch_assoc();
    $sid = $row["sid"];
}




?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

    <head>

        <title><?php echo _('Soulstorm Ladder')?></title>

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
        <script type="text/javascript">
            var lang = '<?php echo $lang;?>';
        </script>
        <!-- <link rel="stylesheet" href="css/bootstrap.min.css"/> -->
        <!-- <link rel="stylesheet" href="css/bootstrap-theme.min.css"/> -->
        <link rel="stylesheet" href="css/main.css"/>
        <link rel="stylesheet" href="css/player.css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css"/>

        <script type="text/javascript">
            var userName = '<?php echo $name;?>';
            var userSID = '<?php echo $sid;?>';
        </script>

        <script type="text/javascript" src="js/player.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script type="text/javascript" src="js/battlesPlayer.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#navbar_list').append("<li id = \"player_profile\"><a  href=\"player.php?sid=<?php echo $sid.'&lang='.$lang;?>\"><?php echo NickDecode::decodeNick($name); ?></a></li>");
                $('#player_profile').addClass('active');
        });
        </script>

    </head>

    <body>
    <?php include "header.php"; ?>
    <div class="container">
        <div class="row">
<!--             <div class="col-md-12">
            <div class="col-md-12 col-sm-12"> -->
            <div style = "clear:both"/>
            <div class="container-fluid" style="border:1px solid #cecece; border-radius: 4px;">
                <div class="row" style="display: flex; align-items: center;">
                <div class="col-md-3" >
                    <!-- <div class = " map-container"> -->
                    <center>
                        <h1><?php echo NickDecode::decodeNick($name); ?></h1></center>
                        <!-- <img class = "map-img" src=<?php echo 'images/maps/'.$row['map'].'.jpg'?>> -->
                        <?php
                        $big_avatar_url = Steam::get_big_avatar_url_by_id($sid);
                        echo '<a href="https://steamcommunity.com/profiles/'. $sid . '">'."<img class = 'avatar_big img-rounded center-block' src='" . $big_avatar_url . "'>".'</a>';    
                        ?>
                    <!-- </div> -->
                    <br/>
                </div>
                <div class="col-md-9">
                    <?php
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
                    echo '<h5>SID: ' . $row['sid'] . '<br>';
                    echo 'SOLO MMR: ' . $row['mmr'] . '<br>';
                    echo _('Favorite Race').': '. RaceSwitcher::getRace($favRaceAll) . '</br>';
                    if($favRace) echo _('Favorite Race 1x1').': '. RaceSwitcher::getRace($favRace) . '<br/>' ;
                    echo _('APM').': '. $row['apm'] . '</h5>';
                    echo '<a href="http://vk.com/share.php?url=http://dowstats.h1n.ru/player.php?sid='. $sid . '" target="_blank">'._('Share stats in VK').'</a>';
                    ?>
                </div>    
                </div>
            </div>
            </div>
<!--             </div>
            </div> -->
            <br/>

            <div class="toggle-content text-center">
                <div   role="group" >
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary"  onclick="show_tab('tab0');"  role="group"><?php echo _('General Stats')?></button>
                        <button class="btn btn-primary"  onclick="show_tab('tab1');"  role="group">1x1</button>
                        <button class="btn btn-primary" onclick="show_tab('tab2');" role="group">2x2</button>
                        <button class="btn btn-primary" onclick="show_tab('tab3');" role="group">3x3</button>
                        <button class="btn btn-primary" onclick="show_tab('tab4');" role="group">4x4</button>
                        <button class="btn btn-primary"  onclick="show_tab('tab5');"  role="group"><?php echo _('Last Games')?></button>
                    </div>
                </div>
            </div>
            <br/>
            <div class="col-md-12 col-sm-12">
                <div class="toggle-content text-center tabs" id="tab0" >

                    <?php

                    echo '<TABLE   class="table table-striped table-hover text-center">
                        <thead><tr>
                        <td>'._('Race')           .'</td>
                        <td>'._('Number of Games').'</td>
                        <td>'._('Victories')      .'</td>
                        <td>'._('Losses')         .'</td>
                        <td>'._('Wins Rate')      .'</td>
                        </tr></thead>';
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
                    $all = 0;
                    $win = 0;

                    echo '<TABLE   class="table table-striped table-hover text-center">
                        <thead><tr>
                        <td>'._('Race').'</td>
                        <td>'._('Number of Games').'</td>
                        <td>'._('Victories').'</td>
                        <td>'._('Losses').'</td>
                        <td>'._('Wins Rate').'</td>
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
                    <div class = "search_div">
                        <div class="form-group col-md-3" >
                            <label class="sr-only" for="player_name_input"><?php echo _('Player opponent/ally')?></label>
                            <input id="player_name_input" onkeydown=" player_name_input_keypress_battles(event)"  class="form-control autocomplete" placeholder=<?php echo "'"._("Enter opponent/ally")."'"?> >
                        </div>
                        <span id = "search_advice_wrapper"></span>

                        <div class="form-group col-md-3">
                            <label class="sr-only" for="race_option"><?php echo _('Player Race')?></label>
                            <select class="form-control" id="race_option">
                            <option><?php echo _('Any Race')?></option>
                            <?php
                                for($i = 1;$i <= 9;$i++){
                                    echo "<option>" . RaceSwitcher::getRace($i) . "</option>";
                                }
                            ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="checkbox">
                              <label><input id = "1x1_checkbox" type="checkbox" checked value="">1x1</label>
                              <label><input id = "2x2_checkbox" type="checkbox" checked value="">2x2</label>
                              <label><input id = "3x3_checkbox" type="checkbox" checked value="">3x3</label>
                              <label><input id = "4x4_checkbox" type="checkbox" checked value="">4x4</label>
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <a class="btn btn-default" onclick = "search_player_battles()"><?php echo _('Find Games')?> <span class="glyphicon glyphicon-search"></span></a>
                        </div>
                    </div>

                    
                    <span id = "search_advice_wrapper"></span>
                    <br/>
                    <div style = "clear:both"/>
                        <div id = "fight_result">
                        </div>
                    </div>
                    <div id="scrollup"><img alt=<?php echo "'"._('Scroll Up')."'"?> src="images/arrows7.png"><br/><?php echo _('Up')?></div>

                </div>
            </div> 
        </div> 
        </div> 
    </body>

</html>



<!-- перенос, то, что ниже - нужно стереть -->





