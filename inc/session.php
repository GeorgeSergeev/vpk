<? session_start(); 
$thisurl=$_SERVER['REQUEST_URI'];
if (!isset($_SESSION['LANG']))
		{		
         $_SESSION['LANG']=1;
         $_SESSION['lng']="ru";
		}

if (isset($_GET['ln']))
{
	if ($_GET['ln']=="ru")
	{
		$_SESSION['lng']="ru";
		$_SESSION['LANG']=1;
		$thisurl=str_replace("&ln=ru","",$thisurl);
		$thisurl=str_replace("?ln=ru","",$thisurl);
		header("Location: $thisurl");
	}
	else
	{
		$_SESSION['lng']="en";		
		$_SESSION['LANG']=2;
		$thisurl=str_replace("&ln=en","",$thisurl);
		$thisurl=str_replace("?ln=en","",$thisurl);
		header("Location: $thisurl");
	}
}

$lng=$_SESSION['lng'];
$LANG=$_SESSION['LANG'];
$opensub=false;
$opensubcode=0;
// echo"$lng++<br>";
?>
