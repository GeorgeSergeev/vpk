<?php
  session_start();

 if (!isset($_SESSION["FMRADIO"]))
 {
//echo"not set";
    //session_unset();
    unset($REGUSER);
    $_SESSION["FMRADIO"]=1;
 }

//выделение пользователя----------------------------------------------------------------------------------------
 if (isset($op))
 {
      if ($op=="in")
         {
               include("userfrombase.php"); //попытка достать юзера из базы
               if (!$REGUSER['name'])
               {
                     header("Location: $PHP_SELF?err=1");
                     die();
               }
                   else {
                             header("Location: main.php");
                             die();
                        }

         }
         else
      if ($op=="out")
         {
           unset($_SESSION['REGUSER']);
           unset($REGUSER);
           header("Location: $PHP_SELF?err=2");
           die();
         }
  }

   $REGUSER["code"]=$_SESSION["REGUSER"]["code"];
   $REGUSER["name"]=$_SESSION["REGUSER"]["name"];
   $REGUSER["login"]=$_SESSION["REGUSER"]["login"];
   $REGUSER["pass"]=$_SESSION["REGUSER"]["pass"];
   $REGUSER["email"]=$_SESSION["REGUSER"]["email"];
// --------------- права -------------------------------------------------------
   $REGUSER["permissions"]=$_SESSION["REGUSER"]["permissions"];   
// -----------------------------------------------------------------------------

if( (!trim($REGUSER["name"]))&&(strpos($_SERVER['REQUEST_URI'],"index.php")===false)&&(strpos($_SERVER['REQUEST_URI'],".php")!==false)  ) header("Location: index.php");
//конец выделения пользователя----------------------------------------------------------------------------------------

?>
