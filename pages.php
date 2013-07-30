<?
require_once "dbconnect.php";


$id= isset($_REQUEST['id'])? $_REQUEST['id']:1;

$sql="select * from pages where pages_id=".$id;
$do_get = mysql_query($sql)or die("Ошибка выполнения запроса!!!". mysql_error().$sql);
$cnt = mysql_num_rows($do_get);
if($cnt){
 $page = mysql_fetch_assoc($do_get);
 }
else{
  header("Location: index.php"); 
  exit;
} 

$btpl->set('main_content',$page["pages_body".$_SESSION['lang']]);
$btpl->set('content',$btpl->fetch('tmpl/one_col_container.tmpl.html'));


$btpl->set('title',$page['pages_name'.$_SESSION['lang']]);
$btpl->set('keywords','');
$btpl->set('descr','');
if ($_REQUEST['id']<=6)	$part=($_SESSION['lang'])?'Про компанію':'О компании';
else $part=($_SESSION['lang'])?'Тваринництво':'Животноводство';

$btpl->set('navigation_line',"<div id='navigation_line'>$part - ".$page['pages_name'.$_SESSION['lang']]." </div>");


echo $btpl->fetch('tmpl'.$_SESSION['lang'].'/main.tmpl.html');

?>