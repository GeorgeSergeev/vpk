<?php
include("inc/settings.php");
$menuindex=4;
include ("inc/head.php");
//Branch GeorgeFront
?>

<script src="js/jquery-1.7.2.min.js"></script>
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
             <a href='<?=$mainurl;?>'><?=Translate($LANG,'Компания "Консул"');?></a>  <span>/</span>  <a><?=Translate($LANG,'Услуги');?></a>
          </div>
          <!-- конец хлебных крошек  -->
<?php   $topstatic=getStaticByCode(36,$LANG);
         echo" <h1>".$topstatic['name']."</h1>";
?>
          <div class=pnewstext>
               <? echo $topstatic['text']; ?>
          </div>

          <!-- если галерея сертификатов не пуста -->
          <div class=sertgallery>

            <?php PrintGallery (36,$LANG,'sertgalleryitem','sgpic'); ?>
          </div>
          <!-- конец галереи -->



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