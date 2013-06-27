<?php


function  varHardtest($varname)
{
   if (!isset($varname)) header("Location: 404.html");
   if (!is_numeric($varname)) header("Location: 404.html");
   if ($varname<0) header("Location: 404.html");
}

function  varLitetest($varname)
{
   if ($id)
   {
     if (!is_numeric($varname)) header("Location: 404.html");
     if ($varname<0) header("Location: 404.html");
   }
}


function  DevideFile($filename,&$name,&$ext)
{
  $p=strrpos($filename,".");
  $name=substr($filename,0,$p);
  $ext=substr($filename,$p+1,strlen($filename)-$p);
}

function ConvertDate($dateval,$delim="-",$is_full=false)
{
  if (!$is_full) $a=10;else $a=16;
  if (strlen($dateval)>$a) $dateval=substr($dateval,0,$a);
  $chunks=explode("-",$dateval);
  $tim=explode(" ",$chunks[2]);
  $res=$tim[0].$delim.$chunks[1].$delim.$chunks[0];
  if ($is_full) $res.=" ".$tim[1];
  return $res;
}


function Show($val)
{
  if (trim($val)=="") return "&nbsp"; else return $val;
}

//предвыводная обработка псевдостатики
function prepare($st)
{
  global $path;
  $st=str_replace("../im","im",$st);
  $st=str_replace("../files","files",$st);
  return $st;
}

function getStatic($pagename,$lng)
{
	global $PREFFIX;
	$query= "SELECT
{$PREFFIX}_static.static_text,
{$PREFFIX}_static.static_pos,
{$PREFFIX}_static.static_seo_title,
{$PREFFIX}_static.static_seo_desc,
{$PREFFIX}_static.static_seo_key,
{$PREFFIX}_static.static_abstract,
{$PREFFIX}_static.static_url,
{$PREFFIX}_static.static_name,
{$PREFFIX}_page.page_url
FROM
{$PREFFIX}_static
INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_static.page_code
WHERE ({$PREFFIX}_page.page_name='$pagename') and (lang_code=$lng)
";

    $res=mysql_query($query);
    list($static_text,$static_pos,$static_seo_title,$static_seo_desc,$static_seo_key,$static_abstact, $static_url,$static_name,$page_url)=mysql_fetch_array($res);
    $a=array("text"=>$static_text,
             "pos"=>$static_pos,
             "seo_title"=>$static_seo_title,
    		 "seo_desc"=>$static_seo_desc,
    		 "seo_key"=>$static_seo_key,
    		 "abstract"=>$static_abstact,
    		 "url"=>$static_url,
    		 "name"=>$static_name,
    		 "page_url"=>$page_url
             );
    return $a;
}

function getStaticByCode($pagecode,$lng)
{
	global $PREFFIX;
	$query= "SELECT
	{$PREFFIX}_static.static_text,
	{$PREFFIX}_static.static_pos,
	{$PREFFIX}_static.static_seo_title,
	{$PREFFIX}_static.static_seo_desc,
	{$PREFFIX}_static.static_seo_key,
	{$PREFFIX}_static.static_abstract,
	{$PREFFIX}_static.static_url,
	{$PREFFIX}_static.static_name,
	{$PREFFIX}_page.page_url
	FROM
	{$PREFFIX}_static
	INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_static.page_code
	WHERE ({$PREFFIX}_page.page_code='$pagecode') and (lang_code=$lng)
	";

	$res=mysql_query($query);
	list($static_text,$static_pos,$static_seo_title,$static_seo_desc,$static_seo_key,$static_abstact, $static_url,$static_name,$page_url)=mysql_fetch_array($res);
	$a=array("text"=>$static_text,
			"pos"=>$static_pos,
			"seo_title"=>$static_seo_title,
			"seo_desc"=>$static_seo_desc,
			"seo_key"=>$static_seo_key,
			"abstract"=>$static_abstact,
			"url"=>$static_url,
			"name"=>$static_name,
			"page_url"=>$page_url
	);
	return $a;
}

function getCatalogStatic($id,$lng)
{

	global $PREFFIX;
	$query= "SELECT
	{$PREFFIX}_page.page_name
	FROM
	{$PREFFIX}_page
	INNER JOIN {$PREFFIX}_equip ON {$PREFFIX}_equip.page_code = {$PREFFIX}_page.page_code
	WHERE ({$PREFFIX}_equip.equip_code=$id) LIMIT 1";
	$res=mysql_query($query) or die ('Ошибка выборки раздела каталога '.$query);
	if (mysql_num_rows($res)>0)
	{
		list($pagename)=mysql_fetch_array($res);
		return getStatic($pagename, $lng);
	}
}

function getParentId($id)
{
	global $PREFFIX;
	$query= "SELECT
	{$PREFFIX}_equip.equip_parent
	FROM
	{$PREFFIX}_equip
	WHERE ({$PREFFIX}_equip.equip_code=$id)";
	$res=mysql_query($query) or die ('Ошибка выборки родительского каталога '.$query);
	if (mysql_num_rows($res)>0)
	{
	list($parentid)=mysql_fetch_array($res);
	return $parentid;
	}
}



function mime_type($fname)
{
  DevideFile($fname,$name,$ext);
  $f=fopen("inc/types.mime","r");
  while($st=fgets($f))
  {
    $s=substr($st,0,strlen($st)-2);
      $a=explode(" ",$s);
      if (in_array($ext,$a)) {fclose($f);return $a[0];}
  }
  fclose($f);
  return "application/octet-stream";
}

function fullBack($url="/")
{
    header("Location: $url");
    die();
}

