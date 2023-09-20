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
if($do == "manage"){
  
$stmt = $con->prepare("SELECT comment.* , item.name AS itemname, users.username AS member
                       FROM comment 
                       INNER JOIN item  ON item.itemid  = comment.itemid
                       INNER JOIN users ON users.userid = comment.userid
                       ");
$stmt->execute();
$rows = $stmt->fetchAll();
?>
      <h1 class="text-center">MANAGE COMMENT</h1> 
      <div class="container  ">
        <div class='table-responsive'>
          <table class='main-table text-center table table-bordered'> 
            <tr>
              <td>ID</td>
              <td>COMMENT</td>
              <td>ITEM NAME</td>
              <td>USER NAME</td>
              <td> ADDED DATE</td>
              <td>CONTROL</td>
            </tr>
            <?php
            foreach($rows as $row)
            {
              echo "<tr>";
                echo "<td>" .$row['cid']     ."</td>";
                echo "<td>" .$row['comment'] ."</td>";
                echo "<td>" .$row['itemname']  ."</td>";
                echo "<td>" .$row['member']  ."</td>";
                echo "<td>" .$row['date']    ."</td>";
                echo "<td>
                    <a href ='comments.php?do=edit&comid="   . $row['cid'] ."' class='btn btn-success'><i class='fa fa-edit'></i> EDIT</a>
                    <a href ='comments.php?do=delete&comid=" . $row['cid'] ."' class='btn btn-danger confirm'><i class='fas fa-backspace'></i> DELETE</a>";
              if($row['status'] == 0)
              {
               echo " <a href ='comments.php?do=approve&comid=" . $row['cid'] ."' class='btn btn-info '><i class='fas fa-toggle-on'></i> APPROVE</a>";
              }
              echo"</td>";
              echo "</tr>";
            }
            ?>
          </table>
        </div>
     
      </div>  
<?php
}
elseif($do == "edit")
{    
$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
    $stmt = $con->prepare("SELECT * FROM comment
    WHERE cid = ?");
    $stmt->execute(array($comid));
    $row = $stmt->fetch();
    $count =$stmt->rowCount();
    if ($stmt->rowCount() > 0)
    {
?>
  <h1 class="text-center">EDIT COMMENT</h1>
  <div class="container  ">
   <form class ="form-horizontal" action ="?do=update" method = "POST">
     <input type = "hidden" name ="comid" value = "<?php  echo $comid ?>"/>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">COMMENT </label>
        <div class ="col-sm-6">
          <textarea class='form-control' name='comment'><?php echo $row['comment'] ?></textarea>
        </div>
    </div><br>
    <div class ="form-group">
        <div class ="col-sm-offset-2 col-sm-8">
           <input type ="submit" value ="SAVE" class="btn btn-primary btn-lg gl"/>
        </div>
    </div><br>
   </form>
  </div>
<?php
    }
    else
    {
        echo "<div class ='container'>";
        $themsg = "<div class='alert alert-danger'> THERE IS NO SUCH ID </div>";
        redirecthome($themsg );
        echo "</div";
    }
}
elseif($do =='update')
{
   echo " <h1 class='text-center'>UPDATE COMMENT</h1>";
   echo "<div class= 'container'>";
   if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
      $comid   =$_POST['comid'];
      $comment  =$_POST['comment'];
     
      $stmt = $con->prepare("UPDATE comment SET comment = ?  WHERE cid = ?");
      $stmt->execute(array($comment , $comid ));
    
      $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'COMMENT UPDATED </div> ';
      
      redirecthome($themsg ,'back'); 
      
   }
   else 
   { 
     echo "<div class ='container'>";
     $themsg = "<div class='alert alert-danger'> YOU CAN NOT BROWSE THIS PAGE </div>";
     redirecthome($themsg ,'back');
     echo "</div";
   }
   echo "</div>";
}
elseif($do =='delete')
{
  echo " <h1 class='text-center'>DELETE COMMENT</h1>";
   echo "<div class= 'container'>";
  $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
  $stmt = $con->prepare("SELECT * FROM comment 
  WHERE comid = ? ");
   $check = checkitem("cid","comment","$comid");
  if ($check > 0)
  {
     $stmt = $con->prepare('DELETE FROM comment WHERE cid = :zid');
     $stmt->bindparam("zid",$comid );
     $stmt->execute();
     $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'COMMENT DELETED </div> ';
     redirecthome($themsg ); 
  }
  else
  {
    $themsg = "<div class = 'alert alert-danger'> THIS ID IS NO EXIST</div>";
    redirecthome($themsg ,'back');
  }
   echo "</div>";
}
   elseif($do =='approve')
{
  echo " <h1 class='text-center'>APPROVE COMMENT</h1>";
   echo "<div class= 'container'>";
  $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
  $stmt = $con->prepare("SELECT * FROM comment 
  WHERE cid = ?  ");
   $check = checkitem("cid","comment","$comid");
  if ($check > 0)
  {
     $stmt = $con->prepare('UPDATE comment SET status = 1 WHERE cid = ?');
     $stmt->execute(array($comid));
     $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'RECORD APPROVED </div> ';
     redirecthome($themsg ,'back');
  }
  else
  {   
    $themsg = "<div class = 'alert alert-danger'> THIS ID IS NO EXIST</div>";
    redirecthome($themsg ,'back');
  }
 }
    include "includes/templates/footer.php";
}
else
{
  header("location:index.php");
  exit();
}
?>