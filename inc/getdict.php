<?php

$langquery="select  dict_ru, dict_en from consul_dict  order by dict_ru";
$langres=mysql_query($langquery) or die($langquery);
while (list($dict_ru,$dict_en)=mysql_fetch_array($langres))
{
	$dict[$dict_ru]= $dict_en;
}

?>