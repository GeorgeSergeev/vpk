          <!-- список партнеров / 10 партнеров на странице -->
          <div class=newlistsarea>

              <!--  блок партнера -->
              <?php  if (!isset($curr_page)) $curr_page=0;  
                 $pagecount=PrintPartner ($LANG,false, 1,$curr_page); 
               ?>
              <!--  
              <div class=partnerlistitem>
                 <div class=plpic><a href='сайт партнера'><img src='images/logo1.png' alt='Наименование партнера' border=0></a></div>
                 <div class=pltext>
                   <h2><a href='сайт партнера'>Наименование партнера</a></h2>
                   Аннотация компании-парннера. Аннотация компании-парннера. Аннотация компании-парннера. Аннотация компании-парннера. Аннотация компании-парннера.
                   Аннотация компании-парннера.
                   <div class=plmore><a href='сайт партнера'>www.сайт партнера.com</a></div>
                 </div>
              </div>
              -->
              <!--  конец блока партнера -->

          </div>
          <!-- конец списка партнеров -->


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