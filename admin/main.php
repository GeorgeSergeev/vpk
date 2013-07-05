<?php
include("inc/settings.php");
include ("inc/head.php");
$_SESSION["pageback"]="main.php";
?>

<BODY>
<center>

<div class=mainbody>

<?php include("inc/top.php"); ?>

<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
  <tr><td class=pageline>
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> </div>
  </td></tr>
</table>
&nbsp;

<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
 <tr valign=top>

  <td width=10></td>
  <? include("inc/leftmenu.php"); ?>
  <td width=10></td>

  <td>


<table Border=0 CellSpacing=0 CellPadding=0 Width=100%>
 <tr align=cener valign=top>
     <td width=48%>

<?php
if( (isAllowed("pAdmin")) || (isAllowed("pStaticTextEdit")) ) {
 echo"
     <table class=grayhead Border=0 CellSpacing=0 CellPadding=0>
     <tr colspan=10 class=normaltext><td ><div ><h4>Администрирование</h4></div></td></tr>
     </table>
     <table Border=0 CellSpacing=15 CellPadding=0>
     <tr class=middletext align=center valign=top>";
     if (isAllowed("pAdmin")) echo"<td><a href=\"admin.php\"><img hspace=20 b src=\"graph/newicon/admin.png\"  border=0><p class=\"space\">управление<br>доступом</a></td>";
     if (isAllowed("pStaticTextEdit"))
        {
          echo"<td><a href=\"dict.php\"><img src=\"graph/newicon/lang.png\"  hspace=20 border=0><p class=\"space\">словарь</a></td>";
          echo"<td><a href=\"textpage.php\"><img src=\"graph/newicon/page.png\"  hspace=20 b border=0><p class=\"space\">текстовые<br>страницы</a></td>";
        }
    echo"
    </tr>
   </table>
   &nbsp;";
}

if(isAllowed("pNewsEdit") || isAllowed("pPartnerEdit") || isAllowed("pCatalogEdit")||isAllowed("pSolutionEdit"))
{
    echo"
 		<table class=grayhead Border=0 CellSpacing=0 CellPadding=0>
 			<tr colspan=10 class=normaltext><td ><div ><h4>Деятельность</h4></div></td></tr>
		</table>
		<table Border=0 CellSpacing=15 CellPadding=0>
 		<tr class=middletext align=center valign=top>";

		if (isAllowed("pNewsEdit")) echo "<td><a href=\"newspage.php\"><img src=\"graph/newicon/news.png\" hspace=20 border=0><p class=\"space\">Новости</a></td>";
		if (isAllowed("pCatalogEdit")) 
			echo "<td><a href=\"catalogpage.php\"><img src=\"graph/icon/equipment.gif\"  hspace=20 border=0><p class=\"space\">Каталог</a></td>";			
		if (isAllowed("pSolutionEdit")) echo "<td><a href=\"solutions.php\"><img src=\"graph/icon/designe.gif\"  hspace=20 border=0><p class=\"space\">Проектные решения</a></td>";
		if (isAllowed("pPartnerEdit")) echo"<td ><a href=\"partnerpage.php\"><img src=\"graph/newicon/rooms.png\"  hspace=20 border=0><p class=\"space\">Партнеры</a></td>";
	echo "</tr></table></center>" ;
}

?>

     </td>

     <td width=4%>&nbsp;</td>

     <td width=48%>

<!--



-->

 </td>
 </tr>
</table>






  </td>
  <td width=10></td>



</tr>

</table>
</div>
</center>

</BODY>
</HTML>
