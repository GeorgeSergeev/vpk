    <!-- главное меню -->
    <!-- активный раздел выделяется <b></b>, последний раздел выделяется <span></span> -->
    <div class=topmenu>
         <div class=mitem><?=mark($menuindex,1,1);?><li><a href='<?=$mainurl;?>'><?=Translate($LANG,'Главная');?></a></li><?=mark($menuindex,1,0);?></div>
         <div class=mitem><?=mark($menuindex,2,1);?><li><a href='about.php'><?=Translate($LANG,'O компании');?></a></li><?=mark($menuindex,2,0);?></div>
         <div class=mitem><?=mark($menuindex,3,1);?><li><a href='allnews.php'><?=Translate($LANG,'Новости');?></a></li><?=mark($menuindex,3,0);?></div>
         <div class=mitem><?=mark($menuindex,4,1);?><li><a href='service.php'><?=Translate($LANG,'Услуги');?></a></li><?=mark($menuindex,4,0);?></div>
         <div class=mitem><?=mark($menuindex,5,1);?><li><a href='equipment.php'><?=Translate($LANG,'Оборудование');?></a></li><?=mark($menuindex,5,0);?></div>
         <div class=mitem><?=mark($menuindex,6,1);?><li><a href='partners.php'><?=Translate($LANG,'Партнеры');?></a></li><?=mark($menuindex,6,0);?></div>
         <div class=mitem><span><?=mark($menuindex,7,1);?><li><a href='contacts.php'><?=Translate($LANG,'Контакты');?></a></li><?=mark($menuindex,7,0);?></span></div>
    </div>
    <!-- конец главного меню -->

    <!-- меню языков -->
    <div class=langmenu>
        <?php
          if (count($_GET)) $tok='&'; else $tok='?';       
          $lastquest="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].$tok;          
        ?> 
        <a href='<?=$lastquest?>ln=en'><div class=<?=GetActiveLang("en")?>en></div> </a> <!-- class=aen при активном english -->
        <a href='<?=$lastquest?>ln=ru'><div class=<?=GetActiveLang("ru")?>ru></div> </a> <!-- class=aen при активном english -->
                            <!-- class=ru при активном english -->
    </div>
    <!-- конец меню языков -->

