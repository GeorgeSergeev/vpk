<?php

    foreach($_REQUEST as $var=>$val) $$var=$val;
    $PHP_SELF=$_SERVER['PHP_SELF'];

    $link = mysql_connect ("localhost", "root", "") or die ("Could not connect");
    $base=mysql_select_db ("vpk_base");

    mysql_query("SET NAMES utf8");
?>