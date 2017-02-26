<link rel="stylesheet" type="text/css" href = "language/languages.min.css"/>
<style type="text/css">
#cup {
  color: red; /* or whatever color you prefer */
}
</style>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <?php
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
    ?>
    <div id="navbar" class="navbar-collapse collapse">
        <div id="lang_selector" class="dropdown"  >

            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="lang-sm lang-lbl-full" lang="<?php echo $lang_id?>"></span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style = "z-index:1001;">
                <?php
                    $get_array_url = $_GET;
                    unset($get_array_url['lang']);
                    $url = $_SERVER['PHP_SELF'] . "?" . http_build_query($get_array_url);
                ?>
                <li><a href = "<?php echo $url  . "&lang=ru_RU";?>"><span class="lang-sm lang-lbl-full" lang="ru"></span></a></li>
                <li><a href = "<?php echo $url  . "&lang=en_US";?>"><span class="lang-sm lang-lbl-full" lang="en"></span></a></li>
                <li><a href = "<?php echo $url  . "&lang=ko_KR";?>"><span class="lang-sm lang-lbl-full" lang="ko"></span></a></li>
            </ul>

        </div>
<!--         <div>
            <button class="btn btn-default" type="button" id="dropdownMenu1" aria-haspopup="true" aria-expanded="true">
                 <a href="ssstats/ssstats.rar"><?php echo _('Stats Collector');?></a>
            </button>
        </div> -->
        <ul class="nav navbar-nav" id="navbar_list">
            <li id = "overall_stat" ><a href="<?php echo "index.php?lang=".$lang;?>"><?php echo _('General Ladder');?></a></li>
            <li id = "1x1_stat">     <a href="<?php echo "1x1.php?lang=".$lang;?>"><?php echo _('1x1 Ladder');?></a></li>
            <li id = "battles">      <a href="<?php echo "battles.php?lang=".$lang;?>"><?php echo _('Battles');?></a></li>
            <li id = "collector">    <a href="ssstats/ssstats.rar"><?php echo _('Stats Collector');?></a></li>
        </ul>
            <!-- <li id = "collector">    <a href="ssstats/ssstats.rar"><?php echo _('Stats Collector');?></a></li> -->
            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->

        

    </div><!--/.nav-collapse -->

  </div><!--/.container-fluid -->
</nav>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
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