<?php


 header("Content-type: text/html; charset=windows-1251");
 header("Cache-Control: no-store, no-cache, must-revalidate");
 header("Cache-Control: post-check=0, pre-check=0", false);

// include("inc/settings.php");
// setlocale(LC_CTYPE, 'ru_RU.CP1251');
// include ("inc/head.php");

include("admin/inc/const.php");
require_once("inc/functions.php");

//Получаем данные
//$data = $_POST[data];
//                data: "clientname="+ $('#clientname').val()+"&email="$('#clientmail').val()+"&clientcountry="+$('#clientcountry').val()+
//                      "&clientphone"+$('#clientphone').val()+"&message="+$('#message').val();
$clientname=iconv("utf-8", "windows-1251", $_POST['clientname']);
$country=iconv("utf-8", "windows-1251", $_POST['clientcountry']);
$message=iconv("utf-8", "windows-1251", $_POST['message']);
$TEXT.="Сообщение от сайта ".$mainurl." ".date("d/m/Y H:i")."<br><br>";
$TEXT.="<b>Посетитель:</b> ".$clientname;
$TEXT.="<br><b>Email:</b> ".$_POST['email'];
$TEXT.="<br><b>Страна:</b> ".$country;
$TEXT.="<br><b>Телефон:</b> ".$_POST['clientphone'];
$TEXT.="<br><br><b>Сообщение:</b> ".$message;

$nnn=$_POST['clientname'];
$mmm=$_POST['email'];

mailSend($adminemail,"Consul site message",$TEXT,$mmm,$mmm); 
//mailSend($adminemail,"Consul site info", $data);
?>
<BODY>
<center> <h2><?=Translate($LANG,'Сообщение успешно отправлено');?>!</h2>
<p><?=Translate($LANG,'Благодарим за интерес к нашим предложениям');?>!
</p>
</center>
</BODY>
