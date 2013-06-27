<?php
include("inc/settings.php");
$static_code=$_GET['static_code'];
$err=0;
mysql_query("start transaction;");
$query="update {$PREFFIX}_static set static_url=''
where (static_code=$static_code)";
$result=mysql_query($query) or $err=4;//die("Не могу добавить страницу:<br>$query<br>".mysql_error());
if(!$err) { mysql_query("commit;");} 	else mysql_query("rollback;");
?>