//отправляет письмо с указанным текстом и темой на указанный адрес
//отправляет письмо с указанным текстом и темой на указанный адрес
function mailSend($email,$subj,$text,$from="",$replyto="",$bcc="")
{
global $adminemail,$adminname;
  if($from=="") $from="$adminname <$adminemail>";
  if($replyto=="") $replyto=$adminemail;
//    $from="george.sergeev@gmail.com";
    $boundary = strtoupper(md5(uniqid(time())));
    $headers = "From: $from\nReply-To: $replyto\r\n";
//if($bcc) $headers.="Bcc: $bcc\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=$boundary\r\n";

    $data= "This is a multi-part message in MIME format.\r\n\r\n";
    $data .= "--$boundary\n";
    $data .= "Content-Type: text/html; charset=windows-1251\n";
    $data .= "Content-Transfer-Encoding:base64\r\n\r\n";

    $ttext="<html><body>".stripslashes($text)."</body></html>";
    $ttext = chunk_split(base64_encode($ttext));

    $data .= "$ttext\r\n\r\n";
    mail($email,$subj,$data,$headers);
}

function GetCurrent($thisID,&$arr)
{
  global $PREFFIX;
  if($thisID==0) return;
  list($category_code,$category_name,$parent_id)=mysql_fetch_array(mysql_query("select category_code,category_name,category_parent from {$PREFFIX}_category where category_code=$thisID"));
  $arr[]=Array("code"=>$category_code,"name"=>$category_name,"parent"=>$parent_id);
  if($parent_id==0) return;
  GetCurrent($parent_id,$arr);
}

function GetDescendants($thisID,&$arr)
{
  global $PREFFIX;
              if(!$thisID) return;
            $query="select category_code,category_name,category_parent from {$PREFFIX}_category where category_parent=$thisID order by category_pos" or die("!!!");
            $res=mysql_query($query);
            $n_r=mysql_num_rows($res);
            if (!$n_r) return;
            while (list($category_c,$category_n,$category_p)=mysql_fetch_array($res))
            {
                $arr[]=Array("code"=>$category_c,"name"=>$category_n,"parent"=>$category_p);
              GetDescendants($category_c,$arr);
            }

return 0;
}

 function GetCart()
 {
   global $TOYUSER,$PREFFIX,$LIMIT_SUM;
   if (is_array($_SESSION['cart']))
   {
     if ($TOYUSER["code"]) $f="unit_regprice"; else $f="unit_price";
     $codes="0";
     foreach ($_SESSION['cart'] as $key=>$val) $codes.=",".$key;
     $cartquery="select unit_code,$f from {$PREFFIX}_shopunit where unit_code in ($codes)";
     $r=mysql_query("$cartquery") or die("Error 198");
     while(list($unit_code,$price)=mysql_fetch_array($r))
     {$cnt+=$_SESSION['cart'][$unit_code];    $tot+=$_SESSION['cart'][$unit_code]*$price;  }

     return "В корзине: <span>".intval($cnt)." товаров</span><br/>На сумму: <span>".floatval($tot)." грн.</span>";
   }
   else return "В корзине: <span>0 товаров</span><br/>На сумму: <span>0 грн.</span>";
 }

function addhighslide($instr)
{
  $rez_text=$instr;
  $pic_text=$instr;
  while ($pic_text)
  {
     $pic_text=strstr($pic_text, "<img");
     if ($pic_text)
     {
        $picnamestr=strstr($pic_text, "static");
        $picnamestr=strtok($picnamestr, '"');
        $picnamestr=str_replace("small","",$picnamestr);

        $piccomment=strstr($pic_text, "alt");
        $piccomment=substr($piccomment,5);
        $piccomment=strtok($piccomment, '"');

        $picurl=strtok($pic_text, ">").">";
//        $pic_link="<table><tr><td><a href='images/".$picnamestr."' class='highslide'  onclick='return hs.expand(this)'>".$picurl."</a><div class='highslide-caption'>".$piccomment."</div></td></tr></table>";
        $pic_link="<table><tr><td><a href='images/".$picnamestr."' target=_blank class='highslide'  onclick='return hs.expand(this)'>".$picurl."</a></td></tr></table>";

        $rez_text=str_replace($picurl,$pic_link,$rez_text);
        $pic_text=substr($pic_text,4);
     }
  }
  return($rez_text);
}


function send_mime_mail($name_from, // имя отправителя
                        $email_from, // email отправителя
                        $name_to, // имя получателя
                        $email_to, // email получателя
                        $data_charset, // кодировка переданных данных
                        $send_charset, // кодировка письма
                        $subject, // тема письма
                        $body // текст письма
                        ) {
  $to = mime_header_encode($name_to, $data_charset, $send_charset)
                 . ' <' . $email_to . '>';
  $subject = mime_header_encode($subject, $data_charset, $send_charset);
  $from =  mime_header_encode($name_from, $data_charset, $send_charset)
                     .' <' . $email_from . '>';
  if($data_charset != $send_charset) {
    $body = iconv($data_charset, $send_charset, $body);
  }
  $headers = "From: $from\r\n";
  $headers .= "Content-type: text/html; charset=$send_charset\r\n";

  return mail($to, $subject, $body, $headers);
}

function mime_header_encode($str, $data_charset, $send_charset) {
  if($data_charset != $send_charset) {
    $str = iconv($data_charset, $send_charset, $str);
  }
  return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
}



