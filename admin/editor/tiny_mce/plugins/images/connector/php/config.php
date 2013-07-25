<?php

//Корневая директория сайта

define('SITE_FOLDER',	'/work/vpk');

define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT'].SITE_FOLDER);
//Директория с изображениями (относительно корневой)
define('DIR_IMAGES',	'/img');
//Директория с файлами (относительно корневой)
define('DIR_FILES',		'/files');


//Высота и ширина картинки до которой будет сжато исходное изображение и создана ссылка на полную версию
define('WIDTH_TO_LINK', 1200);
define('HEIGHT_TO_LINK', 800);

//Атрибуты которые будут присвоены ссылке (для скриптов типа lightbox)
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

date_default_timezone_set('Europe/Kiev');

?>
