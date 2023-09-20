
<?php 

session_start();
include "init.php";

   if (isset($_SESSION['user'])) 
   {
    $getuser = $con->prepare('SELECT * FROM users WHERE username =?');
    $getuser->execute(array($sessionuser));
    $info = $getuser->fetch();
    
?>

<?php
function getitem($where , $value )
{
   global $con;
   $getitem = $con->prepare("SELECT * FROM item WHERE $where = ? ORDER BY itemid DESC ");
   $getitem->execute(array($value));
   $item = $getitem->fetchAll();
   return $item;
}
?>
<h2 class="text-center">MY PROFILE </h2>
<div class="information block">
  <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">MY INFORMATION</div>
        <div class="panel-body">
            <ul class="list-unstyled">
            <li> <i class=" fa fa-unlock-alt "></i>
                <span>LOGIN NAME              </span>        :     <?php echo  $info['username'] ?> </li>
            <li><i class="fas fa-envelope"></i>
                <span> EMAIL             <span>         :     <?php echo  $info['email'] ?>    </li>
            <li> <i class="fa fa-user"></i>
                <span> FILL NAME         </span>        :     <?php echo  $info['fullname'] ?> </li>
            <li> <i class="fa fa-calendar"></i>
                <span> DATE              </span>        :     <?php echo  $info['Date'] ?>     </li>
            <!-- <li> <i class="fa fa-tag"></i>
                <span> FAVORITE CATEGORY </span>        :                                      </li> -->
          </ul>
          <!-- <a href = "#" class ="btn btn-primary">EDIT INFORMATION</a> -->
        </div>
    </div>
  </div>
</div>
<div id="my-ads" class="my-ads block">
  <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">MY ADVERTISEMENTS</div>
        <div class="panel-body">
        

<?php  
if(! empty(getitem( 'memberid',$info['userid'])))
{
    echo "<div class ='row'>";
  foreach(getitem( 'memberid',$info['userid'] ,1) as $item)
  {
       
            echo '<div class="itembox col-sm-6 col-md-4">';
            echo '<span class="price">'. $item['price'].'$'.'</span>';
            echo '<div class="thumbnail ">';
            
            echo '<img class="" src ="image/hg.jpg" alt ="tttttstttt" />';
            echo '<div class="caption">';
            if($item['approve'] ==0 ) {echo "<span class='sp'> waiting approval </span>";}
            echo '<h3><a href = "items.php?itemid=' .$item["itemid"]. '">'. $item['name'].'</a></h3>';
            echo '<p> '. $item['description'].'</p>';
            echo '<div class = "date"> '. $item['adddate'].'</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
  }
}
  else
  {
    echo "THERE IS NO ADS TO SHOW , CREATE <a href ='newad.php'>NEW ITEM</a> ";
  }

?>
</div>
        </div>
    </div>
  </div>
</div>
<div class="my-comment block">
  <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading text-center"> COMMENTS </div>
        <div class="panel-body">
            <?php
                $stmt = $con->prepare("SELECT comment
                FROM comment 
                WHERE userid = ?");
                $stmt->execute(array ($info['userid']));
                $rows = $stmt->fetchAll();
                if(!empty($rows))
                {
                    foreach ($rows as $row )
                     {
                        echo '<p>' . $row['comment'] . '</p>';
                     }
                }
                else
                {
                    echo "THERE IS NO COMMENTS TO SHOW";
                }
            ?>
        </div>
    </div>
  </div>
</div>
<?php
       
    }
else
{
    header("location : login.php");
    exit();
}
include "includes/templates/footer.php";
?>
