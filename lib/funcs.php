<?

function get_lang_code($lang_name){
	$sql="select language_code from vpk_language where language_name='$lang_name'";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	$cnt = mysql_num_rows($do_get);
	if (!$cnt) return 1;
	$rez=mysql_fetch_array($do_get);
	return  $rez[0];
}




function get_page_by_name($name){
	global $LANG_CODE;
	$sql="select vpk_static.static_text,vpk_static.static_name from  vpk_static
	inner join vpk_page on  vpk_page.page_code=vpk_static.page_code
	where page_name='$name' and vpk_static.lang_code='$LANG_CODE'";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	return mysql_fetch_assoc($do_get);
}	




function get_solutions_li(){
	global $LANG_CODE;
	$sql="select vpk_static.static_name, vpk_solutions.solutions_code from  vpk_static
	inner join vpk_page on  vpk_page.page_code=vpk_static.page_code
	inner join vpk_solutions on  vpk_solutions.page_code=vpk_static.page_code
	where vpk_page.page_active='1' and vpk_static.lang_code='$LANG_CODE' order by solutions_pos";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	$cnt = mysql_num_rows($do_get);	

	for($i=0;$i<$cnt;$i++){
 		$sol = mysql_fetch_assoc($do_get);
		$li.="<li><a href='solutions.php?id=${sol['solutions_code']}'>".stripcslashes($sol['static_name'])."</a></li>";
 	}	
 	return '<ul>'.$li.'</ul>';
}


function get_images($page_code, $count=1){
	global $LANG_CODE;
	$sql="select * from vpk_picture
	where page_code=$page_code and language_code='$LANG_CODE' order by picpos";
	if ($count) $sql.=" LIMIT $count ";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	$cnt = mysql_num_rows($do_get);	
	for($i=0;$i<$cnt;$i++){
 		$pics[] = mysql_fetch_assoc($do_get);
 	}	
 	return $pics;
}	



function get_page_by_id($id){
	global $LANG_CODE;
	$sql="select vpk_static.static_text,vpk_static.static_name from  vpk_static
	inner join vpk_page on  vpk_page.page_code=vpk_static.page_code
	where vpk_page.page_code='$id' and vpk_static.lang_code='$LANG_CODE'";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	return mysql_fetch_assoc($do_get);
}


function get_page_by_catalog_id($id){
	global $LANG_CODE;
	$sql="select vpk_page.page_code  from  vpk_page
	inner join vpk_catalog on  vpk_page.page_code=vpk_catalog.page_code
	where catalog_code='$id' ";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	$pg=mysql_fetch_assoc($do_get);
	return get_page_by_id($pg['page_code']);
}





function get_page_seo_by_name($name){
	global $LANG_CODE;
	$sql="select vpk_static.static_seo_title,vpk_static.static_seo_desc,vpk_static.static_seo_key from  vpk_static
	inner join vpk_page on  vpk_page.page_code=vpk_static.page_code
	where page_name='$name' and vpk_static.lang_code='$LANG_CODE'";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	return mysql_fetch_assoc($do_get);
}	



function get_categories_li($parent_id=0,$max_levels=5,$current_level=1){
	global $LANG_CODE;
	if ($current_level>=$max_levels) return '';
	$sql="select vpk_static.static_name, vpk_catalog.catalog_code from vpk_catalog 
	inner join vpk_page on  vpk_page.page_code=vpk_catalog.page_code
	inner join vpk_static on  vpk_static.page_code=vpk_catalog.page_code
	where vpk_page.page_active='1' and catalog_parent=$parent_id  and vpk_static.lang_code=$LANG_CODE order by catalog_pos";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	$cnt = mysql_num_rows($do_get);

	for($i=0;$i<$cnt;$i++){
 		$cat = mysql_fetch_assoc($do_get);
 		$children=get_categories_li($cat['catalog_code'],$max_levels,++$current_level);
 		if ($children){
 			$li.="<li><a href='#'>".stripcslashes($cat['static_name'])."</a>$children</li>";
 		}else{
 			$li.="<li><a href='catalog.php?id=${cat['catalog_code']}'>".stripcslashes($cat['static_name'])."</a></li>";
 		}
 		
	}
	return isset($li)?'<ul>'.$li.'</ul>':'';
}


function get_news($count){
	global $LANG_CODE;
	$sql="select vpk_static.static_name, vpk_static.static_abstract, vpk_news.news_code, vpk_news.news_date, vpk_page.page_code from  vpk_static
	inner join vpk_page on  vpk_page.page_code=vpk_static.page_code
	inner join vpk_news on  vpk_news.page_code=vpk_static.page_code
	where vpk_page.page_active='1' and vpk_static.lang_code='$LANG_CODE' order by news_date desc LIMIT $count";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	$cnt = mysql_num_rows($do_get);	

	for($i=0;$i<$cnt;$i++){
 		$d = mysql_fetch_assoc($do_get);
 		$img=get_images($d['page_code']);
 		$d['img_src']=$fotoalb_path.$img[0]['picsmall'];
		$news[]=$d;
 	}	
 	return $news;
}




function get_all_data($table,$count=1,$order='',$where=''){
	global $LANG_CODE;
	global $fotoalb_path;
	global $PREFIX;
	$table_name=$PREFIX.$table;
	$order=($order)?' ORDER BY '.$order : "";
	$where=($where)?' and '.$where : "";
	$sql="select vpk_static.static_name, vpk_static.static_abstract, vpk_static.static_text, vpk_static.page_code, $table_name.* from  vpk_static
	inner join vpk_page on  vpk_page.page_code=vpk_static.page_code
	inner join $table_name on  $table_name.page_code=vpk_page.page_code
	where vpk_page.page_active='1' and vpk_static.lang_code='$LANG_CODE' $where $order  LIMIT $count";
	$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
	$cnt = mysql_num_rows($do_get);	

	for($i=0;$i<$cnt;$i++){
 		$d = mysql_fetch_assoc($do_get);
 		$img=get_images($d['page_code']);
 		$d['img_src']=$fotoalb_path.$img[0]['picsmall'];
 		$data[]=$d;

 	}	
 	return $data;
}


/*
function extract_lang_str($str){
  $str=explode(';',$str);
  if(count($str)>1)
    $str=($_SESSION['lang'])?$str[1]:$str[0];
  else
    $str=$str[0];

  return $str;
}
*/
?>