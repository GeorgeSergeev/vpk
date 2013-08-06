<?php

    foreach($_REQUEST as $var=>$val) $$var=$val;
    $PHP_SELF=$_SERVER['PHP_SELF'];

    $link = mysql_connect ("db14.freehost.com.ua", "vpkplus_vpk", "cUwSuo5gD") or die ("Could not connect");
    $base=mysql_select_db ("vpkplus_vpk");

    mysql_query("SET NAMES utf8");
?>