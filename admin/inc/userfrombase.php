<?php
  $query="select * from {$PREFFIX}_admin
            where binary admin_login='".htmlspecialchars($_POST['login'],ENT_QUOTES)."' and binary admin_password=MD5('".$_POST['password']."') and admin_active=1";
  $res=@mysql_query($query) or die("Cannot Extract User:$query<br>".mysql_error());
 
  if (mysql_num_rows($res)!=0)  
  {
   $REGUSER["code"]=mysql_result($res,0,"admin_code");
   $REGUSER["name"]=mysql_result($res,0,"admin_name");
   $REGUSER["login"]=mysql_result($res,0,"admin_login");
   $REGUSER["pass"]=mysql_result($res,0,"admin_password");
   $REGUSER["email"]=mysql_result($res,0,"admin_email");

// --------------- права -------------------------------------------------------
   $permQuery="SELECT  {$PREFFIX}_permission.permission_name  FROM  {$PREFFIX}_permission
   INNER JOIN {$PREFFIX}_admins_permission ON {$PREFFIX}_permission.permission_code = {$PREFFIX}_admins_permission.permission_code
   INNER JOIN {$PREFFIX}_admin ON {$PREFFIX}_admin.admin_code = {$PREFFIX}_admins_permission.admin_code
   WHERE {$PREFFIX}_admin.admin_code=".$REGUSER["code"];
   $permRes=@mysql_query($permQuery) or die("Cannot Extract permission :$permQuery<br>".mysql_error());
   $USER_PERMISSIONS='';
   while($row = mysql_fetch_array($permRes)) {
       $USER_PERMISSIONS.=$row['permission_name'].';';
       if (strlen($USER_PERMISSIONS)>0)  
            $USER_PERMISSIONS.="pStaticEdit;"; 
   }
   $REGUSER["permissions"]=$USER_PERMISSIONS;
// -----------------------------------------------------------------------------

   unset($_SESSION["REGUSER"]);
   $_SESSION["REGUSER"]=$REGUSER;
  } else unset($REGUSER);
?>