function GetFirstBigpic($pcode)
{
  global $PREFFIX;

            $picquery="select picbig from {$PREFFIX}_picture where page_code=$pcode order by picpos limit 1";
            $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе. ");
            $num_pics=mysql_num_rows($picres);
            $picsmall="";
            if ($num_pics)
            {
              list($picsmall)=mysql_fetch_array($picres);
              $picsmall="images/".$picsmall;
            }
  return($picsmall);
}


function GetFirstSBigpic($pcode)
{
  global $PREFFIX;

            $picquery="select spicbig from {$PREFFIX}_spicture where spage_code=$pcode order by spicpos limit 1";
            $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе. ");
            $num_pics=mysql_num_rows($picres);
            $picsmall="";
            if ($num_pics)
            {
              list($picsmall)=mysql_fetch_array($picres);
              $picsmall="images/".$picsmall;
            }
  return($picsmall);
}



function GetUnitGallery($pcode)
{
  global $PREFFIX;

  $gallery="";
  $picquery="select picsmall,picbig,piccomment from {$PREFFIX}_picture where page_code=$pcode order by picpos limit 1,1000";
  $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе.");
  $num_rows=mysql_num_rows($picres);
  if($num_rows)
  {
      $gallery="<div class=pagetextarea><center>";
      while(list($picsmall,$picbig,$piccomment)=mysql_fetch_array($picres))
      {
        if (strlen($piccomment)==0) $piccomment=$thisobj_name;
        $gallery=$gallery."
                <div class=unitgalleryitem>
                  <a class='highslide' onclick='return hs.expand(this)' href='images/$picbig' target=_blank><img src='images/$picsmall' border=0>
                     <div class=view>увеличить >></div>
                  </a><div class='highslide-caption'>$piccomment</div>
                </div>
        ";
      }
      $gallery=$gallery."</center></div>";

  }

  return($gallery);
}


function getMenuParent($code)
{
    global $PREFFIX;

    $pres=mysql_query("select category_parent from {$PREFFIX}_shopcategory where category_code=$code");
    list($c_p)=mysql_fetch_array($pres);

    if ($c_p==0) return $code;
    else getMenuParent($c_p); return $c_p;
}


function getShopParentList($code,$rezstr="")
{
    global $PREFFIX;

    $pres=mysql_query("select category_parent,category_name from {$PREFFIX}_shopcategory where category_code=$code");
    list($c_p,$c_n)=mysql_fetch_array($pres);
    if(strlen($c_n)>0) $rezstr=" >> <a href='catalog.php?id=$code'>$c_n</a>".$rezstr;

    if ($c_p!=0) $rezstr=getShopParentList($c_p,$rezstr);
    else $rezstr="<a href='$mainurl'>Каталог товаров</a> ".$rezstr;

    return $rezstr;
}


function getpicunitlist($category_code,$resultlist,$brand)
{
    global $PREFFIX, $siterate, $sitediscount;

    if ($brand!=0) $tail=" and {$PREFFIX}_shopunit.brand_code=$brand ";
    else $tail="";

    $topunutquery="select unit_code,unit_name,unit_price,page_code,{$PREFFIX}_brands.brand_name,{$PREFFIX}_brands.brand_code,{$PREFFIX}_brands.brand_money
                   from {$PREFFIX}_shopunit
                     left join {$PREFFIX}_brands on ({$PREFFIX}_brands.brand_code={$PREFFIX}_shopunit.brand_code)
                   where unit_active=1 and category_code=$category_code $tail
                   order by unit_pos";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать топ-предметы. Ошибка в запросе.");
    $num_topunuts=mysql_num_rows($topunutres);
    while(list($unit_code,$unit_name,$unit_price,$page_code,$brand_name,$brand_code,$brand_money)=mysql_fetch_array($topunutres))
    {
       $unit_link="unit.php?id=$unit_code";
       $unit_cost=getcost($unit_price,$brand_money,$sitediscount);
       $unit_cost=sprintf("%01.2f", $unit_cost);

       $unit_pic=GetFirstBigPic($page_code);

       if (strlen($brand_name)>0) $brand_aname=" - ".$brand_name;

       if (strlen($unit_pic)>0) $unit_pic="<center><div class=mhpic><center><a href='".$unit_link."'><img src='".$unit_pic."' alt='$unit_name $brand_name' title='$unit_name $brand_aname' border=0></a></center></div></center>";



       $resultlist=$resultlist."
          <div class=topunititem>
             <div class=mhtitle><a href='$unit_link'><h4><center>$unit_name</center></h4></a></div>
             $unit_pic
             <CENTER><div class=unitprice>$unit_cost <span>грн.</span></div></CENTER>

             <div class-buttons>
                <div class=morebut><a href='$unit_link'><img src='graph/more.png' border=0 alt='подробнее'></a></div>
                <div class=orderbut><a class=pointer onclick=\"ShowAdd('addunit.php?code=$unit_code')\"><img src='graph/buy.png' border=0 alt='купить'></a></div>
             </div>
          </div>
       ";
    }


   $catquery="select category_code from {$PREFFIX}_shopcategory where category_active=1 and category_parent=$category_code order by category_pos";
   $categoryres=mysql_query ($catquery) or die ("Не могу выбрать потомков. Ошибка в запросе.");
   while(list($c_code)=mysql_fetch_array($categoryres))
   {
     $resultlist=getpicunitlist($c_code,$resultlist,$brand);
   }

   return $resultlist;
}




