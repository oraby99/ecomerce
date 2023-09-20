<?php

// function getc()
// {
//    global $con;
//    $getc = $con->prepare("SELECT * FROM category WHERE parent = {$cat['id']} ORDER BY id DESC ");
//    $getc->execute();
//    $cat = $getc->fetchAll();
//    return $cat;
// }
function getsubcat($select , $table ,$where)
{
   global $con;
   $getsubcat = $con->prepare("SELECT $select FROM $table  WHERE $where ");
   $getsubcat->execute();
   $cats = $getsubcat->fetchAll();
   return $cats;
} 
 function getcat()
{
   global $con;
   $getcat = $con->prepare("SELECT * FROM category  ORDER BY id DESC ");
   $getcat->execute();
   $cats = $getcat->fetchAll();
   return $cats;
}
    // if($pagetitle == "login")
    // {
    //      echo $pagetitle;
    // }
    // elseif($pagetitle == "dashboard")
    // {
        
    //     echo $pagetitle;
    // }
    // else
    // {
    //     echo "default";
    // }
      function redirecthome($themsg ,$url = null, $seconds=5)
      {
          if($url === null)
          {
              $url = 'dashboard.php';
          }
          else
          {
              if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=="")
              {
                $url = $_SERVER['HTTP_REFERER'];
              }
              else
              {
                  $url = 'dashboard.php';
              }
          }
         echo $themsg;
         echo "<div class='alert alert-info'>YOU WILL BE REDIRECT TO HOME PAGE AFTER  $seconds SECOND.</div>";
         header("refresh:$seconds;url=$url");
         exit();
      }


       function checkitem($select , $from , $value)
       {
           global $con;
           $stm1 =$con->prepare("SELECT $select FROM $from WHERE $select = ? ");
           $stm1->execute(array($value));
           $count = $stm1->rowCount();
           return $count;
       }
      
  
    function countitem($item , $table)
    {
       global $con;
       $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
       $stmt2->execute();
       return $stmt2->fetchColumn();
    }


    function getlatest($select , $table , $order, $LIMIT =5 )
    {
       global $con;
       $stmt3 = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $LIMIT ");
       $stmt3->execute();
       $rows = $stmt3->fetchAll();
       return $rows;
    }
?>