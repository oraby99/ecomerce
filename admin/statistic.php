<?php

session_start();
if(isset($_SESSION["username"]))
{
include "init.php";
if(isset($_GET["do"]))
{
   $do = $_GET["do"];
}
else
{
    $do = "manage";

}
if($do == "manage")
{
   echo "welcome";
}
elseif($do == "add")
 {

 }
elseif($do == "insert")
{

}
elseif($do == "edit")
{

} 
elseif($do =='update')
{

}
elseif($do =='delete')
{

}
elseif($do =='activate')
{

}
    include "includes/templates/footer.php";
}
else
{
 
  header("location:index.php");
  exit();
}

?>