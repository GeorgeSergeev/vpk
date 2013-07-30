<?
require_once "dbconnect.php";

if (!isset($_REQUEST['id']))$_REQUEST['id']=1;

$page=get_page_by_catalog_id($_REQUEST['id']);

$seo=get_page_seo_by_name('Главная');

$btpl->set('title',($seo['static_seo_title'])? $seo['static_seo_title'] : $page['static_name']);

if($seo['static_seo_key'])  $btpl->set('keywords',$seo['static_seo_key']);
if($seo['static_seo_desc'])  $btpl->set('descr',$seo['static_seo_desc']);

$btpl->set('navigation_line','Товары и услуги - '.$page['static_name']);

$btpl->set('block_content',$page['static_text']);
$pg=$btpl->fetch('tmpl/block.tmpl.html');


$btpl->set('content',$pg);

echo $btpl->fetch('tmpl/main.tmpl.html');



?>