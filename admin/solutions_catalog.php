<?php
include("inc/settings.php");
$per_page=30;
$maxlevel=120;
$oper=$_POST['oper'];
//$catalog_parent=$_POST['catalog_parent'];

if(!isAllowed("pCatalogEdit")) {die("У Вас недостаточно прав для просмотра этой страницы");}
if($sortby) $sortparam="&sortby=$sortby&sortdir=$sortdir"; else $sortparam="";
if (!isset($catalog_parent)) $catalog_parent=0;
if (!isset($curr_page)) $curr_page=0;
$_SESSION["pageback"]="$PHP_SELF?curr_page=$curr_page&catalog_parent=$catalog_parent$sortparam";
//$backpage="newspage.php";
if(!($sortby)) $sortby='page_name'; else {$sortby=explode(" ",$sortby);$sortby=$sortby[0];}

if(!isset($sortdir)) {$sortdir="1";$realsortdir="ASC"; }
else
{
 if($sortdir==0) {$realsortdir="DESC";} else {$sortdir=1;$realsortdir="ASC";}
}

$catalogQuery="SELECT
				{$PREFFIX}_catalog.catalog_code,
				{$PREFFIX}_catalog.catalog_pos,
				{$PREFFIX}_catalog.catalog_url,
				{$PREFFIX}_page.page_code,
				{$PREFFIX}_page.page_name,
				{$PREFFIX}_page.page_active
			FROM
			{$PREFFIX}_catalog
			INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_catalog.page_code = {$PREFFIX}_page.page_code
			WHERE {$PREFFIX}_catalog.catalog_parent=$catalog_parent
			order by $sortby $realsortdir";
//echo $catalogQuery;
if (!empty($oper))
{

if ($oper=='I')
{
$err=0;
mysql_query("start transaction;");
if ($level<$maxlevel) $pagetype="department"; else $pagetype="catalog";
$query="insert into {$PREFFIX}_page (page_name,  page_active, page_type) values('$page_name',0,'$pagetype')";
$result=mysql_query($query) or $err=1;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());
if (!$err)
{
 $page_code=mysql_insert_id();
 $query="insert into {$PREFFIX}_static (page_code,static_name,static_text,lang_code,static_abstract)
       values($page_code,'".mysql_escape_string($page_name)."','',1,'')";
  $result=mysql_query($query) or $err=2;
}
if (!$err)
{
  $res=mysql_query("update {$PREFFIX}_catalog set catalog_pos=catalog_pos+1 where catalog_pos>=$catalog_pos and {$PREFFIX}_catalog.catalog_parent=$catalog_parent");
  $query="insert into {$PREFFIX}_catalog (catalog_pos,catalog_url,page_code, catalog_parent) values('$catalog_pos','$catalog_url',$page_code, $catalog_parent)";
  $result=mysql_query($query) or $err=1;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());
  $news_code=mysql_insert_id();
//  RenumeratePos("{$PREFFIX}_catalog","catalog_code","catalog_pos","catalog_parent",$catalog_parent);
}

if(!$err)
  {
      mysql_query("commit;");
    //для постраничного-------------------------------------------------------------
     $result=mysql_query($catalogQuery) or die("Incorrect News Query ".catalogQuery);
  }
  else mysql_query("rollback;");
}


if ($oper=="D")
{
  while (list($key,$value)=each($_POST))
  {
      unset($arr);
      $arr=explode('#',$key);
      $varName=$arr[0];
      $varCode=$arr[1];
      $varPos=$arr[2];
//      echo"varCode=$varCode<br>varName=$varName<br>varPos=$varPos<br>";
      if ( ($varName=="C")&&($value=="on"))
      {
         $err=0;
         $query = "delete from {$PREFFIX}_page where page_code=$varCode";
         $resultdel = mysql_query($query) or $err+=10;

         $query = "delete from {$PREFFIX}_catalog where page_code=$varCode";
         $resultdel = mysql_query($query) or $err+=10;
      }
  }
}//oper=D

