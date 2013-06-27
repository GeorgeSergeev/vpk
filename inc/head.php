<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>

   <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>

   <base href="<?=$mainurl;?>/">

<?
if (strlen($meta_title)>0)  echo"<title>$meta_title</title>\n";
else echo"<title>Consul</title>\n";

if (strlen($meta_desc)>0) echo"<META NAME='Description' CONTENT='$meta_desc'>\n";
else echo"<META NAME='Description' CONTENT=''>\n";

if (strlen($meta_key)>0) echo"<META NAME='Keywords' CONTENT='$meta_key'>\n";
else echo"<META NAME='Keywords' CONTENT=''>\n";
?>

   <link rel=stylesheet href="css/styles.css" type="text/css">
   <link href="css/lightbox.css" rel="stylesheet" />

   <script language="JavaScript" src='js/common.js'></script>

</head>

