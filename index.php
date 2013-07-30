<?
require_once "dbconnect.php";


$page=get_page_by_name('Главная');
$seo=get_page_seo_by_name('Главная');

$btpl->set('title',($seo['static_seo_title'])? $seo['static_seo_title'] : $page['static_name']);

if($seo['static_seo_key'])  $btpl->set('keywords',$seo['static_seo_key']);
if($seo['static_seo_desc'])  $btpl->set('descr',$seo['static_seo_desc']);

$btpl->set('navigation_line','Главная страница');


$btpl->set('content','<h1>Извините, сайт находится в разработке!</h1>');

echo $btpl->fetch('tmpl/main.tmpl.html');
?>