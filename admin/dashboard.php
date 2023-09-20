<?php 
session_start();
if(isset($_SESSION["username"]))
{
  $pagetitle ="dashboard";
    
    include "init.php";
 
    ?>
     <div class="container home-stats text-center">
       <h1>DASHBOARD</h1>
           <div class="row">
              <div class="col-md-3">
                <div class="stat st-member">
                  <i class='fa fa-users'></i>
                <div class ='info'>
                TOTAL MEMBERS
                  <span> <a href='member.php'>
                  <?php echo countitem('userid' , 'users')
                   ?></a></span>
                </div>
                </div>
              </div>
              <div class="col-md-3">
           
                <div class="stat st-pend">
                <i class='fa fa-user-plus'></i>
                <div class ='info'>
                PENDING MEMBERS
                <span><a href='member.php?do=manage&page=pending'> 
                  <?php echo checkitem("regstatus" ,"users" ,0) 
                  ?></a></span>
                </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stat st-item">
                <i class='fa fa-tag'></i>
                <div class ='info'>
                  TOTAL ITEMS
                <span><a href='item.php'> 
                <?php echo countitem('itemid' , 'item') ?></a>
              </span>
                </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="stat st-com">
                  
                <i class='fa fa-comments'></i>
                <div class ='info'>TOTAL COMMENTS
                <span><a href='comments.php'> 
                <?php echo countitem('cid' , 'comment') ?></a>

                </span>
                </div>
                </div>
              </div>
           </div>
     </div>

    <div class="container latest">
       <div class="row">
         
         <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                    
                    LATEST REGISTERED USERS
                    <i class="fa fa-users"></i><br>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled latest-user">

                
                 <?php
                 $thelatest = getlatest("*" ,"users", "userid");
                 foreach ($thelatest as $user )
                  {
                   
                    echo "<li>";
                    
                   echo "<button class='btn btn-success '>";
                   echo ' <a href ="member.php?do=edit&ID=' .$user['userid'] .'">'.$user['username'].'<i class ="fa fa-edit"></i></a>';
                   echo "</button>"; 
                 
                   echo "<button class='btn btn-danger'>";
                   echo ' <a class="confirm" href  ="member.php?do=delete&ID=' .$user['userid'] .'">'.$user['username'].'<i class ="fa fa-trash"></i></a>';
                   echo "</button>";
                  
                    echo "</li>";
                  }
                  
                 ?>
                 </ul>
              </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                    
                    LATEST ITEMS
                    <i class="fa fa-tag"></i><br>
              </div>
              <div class="panel-body">
              <ul class="list-unstyled latest-user">

                
<?php
$thelatest = getlatest("*" ,"item", "itemid");
foreach ($thelatest as $item )
 {
  
   echo "<li>";
   
  echo "<button class='btn btn-info '>";
  echo ' <a href ="item.php?do=edit&itemid=' .$item['itemid'] .'">'.$item['name'].'<i class ="fa fa-edit"></i></a>';
  echo "</button>"; 

  echo "<button class='btn btn-danger'>";
  echo ' <a class="confirm" href  ="item.php?do=delete&itemid=' .$item['itemid'] .'">'.$item['name'].'<i class ="fa fa-trash"></i></a>';
  echo "</button>";
 
   echo "</li>";
 }
 
?>
</ul>
              </div>
            </div>
         </div>
         <div class="col-sm-12"><br><br>
            <div class="panel panel-default">
              <div class="panel-heading ">
                    
                    LATEST  COMMENTS
                    <i class="fa fa-comments"></i><br>
              </div>
              <div class="panel-body">
                <ul class="list-unstyled latest-user">
                 <?php
                 $stmt = $con->prepare("SELECT comment.* , users.username AS member
                 FROM comment  
                 INNER JOIN users ON users.userid = comment.userid           
                 ");
                  $stmt->execute();
                  $comments = $stmt->fetchAll();
                  
                 foreach ($comments as $comment )
                  {
                    
                   echo "<li>";

                   echo "<button class=' btn btn-info '>";
                   echo ' <a href  ="member.php?do=edit&ID=' .$comment['userid'] .
                   '">'.$comment['member'].'
                   <i class ="fa fa-user"></i></a>';
                   echo "</button>";

                   echo "<button class=' btn btn-secondary '>";
                   echo ' <a href ="comments.php?do=edit&comid=' .$comment['cid'] .
                   '">'.$comment['comment'].'
                   <i class ="fa fa-edit"></i></a>';
                   echo "</button>"; 

                   echo "<button class=' btn btn-danger '>";
                   echo ' <a class="confirm" href ="comments.php?do=delete&comid=' .$comment['cid'] .
                   '">'."DELETE".'
                   <i class ="fa fa-trash"></i></a>';
                   echo "</button>";

                    echo "</li>";
                  } 
                 ?>
                 </ul>
              </div>
            </div>
         </div>
       </div>
    </div>
   





<?php
    include "includes/templates/footer.php";
}
else
{
 
  header("location:index.php");
  exit();
}

?>