<?php
include("inc/settings.php");
$aboutstatic=getStaticByCode(37,$LANG);
$meta_title=$aboutstatic['seo_title'];
$meta_desc=$aboutstatic['seo_desc'];
$meta_key=$aboutstatic['seo_key'];
$menuindex=2;
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

      <!-- ñîäåðæèìîå ñòðàíèöû -->
      <div class=rightpart>

          <!-- õëåáíûå êðîøêè -->
          <div class=krohi>
             <!-- <a href=<?=$PHP_SELF?>> <?=Translate($LANG,'Äîáðî ïîæàëîâàòü');?>!</a> -->
             <a href='<?=$mainurl;?>'><?=Translate($LANG,'Êîìïàíèÿ "Êîíñóë"');?></a>  <span>/</span>  <a><?=Translate($LANG,'O êîìïàíèè');?></a>
          </div>
          <!-- êîíåö õëåáíûõ êðîøåê  -->
<?php
         echo" <h1>".$aboutstatic['name']."</h1>";
?>
          <div class=pnewstext>
               <? echo $aboutstatic['text']; ?>
          </div>


          <!-- åñëè ãàëåðåÿ ñåðòèôèêàòîâ íå ïóñòà -->
          <div class=sertgallery>
			 <?php PrintGallery (37,$LANG,'sertgalleryitem','sgpic'); ?>
          </div>
          <!-- êîíåö ãàëåðåè -->



      </div>
      <!-- êîíåö ñîäåðæèìîãî ñòðàíèöû -->


    </div>


    </td>
    <td class=rightbg>&nbsp;</td>
 </table>
<div>

<? include("inc/end.php"); ?>

</body>
</html>