function getunittable($category_code,$resultlist,$brand)
{
    global $PREFFIX, $siterate, $sitediscount;

    if ($brand!=0) $tail=" and {$PREFFIX}_shopunit.brand_code=$brand ";
    else $tail="";

    $topunutquery="select unit_code,unit_name,unit_price,unit_power,unit_area,unit_text,page_code,{$PREFFIX}_brands.brand_name,{$PREFFIX}_brands.brand_code,{$PREFFIX}_brands.brand_money
                   from {$PREFFIX}_shopunit
                     left join {$PREFFIX}_brands on ({$PREFFIX}_brands.brand_code={$PREFFIX}_shopunit.brand_code)
                   where unit_active=1 and category_code=$category_code $tail
                   order by unit_pos";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать топ-предметы. Ошибка в запросе.");
    $num_topunuts=mysql_num_rows($topunutres);
    while(list($unit_code,$unit_name,$unit_price,$unit_power,$unit_area,$unit_text,$page_code,$brand_name,$brand_code,$brand_money)=mysql_fetch_array($topunutres))
    {
       if (strlen($unit_text)>0) $unit_link="<a href='unit.php?id=$unit_code'>";  else $unit_link="<a>";

       $unit_cost=getcost($unit_price,$brand_money,$sitediscount);
       $unit_cost=sprintf("%01.2f", $unit_cost);

       if ($unit_power==0) $unit_power_str="-"; else $unit_power_str=$unit_power;
       if ($unit_area==0) $unit_area_str="-"; else $unit_area_str=$unit_area;

       $resultlist=$resultlist."
          <tr bgcolor=#ffffff align=center >

             <td class=nametd>".$unit_link."<h4>$unit_name</h4></a></td>
             <td>$brand_name</td>
             <td>$unit_power_str</td>
             <td>$unit_area_str</td>
             <td>$unit_cost</td>
             <td><a class=pointer onclick=\"ShowAdd('addunit.php?code=$unit_code')\"><img src='graph/buy.png' border=0 alt='купить'></a></td>

          </tr>

       ";
    }


   $catquery="select category_code from {$PREFFIX}_shopcategory where category_active=1 and category_parent=$category_code order by category_pos";
   $categoryres=mysql_query ($catquery) or die ("Не могу выбрать потомков. Ошибка в запросе.");
   while(list($c_code)=mysql_fetch_array($categoryres))
   {
     $resultlist=getunittable($c_code,$resultlist,$brand);
   }

   return $resultlist;
}




function getCatBrandList($category_code,$resultlist,$cat_code)
{
    global $PREFFIX,$brand,$barr;

    $topunutquery="select brand_name,{$PREFFIX}_brands.brand_code
                   from {$PREFFIX}_shopunit
                     left join {$PREFFIX}_brands on ({$PREFFIX}_brands.brand_code={$PREFFIX}_shopunit.brand_code)
                   where unit_active=1 and category_code=$category_code
                   group by {$PREFFIX}_brands.brand_code";
    $topunutres=mysql_query ($topunutquery) or die ("Не могу выбрать топ-предметы. Ошибка в запросе.");
    $num_topunuts=mysql_num_rows($topunutres);
    while(list($brand_name,$brand_code)=mysql_fetch_array($topunutres))
    {
       $brandinarray=1; $bcount=0;
       foreach($barr as $index => $val) {if ($val==$brand_code) $brandinarray=0; $bcount++;}

       if($brandinarray==1)
       {
         $barr[$bcount]=$brand_code;

         if ($brand_code==$brand) $bclass="class«randbutton";
         else  $bclass="class=brandbutton";

         $resultlist=$resultlist."
            <div ".$bclass."><a href='catalog.php?id=$cat_code&brand=$brand_code'>$brand_name</a></div>
         ";
       }
    }

   $catquery="select category_code from {$PREFFIX}_shopcategory where category_active=1 and category_parent=$category_code order by category_pos";
   $categoryres=mysql_query ($catquery) or die ("Не могу выбрать потомков. Ошибка в запросе.");
   while(list($c_code)=mysql_fetch_array($categoryres))
   {
     $resultlist=getCatBrandList($c_code,$resultlist,$cat_code);
   }

  return $resultlist;



}







function printpageline($pq,$this,$id='')
{
  if ($pq>1)
  {
    echo"<div class=pageline>Страницы: ";
    for ($i=1;$i<$pq+1;$i++)
     {
       $y=$i-1;
       if ($this==$y) {$t1="<b>";$t2="</b>";} else {$t1="";$t2="";}
       if ($i!=1) echo" / ";
       if (strlen($id)>0) echo"$t1 <a href='$PHP_SELF?id=$id&page=$y'>$i</a> $t2 ";
       else echo"$t1 <a href='$PHP_SELF?page=$y'>$i</a> $t2 ";
     }
    echo"</div>";
  }
}


function getcost($p,$siterate,$sitediscount)
{
  global $REURO;
  global $RUSD;

  if ($siterate==0) $thisprice=$p;
  if ($siterate==1) $thisprice=$p*$REURO;
  if ($siterate==2) $thisprice=$p*$RUSD;

  $thisdiscount=$p*$sitediscount/100;
  $cost=$thisprice-$thisdiscount;
  $cost=round($cost,2);

  return($cost);
}


function GetFirstFpic($pcode)
{
  global $PREFFIX;

            $picquery="select spicbig,spiccomment from {$PREFFIX}_spicture where spage_code=$pcode order by spicpos limit 1";
            $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе. ");
            $num_pics=mysql_num_rows($picres);
            $picsmall_str="";
            if ($num_pics)
            {
              list($picbig,$piccoment)=mysql_fetch_array($picres);
              $pic_str="<img src='images/$picbig' border=0 alt='$piccoment'>";
            }
  return($pic_str);
}


