<?php
include("inc/settings.php");
$mainstatic=getStaticByCode(39,$LANG);
$meta_title=$mainstatic['seo_title'];
$meta_desc=$mainstatic['seo_desc'];
$meta_key=$mainstatic['seo_key'];
$menuindex=5;
include ("inc/head.php");
//Branch GeorgeFront
?>


<body>

<div class=wrapper>

    <? include("inc/top.php");  ?>


    <div class=infoarea>

       <? include("inc/left.php"); ?>

      <!-- содержимое страницы -->
      <div class=rightpart>

          <!-- хлебные крошки -->
          <div class=krohi>
            
            <a href='<?=$mainurl;?>'><?=Translate($LANG,'Компания "Консул"');?>
             </a>  <span>/</span>  <a href='equipment.php'><?=Translate($LANG,'Оборудование');?></a>          
          </div>
          <!-- конец хлебных крошек  -->

          <h1><?=Translate($LANG,'Оборудование');?></h1>

          <?
             include("inc/typecatalog.php");
          ?>

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
