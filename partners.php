<?php
include("inc/settings.php");
$menuindex=6;
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
             </a>  <span>/</span>  <a><?=Translate($LANG,'Партнеры');?></a>                       
          </div>
          <!-- конец хлебных крошек  -->

          <h1><?=Translate($LANG,'Партнеры');?></h1>

          <?
             include("inc/partnerpagelist.php");
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
