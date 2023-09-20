
<?php 

session_start();
include "init.php";
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
$stmt = $con->prepare(
                       "SELECT item.* , category.name 
                        AS categoryname ,users.username FROM item
                        INNER JOIN category ON category.id = item.catid
                        INNER JOIN users ON users.userid = item.memberid
                        WHERE itemid = ? AND approve = 1");
$stmt->execute(array($itemid));
$count = $stmt->rowCount();
if($count > 0)
{
    $item = $stmt->fetch();

 
    
?>

<?php

?>
<h2 class="text-center"><?php echo $item['name'] ?> </h2>
<div class="container"> 
<div class="row ggg" > 
        <div class="col-md-6" > 
        <img class="img-responsive" src ="image/hg.jpg" alt ="tttttstttt" />
        </div>
        <div class="col-md-6 " > 
        <h3><?php echo $item['name'] ?></h3><br>
        <p>DESCRIPTION :<?php echo $item['description'] ?></p>
        <p><?phpADDED DATE : echo $item['adddate'] ?></p>
        <p>PRICE :<?php echo $item['price'] ?>$</p>
        <p>MADE IN :<?php echo $item['country'] ?></p>
        <p>CATEGORY :<a href="category.php?pageid= <?php echo $item['catid'] ?>"> <?php echo $item['categoryname'] ?></p></a>
        <p>ADDED BY :<a href="#"><?php echo $item['username'] ?></p></a>
        </div>
</div>
<hr>
<?php
if (isset($_SESSION['user'])) 
   { ?>
<div class="row">
   <div class="col-md-offset-6" >
      <h3>ADD YOUR COMMENT</h3><br>
      <form action=" <?php echo $_SERVER['PHP_SELF'] . '?itemid=' .$item['itemid']  ?>" method="POST">
          <div> 
          <textarea required  name="comment" ></textarea><br>
          <input class="yy" type = "submit" value = "ADD COMMENT"> 
          </div>
      </form>
      <?php 
        if ($_SERVER['REQUEST_METHOD'] =="POST") 
        {
           $comment = filter_var($_POST['comment'] , FILTER_SANITIZE_STRING);
           $userid  = $_SESSION['uid'] ;
           $itemid  = $item['itemid'] ;
                 if( ! empty($comment))
                 {
                    $stmt = $con->prepare("INSERT INTO 
                    comment(comment , status ,date , itemid , userid)
                    VALUES(:zcomment ,0 ,now() ,:zitemid ,:zuserid )");
                    $stmt->execute(array(
                        'zcomment' => $comment,
                        'zitemid'  => $itemid,
                        'zuserid'  => $userid,
                        
                    ));
                    if($stmt)
                    {
                     $themsg = " <div class='alert alert-success'> COMMENT ADDED </div><br>";
                     redirecthome($themsg ,'back' );
                    } 
                  }  
                 
                  else
                  {
                     echo " <div class='alert alert-danger'> please write your comment </div><br>";
                    
                  }
               
         }
       
      ?>
   </div>
</div>
   <?php } 
   else
   {
       echo " <a href ='login.php'> LOGIN </a> or <a href ='login.php'> REGISTER </a>  to add comment";
   }
   ?>
<hr>
<?php 
$stmt = $con->prepare("SELECT comment.* , users.username AS member
                       FROM comment 
                       INNER JOIN users ON users.userid = comment.userid 
                       WHERE itemid = ? AND status = 1
                       ");
$stmt->execute(array($item['itemid']));
$comments = $stmt->fetchAll();

?>

<?php 
foreach($comments as $comment)
{
        echo '<div class="container">';
        echo '<div class="row dd  ">';
       
            echo '<div class="fl col-sm-4 text-center">' ; 
            echo '<img class="gm" src ="image/hg.jpg" alt ="tttttstttt" />';
            echo $comment['member'] ; 
            echo '</div>';

            echo '<div class=" d-flex o col-sm-6">' . $comment['comment'] ;
            echo '</div>';
          
        echo '</div>';  echo '<br>';  echo '<hr>';
        echo '</div>';
}
?>
</div>

<br>
<?php
}
else
{
   $themsg = " <div class='alert alert-danger'> this item need to approve by admin</div><br>";
   redirecthome($themsg ,'back' );
}

   function getitem($where , $value )
   {
      global $con;
      $getitem = $con->prepare("SELECT * FROM item WHERE $where = ? ORDER BY itemid DESC ");
      $getitem->execute(array($value));
      $item = $getitem->fetchAll();
      return $item;
   }    
 
include "includes/templates/footer.php";
?>
