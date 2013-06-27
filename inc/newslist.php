          <!-- список новостей/ 10 новостей на странице -->
          <div class=newlistsarea>

          <?php
             $per_page=10;
             if (!isset($curr_page)) $curr_page=0;
             $news=getlastnews($LANG);
             $num_rows=count($news);
             if($num_rows)
             {
             	$page_quant=ceil($num_rows / $per_page); //всего страниц
             	$start_pos=$curr_page*$per_page;
             	if ($start_pos+$per_page<$num_rows) $end_pos=$start_pos+$per_page;
             	else $end_pos=$num_rows;
             	for ($x=$start_pos; $x<$end_pos; $x++)
                {
                 $newsitem=$news[$x];
                 print '<div class=newslistitem>';
                 $picname=$newsitem[3];
                 if ($picname=="") $picname=nullnews.gif;
           ?>

                 <div class=nlpic><a href='news.php?id=<?=$newsitem[0]?>'><img src='images/<?=$picname?>' alt='<?=$newsitem[4]?>' border=0></a></div>
                 <div class=nltext>
                   <h2><a href='news.php?id=<?=$newsitem[0]?>'><?=$newsitem[4]?></a></h2>
                   <div class=nldate><?=ConvertDate($newsitem[1])?></div>
                   <?=$newsitem[2]?>
                   <?php
                     if(empty($newsitem[5])) $newspath='news.php?id='.$newsitem[0];
                         else  $newspath=$newsitem[5];
                   ?>
                   <div class=nlmore><a href='<?=$newspath?>'><?=Translate($LANG,'подробнее');?> ї</a></div>
                 </div>
                 </div>
           <?php
                 } // for
             } //if
            ?>


          </div>
          <!-- конец списка новостей -->


          <div class=pageline>
            <?php
            if ($page_quant>1)
            {	
              echo "—траницы: <span>";
              for ($i=1;$i<$page_quant+1;$i++)
 			  {
   			    $y=$i-1;
   			    if ($curr_page==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
   			    echo"<a href=$PHP_SELF?curr_page=$y>$t1 $i $t2|</a>&nbsp";
 			  }
            }
 			?>
          </span> </div>