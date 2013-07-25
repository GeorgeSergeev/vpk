<?php
    include("inc/settings.php");


//    if (!intval($page_code)) {header("Location: index.php");die();}
if(!isAllowed("pStaticEdit")) {die("У Вас недостаточно прав для просмотра этой страницы ");}
$err=0;
    if (!empty($oper))
    {
    	$err=0;
     	if (($oper=='I' or $oper=='U') and (isset($page_url)))
    	{
    	 mysql_query("start transaction;");
    	     	 $query="update {$PREFFIX}_page set page_url='$page_url'
    	    	where (page_code=$page_code)";
    	 $result=mysql_query($query) or $err=1;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());
    	}

    	if ($oper=='I' and $err==0)
    	{
    		mysql_query("start transaction;");
    		$query="insert into {$PREFFIX}_static (page_code,static_name,static_text,lang_code,static_abstract)
    		        values($page_code,'".$static_name."','".$static_text.
    		        "',".$langindex.",'".$static_abstract."')";
    		$result=mysql_query($query) or $err=2;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());

    		$static_code=mysql_insert_id();

    		if(!$err)
    		{
    			mysql_query("commit;");
    		}
    		else mysql_query("rollback;");
    	}

    	if ($oper=='U' and $err==0)
    	{
    		mysql_query("start transaction;");

/*    		$stmt_insert = mysqli_prepare($link, "INSERT INTO Persons (FirstName, LastName, Age) (?, ?, ?)");
    		mysqli_stmt_bind_param($stmt_insert, 'ssi', $fname, $lname, $age);
    		foreach ($rows as $value) {
    			$fname = $value['fname'];
    			$lname = $value['lname'];
    			$age = $value['age'];
    			mysqli_stmt_execute($stmt_insert);
    		}
    		mysqli_stmt_close($stmt_insert); */

/*
    		$stmt_update = mysqli_prepare($link, "update consul_static set static_name=? static_text=? static_abstract=? where static_code=?");
    		mysqli_stmt_bind_param($stmt_update, $static_name, $static_text, $static_abstract, $static_code);
    		$result=mysqli_stmt_execute($stmt_update) or $err=3;
    		mysqli_stmt_close($stmt_update);

*/

    		$query="update {$PREFFIX}_static set static_name='".$static_name.
    		       "', static_text='".$static_text.
    		       "',static_abstract='".$static_abstract.
    		       "' where (static_code=$static_code)";
    		$result=mysql_query($query) or $err=3;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());

    		if(!$err)
    		{
    			mysql_query("commit;");
    		}
    		else mysql_query("rollback;");
    	}
    	// Проверяем загружен ли файл

    	if (($_FILES['pdffile']) and ($_FILES["pdffile"]["name"]!=""))
    	{
    		// Если файл загружен успешно, перемещаем его
    		// из временной директории в конечную
    		if ($_FILES["pdffile"]["error"]) $err=5;

    		if(is_uploaded_file($_FILES["pdffile"]["tmp_name"]))
    		{
    		  $dest="../files/".$_FILES["pdffile"]["name"];
    		  move_uploaded_file($_FILES["pdffile"]["tmp_name"], $dest);
	       	  //Добавить в базу URL
    		  mysql_query("start transaction;");
    		  $query="update {$PREFFIX}_static set static_url='$dest'
    		  where (static_code=$static_code)";
    		  $result=mysql_query($query) or $err=4;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());
    	      if(!$err) { mysql_query("commit;");} 	else mysql_query("rollback;");
    		}
    	}


    }

    include ("inc/head.php");

 //   $editorname='static_abstract';
 //   include("inc/editorbig.php");


    $editorname='static_text,static_abstract';
    include("inc/editorbig.php");

?>

<script language = JavaScript>
function Upload()
{
document.data.oper.value='F';
document.data.submit();
}

function makeRequest(url) {
	var httpRequest;

	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		httpRequest = new XMLHttpRequest();
		if (httpRequest.overrideMimeType) {
			httpRequest.overrideMimeType('text/xml');
			// See note below about this line
		}
	}
	else if (window.ActiveXObject) { // IE
		try {
			httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {}
		}
	}

	if (!httpRequest) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}
	httpRequest.onreadystatechange = function() { alertContents(httpRequest); };
	httpRequest.open('GET', url, true);
	httpRequest.send('');

}

function alertContents(httpRequest) {
	if (httpRequest.readyState == 4) {
		if (httpRequest.status == 200) {
			document.getElementById("txtHint").innerHTML="Документ удален";
		} else {
			alert('There was a problem with the delete pdf request.');
		}
	}
}
</script>
<BODY>
<center>

<div class=mainbody>

<? include("inc/top.php");?>


<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
  <tr><td  class=pageline>
     <div class=wmiddletext><a href="main.php">Администрирование сайта</a> &#187; <a href="<?=$_SESSION['pageback']?>"> <?echo"$page_name";?></a></div>
  </td>
   <td width=200 class=pageline>
     <div class=langselect><? include("inc/selectlang.php");?></div>
  </td>
  </tr>
</table>
&nbsp;

<?php
 //if (!empty($oper)) echo $oper.'<BR>';
  $mainquery="SELECT static_code, static_name, static_text,static_abstract,static_url
              FROM  {$PREFFIX}_static
              WHERE (page_code=$page_code) and (lang_code=$langindex)";
