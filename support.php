<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

$host = $_SERVER['HTTP_HOST'];

$lang = isset($_GET['lang'])?$_GET['lang']:'en_US';
putenv('LC_ALL=' . $lang);
setlocale(LC_ALL, $lang, $lang . '.utf8');
bind_textdomain_codeset($lang, 'UTF-8');
bindtextdomain($lang, '/locale');
textdomain($lang);

date_default_timezone_set('Europe/Moscow');

$mysqli = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
if ($mysqli->connect_error) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_error . ") " ;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

    <head>

        <title><?php echo _('Soulstorm Ladder')?></title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <script type="text/javascript">
            var lang = '<?php echo $lang?>';
        </script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.css" rel="stylesheet"/>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/donate.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
            $('#support').addClass('active');
        });
        function ShowModalBox(){
            $('#myModalBox').modal({show:true})
        }
        // После загрузки DOM-дерева (страницы)
        $(function() {     
          //при нажатии на ссылку, содержащую Thumbnail
          $('#support_img1').click(function(e) {
            //отменить стандартное действие браузера
            e.preventDefault();
            //присвоить атрибуту scr элемента img модального окна
            //значение атрибута scr изображения, которое обёрнуто
            //вокруг элемента a, на который нажал пользователь
            // $('#image-modal .modal-body img').attr('src', $(this).find('img').attr('src'));
            //открыть модальное окно
            $("#image-modal").modal('show');
          });
          //при нажатию на изображение внутри модального окна 
          //закрыть его (модальное окно)
          $('#image-modal').on('click', function() {
            $("#image-modal").modal('hide')
          });
        });
        </script>
    </head>

    <body>

    <div id="image-modal" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <img onclick="ShowModalBox()" style="max-width:100%" class="img-responsive img-rounded" src="images/enableStats.jpg">
        </div>
      </div>
    </div>

    <?php include "header.php";?>

    <div class="container-fluid" >
        <p id = "info"><?php echo _('After reinstalling the game or checking the cache, you must reinstall the statistics collector, because the file responsible for launching it is replaced!');?></p>
        <p id = "info"><?php echo _('You also need to make sure that the statistics are enabled. To do this, open the stats.ini file, check the "enableStats" option, it should be 1 as in the picture::');?></p>
            <div id="support_img1" class="img-hover">
              <a href="#">
                <i class="glyphicon glyphicon-search"></i>
                <img src="images/enableStats.jpg">
              </a>
            </div>
<!--             <div class="img-hover">
              <a href="#">
                <i class="glyphicon glyphicon-search"></i>
                <img src="img/2.jpg">
              </a>
            </div> -->
<!--             <a href="#">
            <div class="img">
                <img id="support_img1" style="max-width:10%" class="img-responsive" src="images/enableStats.jpg" alt="">
                <div class="hover"><img class="img-responsive" src="images/search-icon-hi.png" alt=""></div>
            </div> -->
        </a>
        <br/>
        <br/>
        <p id = "info"><?php echo _('If your stats are still not working, reinstall it with last version of stats collector!');?></p>
        <p id = "info"><?php echo _('You can report the problem found using the following contacts:').' ';?><a href="mailto:loa92@mail.ru">loa92@mail.ru</a>, <a href="http://steamcommunity.com/id/kiborg0/">steam</a>, <a href="https://vk.com/lebedkooa">vk.com</a>.</p>
        <br/>
    </div>

    <div class="container-fluid">
<!--         <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/quickpay/button-widget?account=410014995896827&quickpay=small&any-card-payment-type=on&button-text=06&button-size=m&button-color=black&targets=Soulstorm+Ladder&default-sum=100&successURL=" width="205" height="36"></iframe>
        <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/quickpay/button-widget?account=410014995896827&quickpay=small&yamoney-payment-type=on&button-text=06&button-size=m&button-color=black&targets=Soulstorm+Ladder&default-sum=100&successURL=" width="205" height="36"></iframe>
        <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/quickpay/button-widget?account=410014995896827&quickpay=small&mobile-payment-type=on&button-text=06&button-size=m&button-color=black&targets=Soulstorm+Ladder&default-sum=100&successURL=" width="205" height="36"></iframe> -->
        <div class="col-md-12 footer">
            <h4 id="footer-text">
            <?php echo _('Developers');?>: <a href="https://vk.com/id59975761">Anibus</a> <?php echo _('and');?> <a href="https://vk.com/lebedkooa">New</a><br>
            </h4>
        </div> 
    </div>

    </body>

</html>