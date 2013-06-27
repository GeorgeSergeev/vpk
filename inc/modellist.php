          <!-- список моделей / 10 моделей на странице -->
          <div class=newlistsarea>

              <!--  блок модели -->
              <?php
                 if (!isset($curr_page)) $curr_page=0;
                 $pagecount=getEquipList($LANG,'item.php', $id,2,$curr_page);
              ?>
              <!--  конец блока модели -->
          </div>
          <!-- конец списка новостей -->


          <div class=pageline>
           <?php           
            if ($pagecount>1)
            {	
            echo "Страницы:";            
            for ($i=1;$i<$pagecount+1;$i++)
 			{
   			  $y=$i-1;
   			  if ($curr_page==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
   			  echo"<a href=$PHP_SELF?curr_page=$y>$t1 $i $t2|</a>&nbsp";
 			} 
            }
 			?>         
 		   </div>