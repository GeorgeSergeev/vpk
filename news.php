<?php
include("inc/settings.php");


$newsid=$_GET['id'];
$newsitem=getnewsbyid($LANG,$newsid);
$menuindex=3;
list($news_date,$news_name,$news_abstract,$news_text,$meta_title,$meta_desc,$meta_key,$pagecode,$pagename)=$newsitem;
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

      <!-- ���������� �������� -->
      <div class=rightpart>

          <!-- ������� ������ -->
          <div class=krohi>
             <!-- <a href=<?=$PHP_SELF?>> <?=Translate($LANG,'����� ����������');?>!</a> -->
             <a href='<?=$mainurl;?>'><?=Translate($LANG,'�������� "������"');?>
             </a>  <span>/</span>  <a href='allnews.php'><?=Translate($LANG,'�������');?></a> <span>/</span>  
             <a><?=$news_name ?></a>
          </div>
          <!-- ����� ������� ������  -->

          <h1><?=$news_name ?></h1>
          <div class=pnewstext>

            <p>
               <?=ConvertDate($news_date);?> <BR>
               <?=$news_text ?>
            </p>


          <!-- ���� � ������� ���� ������� -->
          <div class=gallery>
			 <?php PrintGallery ($pagename,$LANG,'galleryitem','gpic'); ?>
           </div>
          <!-- ����� ������� -->

          <!-- ��������� �� ��������� -->
            <div class=pagenavigate>

             <div class=pnlinks>
                 
                 <?php  $previd=GetPrevNews($newsid, $news_date);
                     if ($previd>0)
                     echo "<a href='news.php?id=$previd'>&laquo;".Translate($LANG,'�����������')." </a>";
                     else echo Translate($LANG,'����������');
                 ?>                                
                 <span><a>|</a></span>
                 <?php  $nextid=GetNextNews($newsid, $news_date);
                     if ($nextid>0)
                     echo "<a href='news.php?id=$nextid'>".Translate($LANG,'���������')."&raquo;</a>";
                     else echo Translate($LANG,'���������');
                 ?>                                
               </div>

               <div class=alllinks>
                 <a href="allnews.php"><?=Translate($LANG,'��� �������')?></a>
               </div>

            </div>
          <!-- ����� ��������� �� ��������� -->


         </div>


      </div>
      <!-- ����� ����������� �������� -->


    </div>


    </td>
    <td class=rightbg>&nbsp;</td>
 </table>
<div>

<? include("inc/end.php"); ?>

</body>
</html>
