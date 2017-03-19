<?php
require_once("lib/RaceSwitcher.php");
// header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

$lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
putenv('LC_ALL=' . $lang);
setlocale(LC_ALL, $lang, $lang . '.utf8');
bind_textdomain_codeset($lang, 'UTF-8');
bindtextdomain($lang, 'locale');
textdomain($lang);

date_default_timezone_set('Europe/Moscow');



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

        <link href="css/main.css" rel="stylesheet"/>
        <link href="css/battles.css" rel="stylesheet"/>
        <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css" rel="stylesheet"/>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script type="text/javascript" src="js/battles.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script>

        <script type="text/javascript">
            var lang = '<?php echo $lang?>';
        </script>
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
                <div class="col-md-12 col-sm-12">
                    <div class="toggle-content text-center">
                        <div class = "search_div">
                            <div class="form-group col-md-3" >
                                <label class="sr-only" for="player_name_input"><?php echo _("Find by player name/clan name")?></label>
                                <input id="player_name_input" onkeydown=" player_name_input_keypress_battles(event)"  class="form-control autocomplete" placeholder=<?php echo "'"._("Enter opponent/ally")."'"?> >
                            </div>
                            <span id = "search_advice_wrapper"></span>

                            <div class="form-group col-md-3">
                            <label class="sr-only" for="race_option">Раса</label>
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

                        <br/>
                        <div style = "clear:both"/>
                            <div id = "fight_result">
                            </div>
                        </div>
                        <div id="scrollup"><img alt=<?php echo "'"._('Scroll Up')."'"?> src="images/arrows7.png"><br/><?php echo _('Up')?></div>

                    </div> <!-- /.col-md-12 -->
                </div>
            </div>
	    </div>  <!-- /.row -->
    </div>  <!-- /.container-fluid -->
</body>

</html>