if (!strcasecmp($oper,"U"))
{
  $err=0;
  while (list($key,$value)=each($_POST))
  {
      $arr=explode('#',$key);
      $varName=$arr[0];
      $varCode=$arr[1];
      $varField=$arr[2];
      $varType=$arr[3];

    if ($_POST["C#$varCode"]=="on")
    {
      $flag=0;
      if ($varName=="F")
      {
         $fieldname=$varField;
         $tablename=strtok($fieldname,'_'); //Смотрим какую таблицу править
         if ($varType=="string") $tmpu="'"; else $tmpu="";
         $sqlupd = "update {$PREFFIX}_{$tablename} set $varField=$tmpu".$value."$tmpu  where page_code=$varCode";
//         echo"$sqlupd";
         $resultupd = MYSQL_QUERY($sqlupd) or $err-=10;
      }
    }
  }//while
//  RenumeratePos("{$PREFFIX}_static","static_code","static_pos","part_code",$part_code);

}//if  (UPD)
   header("Location: $PHP_SELF?err=$err&catalog_parent=$catalog_parent$sortparam");
}//empty
?>



<? include ("inc/head.php"); ?>

<script language = JavaScript>
function Send(a)
{
document.data.oper.value=a;
document.data.submit();
}


function GotoSub(pc)
{
	document.data.catalog_parent.value=pc;
	document.data.submit();
}

function change_yes_no(Check,Unit){
Elem=document.getElementById("C#"+Check);
Elem.checked=true;
Unit=document.getElementById(Unit);
while ((Unit.id==null)||(Unit.id.indexOf('#')==0)) Unit=Unit.parentElement;
var name=Unit.id;
var value=Unit.innerHTML.replace("'","&#39;");
if (value.indexOf('<SELECT')>=0) return ;
res = "<SELECT style='width:100%' class=smalltext name='"+name+"'><OPTION VALUE=0>нет</OPTION><OPTION VALUE=1>да</OPTION></SELECT>";
Unit.innerHTML = res;
}


function change_line(Check,Unit)
{
Elem=document.getElementById("C#"+Check);
Elem.checked=true;
Unit=document.getElementById(Unit);
while ((Unit.id==null)||(Unit.id.indexOf('#')==0)) Unit=Unit.parentElement;
var name=Unit.id;
var value=Unit.innerHTML.replace("'","&#39;");
if (value.indexOf('<input')>=0) return ;
res = "<input style='width:100%;' class=smalltext name='"+name+"' value='" + value+"'>";
Unit.innerHTML = res;
}




function ConfirmSend(a)
{
if (confirm('Вы уверены, что хотите удалить элемент каталога?'))
 {
    document.data.oper.value=a;
    document.data.submit();
 }
}

</script>

<BODY>
<center>

<div class=mainbody>

<? include("inc/top.php");?>


<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
  <tr><td class=pageline>

<?php
//*********************  Поиск по дереву  *******************************
$ep=$catalog_parent;
$level=0;
$outs="";
while ($ep)
{$level++;
 $pq="SELECT
 {$PREFFIX}_catalog.catalog_code,
 {$PREFFIX}_catalog.catalog_parent,
 {$PREFFIX}_page.page_name
 FROM
 {$PREFFIX}_catalog
 INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_catalog.page_code = {$PREFFIX}_page.page_code
 WHERE {$PREFFIX}_catalog.catalog_code=$ep";

 $res=mysql_query($pq) or die("Incorrect catalog queery: ".$pq) ;
 list($ec,$ep,$en)=mysql_fetch_array($res);
 if (!isset($praparent) and (isset($lastlev))) $praparent=$ec;
 if (!isset($lastlev)) $lastlev=$en;
 
 $outs="<a href=$PHP_SELF?catalog_parent=$ec$sortparam>$en</a> / ".$outs;
}
$outs="<a href=$PHP_SELF>Каталог</a> / ".$outs;
echo " <div class=wmiddletext> &nbsp <a href='main.php'>Администрирование сайта</a> / ". $outs."</div>";
if (!isset($lastlev)) $lastlev="Каталог";
//*********************  Поиск по дереву  *******************************
?>


  </td></tr>
</table>
&nbsp;

<table Border=0 CellSpacing=0 CellPadding=0 class=mainbody>
 <tr valign=top>

  <td width=10></td>
  <? include("inc/leftmenu.php"); ?>
  <td width=10></td>

  <td>

