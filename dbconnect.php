<?php
session_start();
error_reporting (E_ALL^E_NOTICE);
require 'dbconf.inc';
$root_http ='http://'.$_SERVER['HTTP_HOST'];
$fotoalb_path='images/';
$file_path='files/';
$PREFIX='vpk_';

$cnx = @mysql_connect($host, $dbuser, $dbpass) or die("
<br><font face='Times' size='2' color='red'><center><b>Cannot connect to the database at the current time.</b></center>" . mysql_error());
mysql_select_db($dbname)or die("
<br><font face='Times' size='2' color='red'><center><b>Cannot select the database at the current time.</b></center>" . mysql_error());
mysql_query("SET NAMES 'utf8'");


require_once "lib/bTemplate.php";
$btpl = new bTemplate;


require_once "lib/funcs.php";

if(!isset($_SESSION['lang'])) $_SESSION['lang']='ru';

if(($_SESSION['lang']!='ru')||($_SESSION['lang']!='eng')) $_SESSION['lang']='ru';

$_SESSION['lang']=$_REQUEST['lang'];


$LANG_CODE = get_lang_code($_SESSION['lang']);


$partners=get_all_data('partner', 20 , 'partner_pos', 'partner_onmain=1');

$btpl->set('partners',$partners);
$btpl->set('partners_block',$btpl->fetch('tmpl/partners.tmpl.html'));


$btpl->set('keywords','компания ВПК, мониторнинг транспорта, технический мониторинг');
$btpl->set('descr','описание по умолчанию');


$btpl->set('catalog_li',get_categories_li());
$btpl->set('catalog_li_left',get_categories_li(0,4));

$pg=get_page_by_name('Контактная информация');
$btpl->set('contacts',$pg['static_text']);

$btpl->set('solutions_li',get_solutions_li());





/*
$req=parse_url($_SERVER['REQUEST_URI']);
parse_str($req['query'],$params);
$params['lang']='en';
$btpl->set('ua_link','http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?".http_build_query($params));
$params['lang']='ru';
$btpl->set('ru_link','http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?".http_build_query($params));
*/

$btpl->set('in_head','');



?>
