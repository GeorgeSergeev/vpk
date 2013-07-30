<?
require_once "dbconnect.php";


$page=get_page_by_name('Главная');
$seo=get_page_seo_by_name('Главная');

$btpl->set('title',($seo['static_seo_title'])? $seo['static_seo_title'] : $page['static_name']);

if($seo['static_seo_key'])  $btpl->set('keywords',$seo['static_seo_key']);
if($seo['static_seo_desc'])  $btpl->set('descr',$seo['static_seo_desc']);

$btpl->set('navigation_line','Главная страница');

$btpl->set('block_content',$page['static_text']);
$pg=$btpl->fetch('tmpl/block.tmpl.html');

$btpl->set('news',get_all_data('news',5,' vpk_news.news_date desc '));
$news=$btpl->fetch('tmpl/news_list.tmpl.html');

$btpl->set('solutions',get_all_data('solutions',3,' vpk_solutions.solutions_pos '));
$sols=$btpl->fetch('tmpl/solutions.tmpl.html');


$btpl->set('content',$pg.$news.$sols);

echo $btpl->fetch('tmpl/main.tmpl.html');
?>