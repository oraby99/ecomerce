<?php
$do = "";
if(isset($_GET["do"]))
{
   $do = $_GET["do"];
}
else
{
    $do = "manage";
    
}
/////////////////////////
if($do == "manage")
{
   
    echo "welcome you are in manage page";
    echo '<a href="page.php?do=add" > Add new categories +</a>';
}
elseif ($do == "add")
{
    echo "you are in add page";
}
elseif ($do == "insert")
{
    echo "you are in insert page";
}
else
{
    echo "there is no page with this name";
}





?>