<?php
$photo_alb_path="$root_http$fotoalb_path";

function create_photo_alb($img_num,$photo_alb_page_id,&$result)
{

global $photo_alb_path;
//выгребаем страницу фотоальбома...
$sql="SELECT `foto`.`foto_id`,`foto`.`foto_file`,`foto`.`foto_descr_ru`,`foto`.`foto_w`,
       `foto`.`foto_h`,
       `foto`.`foto_source`,
       `foto`.`foto_num`
FROM `foto`
WHERE `foto`.`fotoalb_page_id` = $photo_alb_page_id
ORDER BY `foto`.`foto_num`
";
$do_get = mysql_query($sql)or die("!!!".mysql_error().$sql);
$num_rows_str = mysql_num_rows($do_get);
if ($num_rows_str!=0){

$result.="<script language='JavaScript'>
      var photo_alb_path='$photo_alb_path';

      function change_photo(direction,img,anch_name,img_ar,desc_ar){
      var i;
      for(i=0;i<img_ar.length;i++){
       if (img.src.indexOf(img_ar[i])>=0) break;
      }
      nextnum=i+direction;
      if (nextnum<0) nextnum=img_ar.length-1;
      else if (nextnum>img_ar.length-1) nextnum=0;
      img.src=photo_alb_path+img_ar[nextnum];
      img.alt=desc_ar[nextnum];
      nextnum++;

      for(i=0;i<document.anchors.length;i++)
          if (document.anchors[i].name==anch_name) break;
      document.anchors[i].innerHTML=' изображение '+nextnum+' из '+img_ar.length;
      for(i=0;i<document.anchors.length;i++)
          if (document.anchors[i].name==('descr_'+anch_name)) break;
      document.anchors[i].innerHTML=desc_ar[nextnum-1];
      }
      </script>";


  $result.='<script language="JavaScript">';
  $result.=" albimages$img_num = new Array(); ";
  $result.=" descrimages$img_num = new Array(); ";
  $result.=" wimages$img_num = new Array(); ";
  $result.=" himages$img_num = new Array(); ";
  $i=0;
  while ($results = mysql_fetch_assoc($do_get))
   {
    if(!$i){
        $photo =$results["foto_source"]."/".$results["foto_id"]."_".$results["foto_file"];
        $photo_descr= trim($results["foto_descr_ru"]);
        if($results["foto_w"]) $photo_w="width=".$results["foto_w"];
        if($results["foto_h"]) $photo_h="height=".$results["foto_h"];
        $photo_src= $results["foto_source"];
    }

    $result.="albimages$img_num"."[$i]='{$results["foto_source"]}/{$results["foto_id"]}_{$results["foto_file"]}';";
    $result.="descrimages$img_num"."[$i]='".trim($results["foto_descr_ru"])."';";
    $result.="wimages$img_num"."[$i]='{$results["foto_w"]}';";
    $result.="himages$img_num"."[$i]='{$results["foto_h"]}';";
    $i++;
   }
  $result.="</script>";

 $result.="<table Border=0 CellSpacing=0 align=center width=100%>
     <tr><td align=center>
      <img name=img$img_num src='$photo_alb_path$photo' alt='$photo_descr' title='$photo_descr' $photo_w $photo_h border=1>
     </td></tr>
     <tr><td align=center>
      <a name=descr_anch$img_num> $photo_descr </a>
     </td></tr>
     ";
 if ($num_rows_str>1)
    $result.="
     <tr><td>
       <table align=center>
             <tr>
               <td><a name=left onclick=\"change_photo(-1,document.img$img_num, 'anch$img_num' , albimages$img_num, descrimages$img_num)\"><img border=0 style='cursor: hand;'  src='graph/leftarrow1.gif' height=12><img border=0 style='cursor: hand;'  src='graph/leftarrow1.gif' height=12 alt='предыдущее изображение' title='предыдущее изображение'></a></td>
               <td align=center ><a name='anch$img_num'> изображение 1 из $num_rows_str</a></td>
               <td><a name=right onclick=\"change_photo(1,document.img$img_num, 'anch$img_num' , albimages$img_num, descrimages$img_num)\"><img border=0 style='cursor: hand;'  src='graph/rightarrow1.gif' height=12><img border=0 style='cursor: hand;'  src='graph/rightarrow1.gif' height=12 alt='следущее изображение' title='следущее изображение'></a></td>
              </tr>
       </table>
      </td>
     </tr>
     ";
 $result.="</table> </td></tr>";

 }
}
//конец функции
?>