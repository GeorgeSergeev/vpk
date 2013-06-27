<?php
include("inc/settings.php");

/*
$meta_title = заголовок предмета если не перекрыта на статике
$meta_desc = аннотация предмета если не перекрыта на статике
$meta_key = заголовок предмета если не перекрыта на статике
*/
$menuindex=5;
$id=$_GET['id'];


$catalogstatic=getCatalogStatic($id, $LANG);
$meta_title=$catalogstatic['seo_title'];
$meta_desc=$catalogstatic['seo_desc'];
$meta_key=$catalogstatic['seo_key'];

$parentid=getParentId($id);
$parentstatic=getCatalogStatic($parentid,$LANG);

$praparentid=getParentId($parentid);
$praparentstatic=getCatalogStatic($praparentid,$LANG);


$opensub=true;
$opensubcode=$praparentid;



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
             <a href='<?=$mainurl;?>'><?=Translate($LANG,'Компания "Консул"');?> </a> 
              <span>/</span>  <a href='equipment.php'><?=Translate($LANG,'Оборудование');?></a> <span>/</span> 
               <a href="catalog.php?id=<?=$praparentid?>"><?=$praparentstatic['name']?></a><span>/</span>
               <a href="models.php?id=<?=$parentid?>"><?=$parentstatic['name']?></a><span>/</span>
               <a><?=$catalogstatic['name']?></a>         
          </div>
          <!-- конец хлебных крошек  -->

          <h1><?=$catalogstatic['name']?></h1>

          <div class=pnewstext>

            <div class=itemgallery>
                <?php ItemGallery($id,$LANG);?>
                <!--  
                <div class=itembpic id=ibp0><a href='images/item1.jpg' title='Комментарий к изображению' rel='lightbox[item]' target=_blank><img src="images/item1.jpg"  alt='комментарий к изображению' border=0></a></div>
                <div class=itembpic id=ibp1 style='display:none;'><a href='images/item1-1.jpg' title='Комментарий к изображению' rel='lightbox[item]' target=_blank><img src="images/item1-1.jpg"  alt='комментарий к изображению' border=0></a></div>
                <div class=itembpic id=ibp2 style='display:none;'><a href='images/item1-2.jpg' title='Комментарий к изображению' rel='lightbox[item]' target=_blank><img src="images/item1-2.jpg"  alt='комментарий к изображению' border=0></a></div>
                <div class=itembpic id=ibp3 style='display:none;'><a href='images/item1-3.jpg' title='Комментарий к изображению' rel='lightbox[item]' target=_blank><img src="images/item1-3.jpg"  alt='комментарий к изображению' border=0></a></div>

                <div class=roomiconlist>
                    <div class=roomiconarea>
                        <div class=itemicon onclick=showpic(0,4)><img src="images/item1.jpg" border=0></div>
                        <div class=itemicon onclick=showpic(1,4)><img src="images/item1-1.jpg" border=0></div>
                        <div class=itemicon onclick=showpic(2,4)><img src="images/item1-2.jpg" border=0></div>
                        <div class=itemicon onclick=showpic(3,4)><img src="images/item1-3.jpg" border=0></div>
                    </div>
                </div>  
                -->

            </div>


           <?=$catalogstatic['text']?>

            <div class=itemadd>
               <h3><?=Translate($LANG,'Дополнительная информация'); ?>: </h3>
               <?php if ($catalogstatic['static_url'])
               	print "<div class=itemaddlink>".Translate($LANG,'Документация')." ".$catalogstatic['name']."  :"; 
                print "<a href='".$catalogstatic['static_url']."' ".Translate($LANG,'скачать')." (.pdf, 12Мб)</a></div>";
                if ($catalogstatic['page_url'])
                    print "<div class=itemaddlink>".Translate($LANG,'Интернет-сайт производителя').": <a href='".$catalogstatic['page_url']."' target=_blank>".$catalogstatic['page_url']."</a></div>";
               ?>                            
            </div>

            <div class=pagenavigate>

             <div class=pnlinks>
                 
                 <?php  $previd=GetPrevEquip($id,$parentid);
                     if ($previd>0)
                     echo "<a href='item.php?id=$previd'>&laquo; ".Translate($LANG,'предыдущий')." &raquo;</a>";
                     else echo Translate($LANG,'предыдущий');
                 ?>
                 <span><a>|</a></span>
                 <?php  $nextid=GetNexEquip($id,$parentid);
                     if ($nextid>0)
                     echo "<a href='item.php?id=$nextid'>".Translate($LANG,'следующий')." &raquo;</a>";
                     else echo Translate($LANG,'следующий');
                 ?>
               </div>

               <div class=alllinks>
                 <a href="models.php?id=<?=$parentid?>"> <?=Translate($LANG,'Все оборудование') ?> <?=$parentstatic['name']?></a>               
               </div>

            </div>


          </div><br/>

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
