          <!-- топ новости -->
          <div class=mainnewsarea>
              <h5><?=Translate($LANG,'Новости и события')?></h5>
             <?php
             $news=getlastnews($LANG,3);
             foreach ($news as $newsitem)
             {
              print '<div class=mnewsitem>';
              $picname=$newsitem[3];
              if ($picname=="") $picname=nullnews.gif;
              ?>
               <center><div class=mnpic><a href=''><img src='images/<?=$picname?>' alt='<?=$newsitem[4]?>'></a></div></center>
               <div class=mnetstext>
               <span> <?=$newsitem[1]?></span>
               <p> <?=$newsitem[2]?></p>
               </div>
                  <?php
                     if(empty($newsitem[5])) $newspath='news.php?id='.$newsitem[0];
                         else  $newspath=$newsitem[5];
                   ?>               
              <div class=mnmore><a href='<?=$newspath?>'><?=Translate($LANG,'подробнее')?>»</a> </div>
              </div>
              <?php
             }
              ?>
              
         </div>
          <!-- конец топ новостей -->
