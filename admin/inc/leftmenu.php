
<td class=leftpanel >

<table CellSpacing=0 CellPadding=0 >
<tr><td class=bluehead><h4>Навигация</h4><td></tr>
<tr><td class=blueblock style='height:280px;' valign=top>
<div style="margin-left:20px">

<?php

if( (isAllowed("pAdmin")) || (isAllowed("pStaticTextEdit")) )
{
echo"<p><div class=lmenupart><b>Администрирование</b></div>";
if( isAllowed("pAdmin"))
		echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"admin.php\">Управление доступом</a></b></div>";
if( isAllowed("pStaticTextEdit"))
  {
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"dict.php\">Словарь</a></b></div>";
    echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"textpage.php\">Текстовые страницы</a></b></div>";
  }
}


if(isAllowed(("pNewsEdit")) || (isAllowed("pPartnerEdit")) || (isAllowed("pCatalogEdit")))
{
	echo "<p><div class=lmenupart><b>Деятельность</b></div>";
	if (isAllowed("pNewsEdit")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"newspage.php\"> Новости </a></b></div>";
	if (isAllowed("pCatalogEdit")) {echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"catalogpage.php\">Каталог</a></b></div>";
	                                echo "<div class=lmenupart>&#187;&nbsp; <b><a href=\"designepage.php\">Проектные решения</a></b></div>";
	}
	if (isAllowed("pPartnerEdit")) echo"<div class=lmenupart>&#187;&nbsp; <b><a href=\"partnerpage.php\">Партнеры</a></b></div>";
}

if (isAllowed("pCatalogEdit"))
{	
  echo "<p><div class=lmenupart><b>Каталог</b></div>";
  echo "<div class=jquery-tree>";
   if (isAllowed("requipment"))  view_tree(1);
  echo "</div>";
}
?>

</div>
<br>


<td></tr>
</table>
&nbsp;
 <td>

