<?php        
       $langquery="select * from {$PREFFIX}_language"; 
	   $res=mysql_query($langquery) or die($langquery." ".mysql_error());
	   
	   print '<form name="formlang" method="get" action="">'; 
       print '<input type=hidden name=page_code value='.$page_code.'>';
       print '<input type=hidden name=page_name value='.$page_name.'>';
	   print 'Язык <select name="langindex" onchange="submit()">';
	   $num_rows=mysql_num_rows($res);   
        for ($i=0;$i<$num_rows; $i++) 
        { $row = mysql_fetch_array($res);
          if (!intval($langindex)) $langindex=$row[language_code];
          echo '<option';
          if ($row[language_code]==$langindex) { echo ' selected '; $langname=$row[language_name];}
          echo ' value="'.$row[language_code].'">'.$row[language_name].'</option>';
         
        }
//         mysql_free_result($result);
        print '</select> </form>';
?>