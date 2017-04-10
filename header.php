<?php
    // require_once("lib/steam.php");
    $locale = isset($_GET['lang'])?$_GET['lang']:'en_US';
    $_SESSION['lang'] = $locale;
    $lang = $locale;
    switch (substr($locale, 0, 2)) {
    case 'ru':
        $lang_id = 'ru';
        break;
    case 'en':
        $lang_id = 'en';
        break;
    case 'ko':
        $lang_id = 'ko';
        break;
    default:
        $lang_id = 'en';
        break;
    }

    define('BASE_PATH', realpath(dirname(__FILE__)));
    define('LANGUAGES_PATH', BASE_PATH . '/locale');

    putenv('LC_ALL=' . $locale);
    setlocale(LC_ALL, $locale, $locale . '.utf8');
    bind_textdomain_codeset($locale, 'UTF-8');
    bindtextdomain($locale, LANGUAGES_PATH);
    textdomain($locale);

    if (!function_exists('mb_ucfirst')) {
      function mb_ucfirst($string) {
          return mb_strtoupper(mb_substr($string, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($string, 1, mb_strlen($string), 'UTF-8');
      }
    }
    
    // $mysqligame = new mysqli("localhost", "dowstats_base", "r02yMdd34A", "dowstats_base");
    // $mysqligame->real_query("SELECT * FROM players");
    // $res = $mysqligame->store_result();
    // $online = 0;
    // while($row = $res->fetch_assoc()){
    //     if(Steam::get_status($row['sid']))
    //         $online++;
    // }
    
?>

<link rel="stylesheet" type="text/css" href = "language/languages.min.css"/>
<!-- HTML-код модального окна -->
<div id="DonateModalBox" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Заголовок модального окна -->
        <div class="modal-header">
            <h4 class="modal-title"><?php echo _('Donate for the project')?></h4>
        </div>
        <!-- Основное содержимое модального окна -->
        <div class="modal-body text-center">
            <iframe class = "donate-form" frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?account=410013789584224&quickpay=donate&payment-type-choice=on&mobile-payment-type-choice=on&default-sum=100&targets=%D0%A1%D0%BF%D0%B0%D1%81%D0%B8%D0%B1%D0%BE+%D0%B7%D0%B0+%D0%BF%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D1%83&target-visibility=on&project-name=Soulstorm+Ladder&project-site=http%3A%2F%2Fdowstats.h1n.ru&button-text=05&comment=on&hint=%D0%9A%D0%BE%D0%BC%D0%BC%D0%B5%D0%BD%D1%82%D0%B0%D1%80%D0%B8%D0%B9+%D0%BF%D0%BE%D0%BB%D1%83%D1%87%D0%B0%D1%82%D0%B5%D0%BB%D1%8E&successURL=" width="508" height="187"></iframe>
            <br/>
            <iframe class = "donate-form" src="https://funding.webmoney.ru/widgets/horizontal/1029c19c-0d76-421e-bb44-e8155451ca44?bt=0&hs=1&sum=2" width="468" height="150" scrolling="no" style="border:none;"></iframe>
            <br/>
            <form class = "donate-form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
            ">
            <input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online!">
            </form>
        </div>
        <!-- Футер модального окна -->
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _('Close')?></button>
        </div>
    </div>
  </div>
</div>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- <nav class="navbar navbar-default"> -->
      <!-- Бренд и переключатель, который вызывает меню на мобильных устройствах -->
      <!-- <div class="navbar-header"> -->
        <!-- Кнопка с полосочками, которая открывает меню на мобильных устройствах -->
<!--         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button> -->
        <!-- Бренд или логотип фирмы (обычно содержит ссылку на главную страницу) -->
<!--         <a href="#" class="navbar-brand">Бренд</a>
      </div> -->
    <!-- </div> -->
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav" id="navbar_list">
            <li id = "overall_stat" ><a href="<?php echo "index.php?lang=".$lang;?>"><?php echo _('General Ladder');?></a></li>
            <li id = "1x1_stat">     <a href="<?php echo "1x1.php?lang=".$lang;?>"><?php echo _('1x1 Ladder');?></a></li>
            <li id = "battles">      <a href="<?php echo "battles.php?lang=".$lang;?>"><?php echo _('Battles');?></a></li>
            <li id = "support">      <a href="<?php echo "support.php?lang=".$lang;?>"><?php echo _('Support');?></a></li>
            <li id = "collector">    <a href="ssstats/SSStatsInstaller.exe"><?php echo _('Download');?></a></li>
            <!-- <li id = "online">    <a><?php /*echo $online.' '._('online');*/?></a></li> -->
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="lang-sm lang-lbl-full" lang="<?php echo $lang_id?>"></span><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <?php
                    $get_array_url = $_GET;
                    unset($get_array_url['lang']);
                    $url = $_SERVER['PHP_SELF'] . "?" . http_build_query($get_array_url);
                ?>
                <li><a href = "<?php echo $url  . "&lang=ru_RU";?>"><span class="lang-sm lang-lbl-full" lang="ru"></span></a></li>
                <li><a href = "<?php echo $url  . "&lang=en_US";?>"><span class="lang-sm lang-lbl-full" lang="en"></span></a></li>
                <li><a href = "<?php echo $url  . "&lang=ko_KR";?>"><span class="lang-sm lang-lbl-full" lang="ko"></span></a></li>
            </ul>
          </li>
        </ul>
        <div class="navbar-form navbar-right">
            <button id="#openBtn" onclick="ShowModalBox()" class="btn btn-success"><?php echo _('Donate')?></button>
        </div>
    </div><!--/.nav-collapse -->

  </div><!--/.container-fluid -->
</nav>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    // $("#openBtn").click(function() {
    //     //открыть модальное окно с id="myModal"
    //     $("#myModal").modal('show');
    // });
    function ShowModalBox(){
        $('#DonateModalBox').modal({show:true})
    }
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter41980654 = new Ya.Metrika({
                    id:41980654,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/41980654" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->