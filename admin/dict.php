<?php
include("inc/settings.php");
$per_page=30;
$oper=$_POST['oper'];

if(!isAllowed("pDictionaryEdit")) {die("У Вас недостаточно прав для просмотра этой страницы");}

if(!($sortby)) $sortby='essential_name'; else {$sortby=explode(" ",$sortby);$sortby=$sortby[0];}

if(!isset($sortdir)) {$sortdir="";$realsortdir="ASC"; }
else if(!intval($sortdir)) {$sortdir="";$realsortdir="ASC";} else {$sortdir="1";$realsortdir="DESC";}


$essentialquery="select * 
            from {$PREFFIX}_essential
            order by $sortby $realsortdir";
//echo $mainquery;
if (!empty($oper))
{
$essential=mysql_real_escape_string($essential);	
if ($oper=='I')
{
 $err=0;
mysql_query("start transaction;");
$query="insert into {$PREFFIX}_essential values (0,'$essential')";
$result=mysql_query($query) or $err=1;//die("Не могу добавить фразу:".mysql_error());
$newunitcode=mysql_insert_id();
if(!$err)
  {
      mysql_query("commit;");
    //для постраничного-------------------------------------------------------------
     $result=mysql_query($essentialquery) or die("Incorrect Currpage Query") ;
     $num_compl=mysql_num_rows($result);
     for($i=0;$i<$num_compl;$i++)
            if (mysql_result($result,$i,0)==$newunitcode) break;
     $curr_page=ceil($i/$per_page)-1;
     if ($curr_page==-1) $curr_page=0;
    //------------------------------------------------------------------------------
  }
  else mysql_query("rollback;");

}

if ($oper=="D")
{
/*	
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

         $query = "delete from {$PREFFIX}_dict where dict_code=$varCode";
         $resultdel = mysql_query($query) or $err+=10;
      }
  }
*/
}//oper=D

if (!strcasecmp($oper,"U"))
{
/*	
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
         if ($varType=="string") $tmp="'"; else $tmp="";
         $sqlupd = "update {$PREFFIX}_dict set $varField=$tmp".$value."$tmp  where dict_code=$varCode";
//         echo"$sqlupd";
            $resultupd = MYSQL_QUERY($sqlupd) or $err-=10;
         if ($varField=="dict_name") $flag=1;

      }//if ($varName=="F")
    }
  }//while
}//if  (UPD)
   if($sortby) $tmp="&sortby=$sortby&sortdir=$sortdir"; else $tmp="";
   header("Location: $PHP_SELF?err=$err$tmp");
 */  
}//empty
?>



<? include ("inc/head.php"); ?>

<script language = JavaScript>
function Send(a)
{
document.data.oper.value=a;
document.data.submit();
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
if (confirm('Вы уверены, что хотите удалить тему в раделе "Частые вопросы"?'))
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
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> &#187; <a href="dict.php">Словарь</a></div>
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
echo"<input type=hidden name=sortby value=\"$sortby\">";
echo"<input type=hidden name=sortdir value=\"$sortdir\">";
?>

<table class=grayhead Border=0 CellSpacing=0 CellPadding=0 >
 <tr class=normaltext>
  <td ><div ><h4>Словарь</h4></div></td>
  <td align=right class=wmiddletext><a class=submenu onclick="displayform(this,'добавить фразу')">добавить фразу</a></td>
 </tr>
</table>

<div id=addform>
<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0>
 <tr><td colspan=3 bgcolor=#ffffff height=10></td></tr>
 <tr><td colspan=10 class=blueheadcolor><center><div class=normaltext>ДОБАВИТЬ ФРАЗУ</div></center></td></tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr><td>
 <center>
 <table cellpadding=2  cellspacing=0>
 <tr height=30 >
    <td class=lmenutext>На русском:</td>
    <td width=5></td>
    <td><input name='dict_ru' type=text style="width:250px" class=smalltext></td>
 </tr>
 <tr height=30 >
    <td class=lmenutext>На английском:</td>
    <td width=5></td>
    <td><input name='dict_en' type=text style="width:250px" class=smalltext></td>
 </tr>
 </table>
 </td>

 <td class=helpzone>

     <table Border=0 CellSpacing=1 CellPadding=0 bgcolor=#999999 class=helptable>
       <tr>
        <td class=helptd>

             <div class=ssmalltext>
                Заполните поля формы и нажмите кнопку "добавить фразу". </a>
             </div>

        </td>
       </tr>
     </table>

 </td>


 </tr>
 <tr><td colspan=3 height=1 bgcolor=#ffffff></td></tr>
 <tr><td colspan=10 id=blueheadcolor><center><input type=button onClick=Send('I') value='добавить фразу'  class=smalltext></td></tr>
</table>
</div>


<table Border=0 CellSpacing=0 class=pagebluetable CellPadding=0 >
 <tr><td class=lmenutext height=30 bgcolor=#ffffff align="center">ФРАЗУ В СЛОВАРЕ</td></tr>
</table>

<?php
 if(intval($err)<=-10) echo"<div class=smalltext align=center style='color:red;'>Ошибка при изменении фразы</div>";
 if(intval($err)>=10) echo"<div class=smalltext align=center style='color:red;'>Ошибка при удалении фразы</div>";
 if(intval($err)==1) echo"<div class=smalltext align=center style='color:red;'>Ошибка при добавлении фразы</div>";

$resEssential=mysql_query ($essentialquery) or die ("Не могу выбрать фразы. Ошибка в запросе.");
  $num_rows=mysql_num_rows($resEssential);
  if($num_rows)
  {
      $page_quant=ceil($num_rows / $per_page); //всего страниц
  }

if ($page_quant>1)
{
echo"<div align=left class=smalltext><b>Страницы:</b>  ";
for ($i=1;$i<$page_quant+1;$i++)
 {
   $y=$i-1;
   if ($curr_page==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
   echo"<a class=blue href=$PHP_SELF?curr_page=$y&sortby=$sortby&sortdir=$sortdir>$t1 $i $t2|</a>&nbsp";
 }
echo"</div><br>";
}

$dictionaryQuery="SELECT {$PREFFIX}_essential.essential_code,{$PREFFIX}_essential.essential_name,{$PREFFIX}_dictionary.dictionary_code,
				  {$PREFFIX}_dictionary.language_code,{$PREFFIX}_dictionary.dictionary_translate FROM {$PREFFIX}_essential
				  LEFT JOIN {$PREFFIX}_dictionary ON {$PREFFIX}_essential.essential_code = {$PREFFIX}_dictionary.essential_code";
$resDictionary=mysql_query ($dictionaryQuery) or die ("Не могу выбрать перевод фраз. Ошибка в запросе $dictionaryQuery");
$num_Dict=mysql_num_rows($resDict);				  
$langQuery="SELECT {$PREFFIX}_language.language_code, {$PREFFIX}_language.language_name FROM {$PREFFIX}_language";
$resLang=mysql_query ($langQuery) or die ("Не могу выбрать перечень языков. Ошибка в запросе $langQuery");
$num_lang=mysql_num_rows($resLang);
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


<table Border=0 CellSpacing=1 class=bluetable CellPadding=4 width=100%>
  <tr class=lmenutext height=20 align=center bgcolor=#ffffff>
    <td width=20>&nbsp;</td>
    <td width=50><?=SortTitle("Код","essential_code",$sortby,$sortdir);?></td>
    <?php  
	for ($i=1;$i<$num_lang+1;$i++)
 	{ list($language_code,$language_name)=mysql_fetch_array($res);
 	  echo " <td>$language_name </td>";    	       	
 	}   
 	?> 
  </tr>

<?php
  if($num_rows)
  {
      $page_quant=ceil($num_rows / $per_page); //всего страниц
    $start_pos=$curr_page*$per_page;
    if ($start_pos+$per_page<$num_rows) $end_pos=$start_pos+$per_page;
       else $end_pos=$num_rows;
    mysql_data_seek($res,$start_pos);
    for ($x=$start_pos; $x<$end_pos; $x++)
    {
    

    $checkname=$dict_code;
    echo"<tr class=edittabletext height=24 bgcolor=#ffffff>";
    echo"<TD width=20 align=center ><input type='checkbox' name=\"C#$checkname\" id=\"C#$checkname\"></TD>";
    echo"<TD class=smalltext width=40 align=center >$dict_code</TD>";
    echo"<TD class=smalltext ondblclick='change_line(\"$checkname\",\"F#$checkname#dict_ru#string\");' id=\"F#$checkname#dict_ru#string\">".Show($dict_ru)."</TD>\n";
    echo"<TD class=smalltext ondblclick='change_line(\"$checkname\",\"F#$checkname#dict_en#string\");' id=\"F#$checkname#dict_en#string\">".Show($dict_en)."</TD>\n";
    echo"</TR>\n";
    } //end for x
  } // if num_rows
?>

</table>

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