<?php
echo"<form name='data' action=$PHP_SELF method=POST>";
echo"<input type=hidden name='oper' value=''>";
echo"<input type=hidden name=curr_page value=\"$curr_page\">";
echo"<input type=hidden name=catalog_parent value=$catalog_parent>";
echo"<input type=hidden name=sortby value=\"$sortby\">";
echo"<input type=hidden name=sortdir value=\"$sortdir\">";
echo"<input type=hidden name=level value=\"$level\">";
$maxquery="select max(catalog_pos) from {$PREFFIX}_catalog WHERE {$PREFFIX}_catalog.catalog_parent=$catalog_parent";
$result=mysql_query($maxquery) or die("Incorrect Max Query: ".$maxquery) ;
list($max_pos)=mysql_fetch_array($result);
$max_pos++;
?>

<table class=grayhead Border=0 CellSpacing=0 CellPadding=0 >
 <tr class=normaltext>
  <td ><div ><h4><?=$lastlev?></h4></div></td>
  <td align=right class=wmiddletext><a class=submenu onclick="displayform(this,'добавить элемент каталога')">добавить элемент каталога</a></td>
 </tr>
</table>

<div id=addform>
<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0>
 <tr><td colspan=3 bgcolor=#ffffff height=10></td></tr>
 <tr><td colspan=10 class=blueheadcolor><center><div class=normaltext>ДОБАВИТЬ ЭЛЕМЕНТ КАТАЛОГА</div></center></td></tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr><td>
 <center>
  <table cellpadding=2  cellspacing=0>
  <tr height=30 >
    <td class=lmenutext>Название элемента:</td>
    <td width=5></td>
    <td><input name='page_name' type=text style="width:250px" class=smalltext></td>
 </tr>
<!--
 <tr height=30 >
    <td class=lmenutext> URL: </td>
    <td width=5></td>
    <td><input name='catalog_url' type=text style="width:250px" class=smalltext></td>
 </tr>
  -->
 <tr height=30 >
    <td class=lmenutext> Позиция: </td>
    <td width=5></td>
    <td><input name='catalog_pos' type=text style="width:250px" class=smalltext value='<?=$max_pos?>'></td>
 </tr>
 </table>
 </td>

 <td class=helpzone>

     <table Border=0 CellSpacing=1 CellPadding=0 bgcolor=#999999 class=helptable>
       <tr>
        <td class=helptd>

             <div class=ssmalltext>
                Заполните поля формы и нажмите кнопку "добавить элемент". </a>
             </div>

        </td>
       </tr>
     </table>

 </td>


 </tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr> <td colspan=10 id=blueheadcolor><center><input type=button onClick=Send('I') value='добавить элемент'  class=smalltext> </td></tr>
</table>
</div>


<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 >
<?php
 if ($catalog_parent<>0)
 {
 	if (!isset($praparent)) $praparent=0; 
    echo  '<tr><td class=lmenutext height=60 bgcolor=#ffffff align="center"><h5>Подраздел: ';
 	echo"$lastlev";
    echo  "</h5> <a href=$PHP_SELF?catalog_parent=$praparent$sortparam> вернуться на предудущий уровень </a> </td></tr>";
  }
 else echo"<br>";
 ?>
</table>

<?php
 if(intval($err)<=-10) echo"<div class=smalltext align=center style='color:red;'>Ошибка при изменении элемента</div>";
 if(intval($err)>=10) echo"<div class=smalltext align=center style='color:red;'>Ошибка при удалении элемента</div>";
 if(intval($err)==1) echo"<div class=smalltext align=center style='color:red;'>Ошибка при добавлении элемента</div>";
?>


<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
   <td><input type=button onClick=Send('U') value='изменить отмеченные' class=smalltext></td>
   <td width=5></td>
   <td><input type=button onClick=ConfirmSend('D') value='удалить отмеченные'  class=smalltext></td>
 </tr>

 </table>
 </td></tr>
</table>

<center>
<table Border=0 CellSpacing=1 class=bluetable CellPadding=4 width=100%>
  <tr class=lmenutext height=20 align=center bgcolor=#ffffff>
    <td width=20>&nbsp;</td>
    <td><?=SortTitle("Позиция","catalog_pos",$sortby,$sortdir);?></td>
    <td><?=SortTitle("Наименование элемента","page_name",$sortby,$sortdir);?></td>
    <td width="60"><?=SortTitle("Актив.","page_active",$sortby,$sortdir);?></td>
<!--      <td width="180"><?=SortTitle("URL","catalog_URL",$sortby,$sortdir);?></td>
-->
   <?php if ($level<$maxlevel) echo "<td width=40>Подкаталог</td>";
   ?>
    <td width=40>Текст</td>
    <td width=40>SEO</td>
    <td width=30>Фото</td>
  </tr>
