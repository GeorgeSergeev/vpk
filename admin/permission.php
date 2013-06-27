<?php
	include("inc/settings.php");

	if(!isAllowed("pAdmin")) {die("У Вас недостаточно прав для просмотра этой страницы");}
	if (!intval($admin_code)) {die("Ошибка: администратор не задан");}
	list($admin_name,$admin_login)=mysql_fetch_array(mysql_query("select admin_name,admin_login from {$PREFFIX}_admin where admin_code=$admin_code")  );
	$oper=$_POST['oper'];
	if (!empty($oper)) {
        mysql_query("start transaction;");
		$delete_permission_query="delete from  {$PREFFIX}_admins_permission where admin_code=$admin_code";
		$result=mysql_query($delete_permission_query) or die($err=1);//"Не могу обновить права:<br>$insert_permission_query<br>".mysql_error());		
        $err=0;
        $admin_c=$_POST["admin_code"];
        foreach($_POST as $permission_code=>$val) if($val=="on") {
        	$permission_code=ltrim($permission_code,"p");
        	$insert_permission_query="insert into {$PREFFIX}_admins_permission (permission_code,admin_code) values ($permission_code,$admin_code)";
        	$result=mysql_query($insert_permission_query) or die($err=1);//"Не могу обновить права:<br>$insert_permission_query<br>".mysql_error());
        }
        if(!$err) mysql_query("commit;");        
            else mysql_query("rollback;");               
        header("Location: $PHP_SELF?admin_code=$admin_code");
    }
    $admin_permission_query="select permission_code  from {$PREFFIX}_admins_permission   where admin_code=$admin_code";
    $admin_permission_res=mysql_query($admin_permission_query) or dye("Ошибка в запросе ".$admin_permission_query);
    $admin_permission_codes=array();
    while ($row = mysql_fetch_assoc($admin_permission_res)) {
     array_push($admin_permission_codes,$row['permission_code']);    	
    }       
    $permission_query="select permission_code, permission_name, permission_comment   from {$PREFFIX}_permission";
    $permission_res=mysql_query($permission_query);
?>



<? include ("inc/head.php"); ?>

<script language = JavaScript>
function Send(a)
{
document.permission_edit.oper.value=a;
document.permission_edit.submit();
}
</script>

<BODY>

<table Border=0 CellSpacing=0 CellPadding=0 width=100%>
  <tr> <td class=pageline>
     	<div class=wmiddletext><a href="main.php">Администрирование сайта</a> &#187; <a href='admin.php'>Управление доступом </a></div>
  		</td>
  </tr>
</table>
<table Border=0 CellSpacing=0 CellPadding=0 class=mainbody>
 <tr valign=top>
   <td width=10></td>
  <? include("inc/leftmenu.php"); ?>
  <td width=10></td>
  <td>
 
 
	<table class="grayhead">  
  	<tr class="normaltext">
  			<td > 
  			    <div><h4>Редактирование прав доступа для администратора <?=$admin_name?> (Логин : "<?=$admin_login?>") </h4> </div>
  			</td>
  	</tr>  	
	</table>
	<BR>

	<?php
		$formout="<form name='permission_edit' action=$PHP_SELF method=POST>";
		$formout.="<input type=hidden name='oper' value=''>";
		$formout.="<input type=hidden name=admin_code value=\"$admin_code\">";
		echo $formout;
	?>
	 <?php
 		   $tableout="<table class=bluetable width=100%>";
		   while ($row = mysql_fetch_assoc($permission_res)) {
				 $permission_code=$row['permission_code'];
  				 $tableout.="<tr>";
   				 $tableout.="<td> <input type='checkbox' name='ppp".$permission_code."'";
  				 if ((count ($admin_permission_codes)>0) && (in_array($permission_code,$admin_permission_codes))) $tableout.="checked";
  				 $tableout.="> </td>  <td class='smalltext'>". $row['permission_comment']."</td> </tr>";
				}
			$tableout.="</table>";
			echo $tableout;			
		 ?>
		<BR> 
		<table Border=0  class=pagebluetable>
 			<tr height=30>
 				<td align="left">  <input type=button onClick=Send('I') value='сохранить изменения'  class=smalltext></td>
 			</tr>
 		</table>
 		</form>
   </td>
  </tr>
</table>   
</BODY>
</HTML>
