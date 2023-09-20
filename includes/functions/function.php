<?php


   
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
function getall($tablename , $where = NULL)
{
   global $con;
   if($where == NULL)
   {
     $sql = "AND approve = 1";
   }
   else
   {
    $sql = NULL;
   }
   $getall = $con->prepare("SELECT * FROM $tablename $where ORDER BY itemid DESC");
   $getall->execute();
   $all = $getall->fetchAll();
   return $all;
}
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
    function checkuser($user)
    {
        global $con;
        $stmtx = $con->prepare("SELECT  username , regstatus FROM users 
        WHERE username = ? AND regstatus = 0 ");
        $stmtx->execute(array($user));
        $status =$stmtx->rowCount();
        return $status;
    }
?>