<?php
$res=mysql_query ($catalogQuery) or die ("Не могу выбрать элементы каталога. Ошибка в запросе. <BR>".$catalogQuery);
$num_rows=mysql_num_rows($res);  //Количество строк
  if($num_rows)
  {
      $page_quant=ceil($num_rows / $per_page); //всего страниц
      $start_pos=$curr_page*$per_page;
      if ($start_pos+$per_page<$num_rows) $end_pos=$start_pos+$per_page;
         else $end_pos=$num_rows;
      mysql_data_seek($res,$start_pos);
      for ($x=$start_pos; $x<$end_pos; $x++)
      {
         list($catalog_code,$catalog_pos,$catalog_url,$page_code, $page_name, $page_active)=mysql_fetch_array($res);
         $checkname=$page_code;
         if($page_active) {$page_active="да";$bg="#FFFFFF";} else {$page_active="нет";$bg="#EEEEEE";}
         echo"<tr class=edittabletext height=24 bgcolor=$bg>";
         echo"<TD width=20 align=center ><input type='checkbox' name=\"C#$checkname\" id=\"C#$checkname\"></TD>";
         echo"<TD align=center class=smalltext ondblclick='change_line(\"$checkname\",\"F#$checkname#catalog_pos#string\");' id=\"F#$checkname#catalog_pos#string\">".Show($catalog_pos)."</TD>\n";
         echo"<TD align=left class=smalltext ondblclick='change_line(\"$checkname\",\"F#$checkname#page_name#string\");' id=\"F#$checkname#page_name#string\">".Show($page_name)."</TD>\n";
         echo"<TD class=smalltext align=center  ondblclick='change_yes_no(\"$checkname\",\"F#$checkname#page_active#int\");' id=\"F#$checkname#page_active#int\">".Show($page_active)."</TD>\n";
    //     echo"<TD align=center class=smalltext ondblclick='change_line(\"$checkname\",\"F#$checkname#catalog_url#string\");' id=\"F#$checkname#catalog_url#string\">".Show($catalog_url)."</TD>\n";
    //    echo"<TD align=center class=smalltext align=center  ondblclick='change_line(\"$checkname\",\"F#$checkname#static_pos#int\");' id=\"F#$checkname#static_pos#int\">".Show($static_pos)."</TD>\n";
    //     <а href="javascript:toFunction(10,'text')" >Ссылка</а>
         if ($level<$maxlevel)
         echo"<td align=center ><a href='javascript:GotoSub($catalog_code)'><img height='20' width='20' src='graph/subitem.gif' border=0 title='Подкаталог'></a></td>";
         echo"<td align=center ><a href='editstatic.php?page_code=$page_code&page_name=$page_name'><img height='20' width='20' src='graph/edit.gif' border=0 title='Текст страницы'></a></td>";
         echo"<td align=center ><a href='editseo.php?page_code=$page_code&page_name=$page_name'><img height='20' width='20' src='graph/edit.gif' border=0 title='SEO'></a></td>";
         echo"<td><center><a href=\"picture.php?back=statlist&icon=250&page_code=$page_code\"><img height='24' width='24' src='graph/photo.gif' border=0 alt='Фотогалерея ' title='Фотогалерея'></a></td>";
         echo"</TR>\n";
    } //end for x
  } // if num_rows
?>

</table>
</center>

<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 width=95%>
 <tr><td>
 <center>
 <table>
 <tr height=30 >
   <td><input type=button onClick=Send('U') value='изменить отмеченные' class=smalltext></td>
   <td width=5></td>
   <td><input type=button onClick=ConfirmSend('D') value='удалить отмеченные'  class=smalltext></td>
 </tr>
 </table>
 </td></tr>
</table>

<br>
<?php
{
echo"<div align=left class=smalltext><b>Страницы:</b>  ";
for ($i=1;$i<$page_quant+1;$i++)
 {
   $y=$i-1;
   if ($curr_page==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
   echo"<a class=blue href=$PHP_SELF?curr_page=$y&sortby=$sortby&sortdir=$sortdir>$t1 $i $t2|</a>&nbsp";
 }
echo"</div>";
}
?>

</form>
  </td>
    <td width=10></td>
</tr>

</table>
</div>
</center>

</BODY>
</HTML>