function GetFirstpic($pcode)
{
  global $PREFFIX;

            $picquery="select picbig,piccomment from {$PREFFIX}_picture where page_code=$pcode order by picpos limit 1";
            $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе. ");
            $num_pics=mysql_num_rows($picres);
            $picsmall_str="";
            if ($num_pics)
            {
              list($picbig,$piccoment)=mysql_fetch_array($picres);
              $pic_str="<img src='images/$picbig' border=0 alt='$piccoment'>";
            }
  return($pic_str);
}



function GetFirstpicstr($pcode)
{
  global $PREFFIX;

            $picquery="select picsmall,picbig,piccomment from {$PREFFIX}_picture where page_code=$pcode order by picpos limit 1";
            $picres=mysql_query ($picquery) or die ("Не могу выбрать изображения. Ошибка в запросе. ");
            $num_pics=mysql_num_rows($picres);
            $picsmall_str="";
            if ($num_pics)
            {
              list($picsmall,$picbig,$piccoment)=mysql_fetch_array($picres);
              $picsmall_str="<a href='images/$picbig' traget=_blank class='highslide' onclick='return hs.expand(this)'><img src='images/$picsmall' border=0 alt='$piccoment'></a><div class='highslide-caption'>$piccomment</div>";
            }
  return($picsmall_str);
}

//************  George Sergeev *********

function GetNextLang($lan)
{
  if ($lan==1) return ("en"); else return ("ru");
}

function GetCurrentLang($lan)
{
	if ($lan==2) return ("_en"); else return "";
}

function GetActiveLang($lan)
{
	global $lng;
	if ($lan==$lng) return ("a"); else return ("");
}

function Translate($lan,$subj)
{
    global $dict;
	if ($lan==2) $temp=$dict[$subj];
	if ($temp=="") $temp=$subj;
	return ($temp);
}