//  echo $mainquery.'<br>';
  $mainres=mysql_query($mainquery) or die($mainquery." ".mysql_error());
  $mainnum_rows=mysql_num_rows($mainres);
  $main_action=($mainnum_rows>0) ? "U" : "I";
  list($static_code, $static_name, $static_text, $static_abstract,$static_url)=mysql_fetch_array($mainres);
  $pnq="SELECT page_type,page_name,page_url  FROM  {$PREFFIX}_page WHERE (page_code=$page_code)";
  $pnqres=mysql_query($pnq)or die (mysql_error());
  if (mysql_num_rows($pnqres)>0)
  	list($page_type,$page_name,$page_url)=mysql_fetch_array($pnqres);
  if ($static_name=="") $static_name=$page_name;
?>

<table Border=0 CellSpacing=0 CellPadding=0 class=mainbody>
 <tr valign=top>

  <td width=10></td>
  <? include("inc/leftmenu.php"); ?>
  <td width=10></td>

  <td>

<table class=grayhead Border=0 CellSpacing=0 CellPadding=0>
 <tr class=normaltext>
 <!--  <td ><div ><h4><?=$page_name;?></h4></div></td>  -->
  <td ><div ><h4> Содержание страницы </h4></div></td>
  <td align=right>  </td>
 </tr>
</table>

<center>

<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
<tr><td>&nbsp;</td></tr>
<?php
  if ($err==1) print'<tr><td class=smalltext align=center style="color:red;"> Ошибка обновления сайта производителя</td></tr>';
  if ($err==2) print'<tr><td class=smalltext align=center style="color:red;"> Ошибка добавления описания</td></tr>';
  if ($err==3) print'<tr><td class=smalltext align=center style="color:red;"> Ошибка обновления описания</td></tr>';
  if ($err==4) print'<tr><td class=smalltext align=center style="color:red;"> Ошибка обновления имени файла документации</td></tr>';
  if ($err==5) print'<tr><td class=smalltext align=center style="color:red;"> Ошибка загрузки файла документации</td></tr>';
?>
      <tr><td class=lmenutext align=center> <a href="<?=$_SESSION["pageback"]?>">[ назад ]</a><br>
</table>


<form name=data action=<?=$PHP_SELF;?> method=POST enctype="multipart/form-data">
     <input type=hidden name=oper value='<?=$main_action?>'>
     <input type=hidden name=page_code value=<?=$page_code;?>>
     <input type=hidden name=page_name value=<?=$page_name;?>>
     <input type=hidden name=langindex value=<?=$langindex;?>>

     <?php
      if ($mainnum_rows>0) echo' <input type=hidden name=static_code value='.$static_code.'>';
     ?>

<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
 <tr><td height=10></td></tr>
 <tr>
  <td bgcolor=#f9f9f9 style='padding:10px'>
  <center><input type=submit class=smalltext value='сохранить изменения'></center>
  <table Border=0 CellSpacing=0 CellPadding=0 width=100%>
     <tr><td class=lmenutext><a>Заголовок страницы  [<?=$langname;?>] :</a><br>
       <input type=text name='static_name' style="width:100%;" value="<?=$static_name; ?>"><p>
     </td></tr>
     <?php
       if ($page_type!="static")  {
        print '<tr><td class=lmenutext>Аннотация  ['.$langname.']:<br>';
        print '<textarea name="static_abstract" style="width:100%;height:200px;">'. $static_abstract.'</textarea><p>';
        print '</td></tr>';
       }
      ?>
     <tr><td class=lmenutext>Текст страницы  [<?=$langname;?>]:<br>
       <textarea name='static_text' style="width:100%;height:400px;"> <?=$static_text;?> </textarea><p>
     </td></tr>
     <?php
     if (($page_type!="static")&&($page_type!="department"))  {
         print '<tr><td class=lmenutext>';
         $labeltext='Ссылка на внешнюю страницу:';
         if ($page_type=="catalog") $labeltext='Ссылка на сайт производителя:';
         print $labeltext;
         print '<br> <input type="text" name="page_url" style="width:550px;" value="'.$page_url.'"><p>';
         print '</td></tr>';
     }
     if ($page_type=="catalog")
     {
     	print '<tr><td class=lmenutext > Файл документации:  <span id="txtHint">'.$static_url.'</span>';
     	if ($static_url!="")
     	{
     	print ' &nbsp <input type="button" type=button class=smalltext onClick=makeRequest("deletepdf.php?static_code='.$static_code;
    	print '") value="Удалить документ">';}
    	print '<br>';
     	print '<input type=file style="width:300px" name="pdffile">';
     }
     ?>

  </table>
  </td>
 </tr>
 <tr><td bgcolor=#f9f9f9 ><center><input type=submit class=smalltext value='сохранить изменения'></td></tr>
 <tr><td height=10 bgcolor=#f9f9f9 height=0></td></tr>
 <tr><td height=10 height=0></td></tr>
</table>
 </form>

<table Border=0 CellSpacing=0 CellPadding=0 width=650>
 <tr><td height=10></td></tr>
     <tr><td class=lmenutext align=center><a href="<?=$_SESSION["pageback"]?>">[ назад ]</a><br><br>
</table>

</center>

  </td>
    <td width=10></td>
</tr>

</table>
</div>
</center>

</BODY>
</HTML>
