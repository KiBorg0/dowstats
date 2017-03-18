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

$mysqli = new mysqli("localhost", "zisfxloz_base", "W7y9B3r5", "zisfxloz_base");
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
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/donate.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/scrollup.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
            $('#donate').addClass('active');
        });
        </script>
    </head>

    <body>

    <?php include "header.php";?>

    <div class="container text-center donate-container" >
        <h1><?php echo _('HELP US LOOT THIS'); ?>!!!</h1>
        <iframe class = "donate-form" frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?account=410014995896827&quickpay=donate&payment-type-choice=on&mobile-payment-type-choice=on&default-sum=100&targets=%D0%A1%D0%BF%D0%B0%D1%81%D0%B8%D0%B1%D0%BE+%D0%B7%D0%B0+%D0%BF%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D1%83&target-visibility=on&project-name=Soulstorm+Ladder&project-site=http%3A%2F%2Fdowstats.h1n.ru&button-text=05&successURL=" width="508" height="117"></iframe>
        <br/><br/>
        <iframe class = "donate-form" src="https://funding.webmoney.ru/widgets/vertical/1029c19c-0d76-421e-bb44-e8155451ca44?bt=0&hc=1&hs=1&sum=2" width="240" height="190" scrolling="no" style="border:none;"></iframe>
        <br/><br/>
        <form class = "donate-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
        ">
            <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
        </form>
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