function view_tree($langcode,$catalogpage,$opensub=false, $opensubcode=0) {
//catalogpage - страница перехода
	global $PREFFIX;
	$catalogshort="SELECT DISTINCT
	{$PREFFIX}_equip.equip_code,
	{$PREFFIX}_equip.equip_parent,
	{$PREFFIX}_static.static_code,
	{$PREFFIX}_static.static_name,
	{$PREFFIX}_equip.equip_pos
	FROM {$PREFFIX}_static
	INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_static.page_code
	INNER JOIN {$PREFFIX}_equip ON {$PREFFIX}_page.page_code = {$PREFFIX}_equip.page_code
	WHERE (lang_code='$langcode') and (page_active>0)
	ORDER BY equip_parent,equip_pos";

	$query = mysql_query("$catalogshort") or  die("Ошибка выборки каталога ".$catalogshort);
	while (list($equip_code,$equip_parent,$static_code,$static_name,$equip_pos)= mysql_fetch_array($query)) {
	if ($equip_parent == '0') { //echo $equip_code."  ".$equip_parent. " ". $static_name."<BR>";
		$one_lvl[] = array ($equip_code, $equip_parent, $static_code,$static_name);
	} else { //echo "Child ". $equip_code." ".$equip_parent. " ". $static_name ."<BR>";
		$next_lvl[] = array ($equip_code, $equip_parent, $static_code,$static_name);
	}
	}
	print '<ul>';
	foreach ($one_lvl as $key){
      print '<li><a href="catalog.php?id='.$key[0].'">'.$key[3].'</a>';
      if ($opensubcode==$key[0])
       view_tree_next_level($key[0], $next_lvl);
      print '</li>';
	}
	print '</ul>';
	}


	function view_tree_next_level($family, $next_lvl)
	{
		print '<ul>';
		foreach ($next_lvl as $key) if ($key[1]==$family)
	       print '<li><a href="models.php?id='.$key[0].'">'.$key[3].'</a> </li>';
 	   print '</ul>';
	}


	function getlastnews($lang, $limit=0)
	{
		global $PREFFIX;
		$lastnewsquery="SELECT
		{$PREFFIX}_news.news_code,
		{$PREFFIX}_news.news_date,
		{$PREFFIX}_static.static_abstract,
		{$PREFFIX}_static.static_name,
		{$PREFFIX}_page.page_code,
		{$PREFFIX}_page.page_url
		FROM
		{$PREFFIX}_news
		LEFT JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_news.page_code
		LEFT JOIN {$PREFFIX}_static ON {$PREFFIX}_page.page_code = {$PREFFIX}_static.page_code
		WHERE ({$PREFFIX}_static.lang_code=$lang) and ({$PREFFIX}_page.page_active>0)
		ORDER BY news_date DESC";
		if ($limit)	$lastnewsquery=$lastnewsquery." LIMIT $limit";

		$query = mysql_query("$lastnewsquery") or  die("Ошибка выборки новости ".$lastnewsquery);
		while (list($news_code,$news_date,$static_abstract,$static_name,$page_code,$page_url)= mysql_fetch_array($query))
		{
			$galquery="SELECT {$PREFFIX}_picture.picbig FROM  {$PREFFIX}_picture
			WHERE {$PREFFIX}_picture.page_code=$page_code  ORDER BY picpos LIMIT 1";
			$galres = mysql_query("$galquery") or  die("Ошибка выборки галереи ".$galquery);
					list($picbig)=mysql_fetch_array($galres);
					if ((!isset($picbig)) or ($picbig=="")) $picbig='nullnews.gif';

			$a[] = array ($news_code,$news_date,$static_abstract,$picbig,$static_name,$page_url);
		}
		return $a;
	}


	function getnewsbyid($lang, $idnews)
	{
		global $PREFFIX;
		$newsquery="SELECT
		{$PREFFIX}_news.news_date,
		{$PREFFIX}_static.static_name,
		{$PREFFIX}_static.static_abstract,
		{$PREFFIX}_static.static_text,
		{$PREFFIX}_static.static_seo_title,
		{$PREFFIX}_static.static_seo_desc,
		{$PREFFIX}_static.static_seo_key,
		{$PREFFIX}_page.page_code,
		{$PREFFIX}_page.page_name
		FROM
		{$PREFFIX}_news
		LEFT JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_news.page_code
		LEFT JOIN {$PREFFIX}_static ON {$PREFFIX}_page.page_code = {$PREFFIX}_static.page_code
		LEFT JOIN {$PREFFIX}_picture ON {$PREFFIX}_page.page_code = {$PREFFIX}_picture.page_code
		WHERE ({$PREFFIX}_static.lang_code=$lang) and ({$PREFFIX}_news.news_code=$idnews) ";

		$query = mysql_query("$newsquery") or  die("Ошибка выборки новости ".$newsquery);
		return mysql_fetch_array($query);
	}

	function GetNextNews($news_code,$news_date)
	{
		global $PREFFIX;
//		$query="SELECT {$PREFFIX}_news.news_code FROM {$PREFFIX}_equip WHERE equip_code=$eq_id";
//		$res = mysql_query("$query") or  die("Ошибка выборки ".$query);
//		list($eq_pos)=mysql_fetch_array($res);
		$query="SELECT
		{$PREFFIX}_news.news_code
		FROM {$PREFFIX}_news
		INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_news.page_code
		WHERE (news_code>$news_code) and  (page_active>0)  and (news_date>='$news_date') ORDER BY news_date LIMIT 1";
				$res = mysql_query("$query") or  die("Ошибка выборки ".$query);
						if (mysql_num_rows($res)>0)
						{
						list($nextid)=mysql_fetch_array($res);
						return $nextid;
						}
						else return -1;
	}

	function GetPrevNews($news_code,$news_date)
	{
		global $PREFFIX;
		//		$query="SELECT {$PREFFIX}_news.news_code FROM {$PREFFIX}_equip WHERE equip_code=$eq_id";
		//		$res = mysql_query("$query") or  die("Ошибка выборки ".$query);
		//		list($eq_pos)=mysql_fetch_array($res);
		$query="SELECT
		{$PREFFIX}_news.news_code
		FROM {$PREFFIX}_news
		INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_news.page_code
		WHERE (news_code<$news_code) and  (page_active>0)  and (news_date<='$news_date') ORDER BY news_date DESC LIMIT 1";
		$res = mysql_query("$query") or  die("Ошибка выборки ".$query);
		if (mysql_num_rows($res)>0)
		{
		list($nextid)=mysql_fetch_array($res);
		return $nextid;
		}
		else return -1;
		}


	/*
	 *
	*
	*function view_tree($langname) {
	$catalogshort="SELECT DISTINCT
	consul_equip.equip_code,
	consul_equip.equip_parent,
	consul_static.static_code,
	consul_static.static_name
	FROM consul_static
	INNER JOIN consul_page ON consul_page.page_code = consul_static.page_code
	INNER JOIN consul_equip ON consul_page.page_code = consul_equip.page_code
	INNER JOIN consul_lang ON consul_lang.lang_code=consul_static.lang_code
	WHERE (lang_name='$langname') and (page_active>0)
	ORDER BY static_name";

	$query = mysql_query("$catalogshort") or  die("Ошибка выборки каталога ".$catalogshort);
	while (list($equip_code,$equip_parent,$static_code,$static_name)= mysql_fetch_array($query)) {
	if ($equip_parent == '0') { //echo $equip_code."  ".$equip_parent. " ". $static_name."<BR>";
	$one_lvl[] = array ($equip_code, $equip_parent, $static_code,$static_name);
	} else { //echo "Child ". $equip_code." ".$equip_parent. " ". $static_name ."<BR>";
	$next_lvl[] = array ($equip_code, $equip_parent, $static_code,$static_name);
	}
	}
	print '<ul id="tree_one">';
	foreach ($one_lvl as $key){
	print '<li><a href="static_page.php?'.$key[2].'">'.$key[3].'</a>';
	view_tree_next_level($key[0], $next_lvl);
	print '</li>';
	}
	print '</ul>';
	}


	function view_tree_next_level($family, $next_lvl) {
	foreach ($next_lvl as $key) {
	if ($key[1]==$family) {
	print '<ul id="tree_one"> <li><a href="static_page.php?'.$key[2].'">'.$key[3].'</a>';
	view_tree_next_level($key[0], $next_lvl);
	print '</li></ul>';
	}
	}
	}

	*
	*
	*/


	function getEquipList($langcode,$catalogpage, $parentcode=0, $typeprint=0, $startpage=0) {
		//catalogpage - страница перехода
		global $PREFFIX;
		global $mainurl;
		$catalogquery="SELECT DISTINCT
		{$PREFFIX}_equip.equip_code,
		{$PREFFIX}_equip.equip_parent,
		{$PREFFIX}_static.static_code,
		{$PREFFIX}_static.static_name,
		{$PREFFIX}_equip.equip_pos,
		{$PREFFIX}_page.page_code,
		{$PREFFIX}_static.static_abstract,
		{$PREFFIX}_page.page_url,
		{$PREFFIX}_static.static_url

		FROM {$PREFFIX}_static
		INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_static.page_code
		INNER JOIN {$PREFFIX}_equip ON {$PREFFIX}_page.page_code = {$PREFFIX}_equip.page_code
		WHERE (lang_code='$langcode') and (page_active>0) and (equip_parent=$parentcode)
		ORDER BY equip_pos";

		$query = mysql_query("$catalogquery") or  die("Ошибка выборки каталога ".$catalogquery);
		$per_page=10;
		$i=0;
		while (list($equip_code,$equip_parent,$static_code,$static_name,$equip_pos,$page_code,$static_abst,$page_url,$static_url)= mysql_fetch_array($query))
		{
			$catalogquest=$catalogpage."?id=".$equip_code;

			$galquery="SELECT {$PREFFIX}_picture.picbig FROM  {$PREFFIX}_picture
			    	   WHERE {$PREFFIX}_picture.page_code=$page_code  ORDER BY picpos LIMIT 1";
			$galres = mysql_query("$galquery") or  die("Ошибка выборки галереи ".$galquery);
			list($picbig)=mysql_fetch_array($galres);
			if ((!isset($picbig)) or ($picbig=="")) $picbig='nullequip.gif';
			switch ($typeprint)
			{
				case 0:	print "<div class=mсitem>";
			            print "<div class=mсpic><a href='".$catalogquest."'><img src='images/".$picbig."' alt='".$static_name."'></a></div>";
			            print "<h2><a href='".$catalogquest."'>".$static_name."</a></h2>";
			            print "</div>";
			            break;
				case 1: print "	<div class=typeitem>";
			            print "<div class=typepic><a href='".$catalogquest."'><img src='images/".$picbig."' alt='".$static_name."'></a></div>";
					    print "<div class=typetext>";
			            print "<h2><a href='".$catalogquest."'>".$static_name."</a></h2>";
			            print $static_abst;
					    print "<div class=more><a href='".$catalogquest."'>".Translate($langcode,'подробнее')." »</a></div>";
					    print "</div>";
					    print "</div>";
					    break;
				case 2:  if (($i>=$startpage*$per_page) and ($i<($startpage+1)*$per_page))
				       {
					    print "<div class=modelitem>";
			            print "<div class=mlpic> <a href='".$catalogquest."'><img src='images/".$picbig."' alt='".$static_name."'></a></div>";
						print "<div class=mltext>";
			            print "<h2><a href='".$catalogquest."'>".$static_name."</a></h2>";
			            if ($page_url)	print "<div class=mllink><a href='".$page_url."' target=_blank>$page_url</a></div>";
						print $static_abst;
						$docurl=$mainurl.ltrim($static_url,'.');
						echo $docurl;
						print "<div class=nlmore><a href='$docurl'>".Translate($langcode,'Документация')."</a> <span>|</span> <a href='".$catalogquest."'>".Translate($langcode,'Дополнительная информация')." »</a></div>";
						print "	</div>";
						print "	</div>";
				       }
						break;

			}
		}
     return (ceil($i/$per_page));
	}

	function GetNexEquip($eq_id,$par_id)
	{
		global $PREFFIX;
		$query="SELECT {$PREFFIX}_equip.equip_pos FROM {$PREFFIX}_equip WHERE equip_code=$eq_id";
		$res = mysql_query("$query") or  die("Ошибка выборки ".$query);
		list($eq_pos)=mysql_fetch_array($res);
		$query="SELECT
		{$PREFFIX}_equip.equip_code
		FROM {$PREFFIX}_equip
        INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_equip.page_code
		WHERE (equip_pos>$eq_pos) and  (page_active>0)  and (equip_parent=$par_id) ORDER BY equip_pos LIMIT 1";
		$res = mysql_query("$query") or  die("Ошибка выборки ".$query);
		if (mysql_num_rows($res)>0)
		{
			list($nextid)=mysql_fetch_array($res);
			return $nextid;
		}
		else return -1;
	}

	function GetPrevEquip($eq_id,$par_id)
	{
		global $PREFFIX;
		$query="SELECT {$PREFFIX}_equip.equip_pos FROM {$PREFFIX}_equip WHERE equip_code=$eq_id";
		$res = mysql_query("$query") or  die("Ошибка выборки ".$query);
		list($eq_pos)=mysql_fetch_array($res);
		$query="SELECT
		{$PREFFIX}_equip.equip_code
		FROM {$PREFFIX}_equip
		INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_equip.page_code
		WHERE (equip_pos<$eq_pos) and  (page_active>0)  and (equip_parent=$par_id) ORDER BY equip_pos DESC LIMIT 1";
				$res = mysql_query("$query") or  die("Ошибка выборки ".$query);
						if (mysql_num_rows($res)>0)
						{
						list($nextid)=mysql_fetch_array($res);
						return $nextid;
						}
						else return -1;
	}


	function GetGallery ($pageid,$lang)
	{
		global $PREFFIX;
		if ($lang==2)$suf="_en"; else $suf="";
		$galquery="SELECT
		{$PREFFIX}_picture.picbig,
		{$PREFFIX}_picture.picpos,
		{$PREFFIX}_picture.piccomment".$suf.
		" FROM  {$PREFFIX}_picture
		INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_page.page_code = {$PREFFIX}_picture.page_code
		WHERE {$PREFFIX}_page.page_code='".$pageid."' ORDER BY picpos";
		$query = mysql_query("$galquery") or  die("Ошибка выборки галереи ".$galquery);
		return $query;
	}

    function PrintGallery ($pageid,$lang, $outdiv='sertgalleryitem',$insdiv='sgpic')
    {
    	$query=GetGallery($pageid, $lang);
		while (list($picbig,$picpos,$piccomment)= mysql_fetch_array($query))
		{
         print "<div class=".$outdiv.">";
         print "<div class=".$insdiv."><a href='images/".$picbig."' title='".$piccomment."' rel='lightbox[sert]' target=_blank><img src='images/".$picbig."' alt='".$piccomment."' border=0></a></div>";
         print "</div>";
        }
    }

    function ItemGallery($itemid,$lang)
    {
    	global $PREFFIX;
    	$query= "SELECT
    	{$PREFFIX}_page.page_name
    	FROM
    	{$PREFFIX}_page
    	INNER JOIN {$PREFFIX}_equip ON {$PREFFIX}_equip.page_code = {$PREFFIX}_page.page_code
    	WHERE ({$PREFFIX}_equip.equip_code=$itemid) LIMIT 1";
    	$res=mysql_query($query) or die ('Ошибка выборки раздела каталога '.$query);
    	if (mysql_num_rows($res)>0)
    	{
    	list($pagename)=mysql_fetch_array($res);
    	$galquery=GetGallery($pagename, $lang); //Выбрали рисунки и комментарии к ним
    	if (mysql_num_rows($galquery)>0)
    	{
    	   list($picbig,$picpos,$piccomment)= mysql_fetch_array($galquery); //Выбрали первое
    	   print "<div class=itembpic id=ibp0><a href='images/".$picbig."' title='".$piccomment."' rel='lightbox[item]' target=_blank><img src='images/".$picbig."'  alt='".$piccomment."' border=0></a></div>";
    	   while (list($picbig,$picpos,$piccomment)= mysql_fetch_array($galquery))
    		  $itemgal[] = array ($picbig,$picpos,$piccomment);

    	   $sz=count($itemgal);
    	   for ($i=1;$i<$sz;$i++)
    	   {
    	   	print "<div class=itembpic id=ibp$i style='display:none;'><a href='images/".$itemgal[$i][0]."' title='".$itemgal[$i][2]."' rel='lightbox[item]' target=_blank><img src='images/".$itemgal[$i][0]."'  alt='".$itemgal[$i][2]."' border=0></a></div>";
    	   }
    	   print "<div class=roomiconlist>";
    	   print "<div class=roomiconarea>";
    	   $sz=count($itemgal);
    	   for ($i=0;$i<$sz;$i++)
    	   {
    	   	print "<div class=itemicon onclick=showpic(".$i.",".$sz.")><img src='images/".$itemgal[$i][0]."' border=0></div>";
    	   }
    	   print "</div>";
    	   print "</div>";
    	}
    	}
    }

	function GetPartners ($langcode,$onmain=false)
	{
		global $PREFFIX;
		$partnerquery="    SELECT
         {$PREFFIX}_partner.partner_pos,
         {$PREFFIX}_partner.partner_onmain,
         {$PREFFIX}_partner.partner_url,
         {$PREFFIX}_static.static_name,
         {$PREFFIX}_static.static_abstract,
         {$PREFFIX}_page.page_code
         FROM
         {$PREFFIX}_partner
         INNER JOIN {$PREFFIX}_page ON {$PREFFIX}_partner.page_code = {$PREFFIX}_page.page_code
         INNER JOIN {$PREFFIX}_static ON {$PREFFIX}_page.page_code = {$PREFFIX}_static.page_code
         WHERE ({$PREFFIX}_static.lang_code=$langcode) and ({$PREFFIX}_page.page_active>0)";
		if ($onmain) $partnerquery=$partnerquery." AND (partner_onmain>0)";
		$partnerquery=$partnerquery." ORDER BY partner_pos ASC";
		$query = mysql_query("$partnerquery") or  die("Ошибка выборки партнера ".$partnerquery);
		return $query;
   }


   function PrintPartner ($langcode, $onmain, $typeout,$startpage=0)
   {
   	global $PREFFIX;
   	$per_page=10;
   	$query=GetPartners($langcode,$onmain); $i=0;
   	while (list($partner_pos,$partner_onmain,$partner_url, $static_name, $static_abstract, $page_code)= mysql_fetch_array($query))
   	{
   		$galquery="SELECT {$PREFFIX}_picture.picbig FROM  {$PREFFIX}_picture
   		WHERE {$PREFFIX}_picture.page_code=$page_code  ORDER BY picpos LIMIT 1";
   		$galres = mysql_query("$galquery") or  die("Ошибка выборки галереи ".$galquery);
   				list($picbig)=mysql_fetch_array($galres);

   	    switch  ($typeout)
   	    {
   	    	case  0: print "<div class=tpitem><a href='".$partner_url."' traget=_blank>";
   	    	         print "<img src='images/".$picbig."' alt='".$static_name."' border=0></a></div>";
   	    	         break;
   	    	case  1: if (($i>=$startpage*$per_page) and ($i<($startpage+1)*$per_page))
   	    	{
   	    		print " <div class=partnerlistitem>";
   	    		print " <div class=plpic><a href='".$partner_url."'><img src='images/".$picbig."' alt='".$static_name."' border=0></a></div>";
   	    		print " <div class=pltext>";
   	    		print "<h2><a href='".$partner_url."'>".$static_name."</a></h2>";
   	    		print $static_abstract;
   	    		print "<div class=plmore><a href='".$partner_url."'>".$partner_url."</a></div>";
   	    		print "</div>";
   	    		print "</div>";
   	    	}; break;
   	    }
   		$i++;
   	}
   	return ceil($i/$per_page);
   }


   function mark ($curpage,$samplepage,$start)
   {
   	 if ($curpage-$samplepage) return "";
   	 else
   	 {
   	 	if ($start>0) return "<b>"; else return "</b>";
   	 }

   }

	//************  George Sergeev *********


	?>




