<?php
include("inc/settings.php");
$contactstatic=getStaticByCode(35,$LANG);
$meta_title=$contactstatic['seo_title'];
$meta_desc=$contactstatic['seo_desc'];
$meta_key=$contactstatic['seo_key'];
$menuindex=7;
include ("inc/head.php");
//Branch GeorgeFront
?>

<script src="js/jquery-1.8.3.js"></script>
<script src="js/lightbox.js"></script>

<body>

<div class=wrapper>

    <? include("inc/top.php");  ?>


    <div class=infoarea>

       <? include("inc/left.php"); ?>

      <!-- содержимое страницы -->
      <div class=rightpart>

          <!-- хлебные крошки -->
          <div class=krohi>
             <!-- <a href=<?=$PHP_SELF?>> <?=Translate($LANG,'Добро пожаловать');?>!</a> -->
            <a href='<?=$mainurl;?>'><?=Translate($LANG,'Компания "Консул"');?>
             </a>  <span>/</span>  <a href='contacts.php'><?=Translate($LANG,'Контактная информация');?></a>
          </div>
          <!-- конец хлебных крошек  -->

          <h1><?=$contactstatic['name'];?></h1>
          <div class=pnewstext>

             <? include("inc/contactform.php");  ?>

            <?=$contactstatic['text'];?>

          </div>

          <div class=map>
<div id="ymaps-map-id_135523492424244112816" style="width: 655px; height: 370px;"></div>
<div style="width: 450px; text-align: right;"><a href="http://api.yandex.ru/maps/tools/constructor/index.xml" target="_blank" style="color: #1A3DC1; font: 13px Arial, Helvetica, sans-serif;"></a></div>
<script type="text/javascript">function fid_135523492424244112816(ymaps)
  {var map = new ymaps.Map("ymaps-map-id_135523492424244112816", {center: [33.526051999999964, 44.56737370423955], zoom: 16, type: "yandex#map"});
  map.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));
  map.geoObjects.add(new ymaps.Placemark([33.526052, 44.566484], {balloonContent: "ООО ВЭК Консул"}, {preset: "twirl#lightblueDotIcon"}));};</script>
  <script type="text/javascript" src="http://api-maps.yandex.ru/2.0-stable/?lang=ru-RU&coordorder=longlat&load=package.full&wizard=constructor&onload=fid_135523492424244112816"></script>
          </div>



      </div>
      <!-- конец содержимого страницы -->


    </div>


    </td>
    <td class=rightbg>&nbsp;</td>
 </table>
<div>

<? include("inc/end.php"); ?>

</body>
</html>
