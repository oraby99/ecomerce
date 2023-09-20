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
   $stmt = $con->prepare("SELECT item.* , category.name 
                        AS categoryname ,users.username FROM item
                        INNER JOIN category ON category.id = item.catid
                        INNER JOIN users ON users.userid = item.memberid");
   $stmt->execute();
   $items = $stmt->fetchAll();
   ?>
         <h1 class="text-center">MANAGE ITEMS</h1> 
         <div class="container  ">
           <div class='table-responsive'>
             <table class='main-table text-center table table-bordered'> 
               <tr>
                 <td>ID</td>
                 <td>ITEM NAME</td>
                 <td>DESCRIPTION</td>
                 <td>PRICE</td>
                 <td>ADDING DATE</td>
                 <td>CATEGORY</td>
                 <td>USER</td>
                 <td>CONTROL</td>
               </tr>
               <?php
               foreach($items as $item)
               {
                 echo "<tr>";
                   echo "<td>" .$item['itemid'] ."</td>";
                   echo "<td>" .$item['name'] ."</td>";
                   echo "<td>" .$item['description'] ."</td>";
                   echo "<td>" .$item['price'] ."</td>";
                   echo "<td>" .$item['adddate'] ."</td>";
                   echo "<td>" .$item['categoryname'] ."</td>";
                   echo "<td>" .$item['username'] ."</td>";
                   echo "<td>
                       <a href ='item.php?do=edit&itemid="   . $item['itemid'] ."' class='btn btn-success'>
                       <i class='fa fa-edit'></i> EDIT</a>
                       <a href ='item.php?do=delete&itemid=" . $item['itemid'] ."' class='btn btn-danger confirm'>
                       <i class='fas fa-backspace'></i> DELETE</a>";
                        if($item['approve'] == 0)
                        {
                        echo " <a href ='item.php?do=approve&itemid=" . $item['itemid'] ."' class='btn btn-info '>
                        <i class='fas fa-toggle-on'></i> APPROVE</a>";
                        }
                    echo"</td>";
                    echo "</tr>";
               }
               ?>
            
           
           
             </table>
           </div>
         <a href ='item.php?do=add' class='btn btn-primary'> 
           <i class="fa fa-plus"></i>
            NEW ITEM </a>
         </div>
        
   <?php
}
elseif($do == "add")
 {
    ?>
    <h1 class="text-center">ADD NEW ITEM</h1> 
    <div class="container  ">
    <form class ="form-horizontal" action ="?do=insert" method="POST">
  
     <div class ="form-group">
              <lable class="col-sm-2 control-label"> NAME </label>
              <div class ="col-sm-6">
              <input type ="text" name ="name" class="form-control" 
              required ="required"
              placeholder="item name "/>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> DESCRIPTION </label>
            <div class ="col-sm-6">
            <input type ="text" name ="description" class="form-control"
            required ="required" 
            placeholder="item description "/>
         </div>
     </div><br>
     <div class ="form-group">
              <lable class="col-sm-2 control-label"> PRICE </label>
              <div class ="col-sm-6">
              <input type ="text" name ="price" class="form-control" 
              required ="required"
              placeholder="item price "/>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> COUNTRY </label>
            <div class ="col-sm-6">
            <input type ="text" name ="country" class="form-control"
            required ="required" 
            placeholder="country made item "/>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> STATUS </label>
            <div class ="col-sm-6">
                <select class="form-control"  name="status">
                  <option value="0">SELECT STATUS .... </option>
                  <option value="1">NEW </option>
                  <option value="2">LIKE NEW </option>
                  <option value="3">USED </option>
                  <option value="4">OLD </option>
                </select>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> MEMBER </label>
            <div class ="col-sm-6">
                <select  class="form-control" name="member">
                  <option value="0">SELECT MEMBER .... </option>
                   <?php
                     $stmt= $con->prepare("SELECT * FROM users");
                     $stmt->execute();
                     $users = $stmt->fetchAll();
                     foreach($users as $user)
                     {
                         echo "<option value = '" . $user['userid']." '>".$user['username']."</option>";
                     }
                   ?>
                </select>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> CATEGORY </label>
            <div class ="col-sm-6">
                <select  class="form-control" name="category">
                  <option value="0">SELECT CATEGORY .... </option>
                   <?php
                     $stmt2= $con->prepare("SELECT * FROM category WHERE parent =0");
                     $stmt2->execute();
                     $cats = $stmt2->fetchAll();
                     foreach($cats as $cat)
                     {
                         echo "<option value = '" . $cat['id']." '>".$cat['name']."</option>";
                     }
                   ?>
                </select>
         </div>
     </div><br>
     <div class ="form-group">
         <div class ="col-sm-offset-2 col-sm-8">
         <input type ="submit" value ="ADD ITEM" class="btn btn-primary btn-lg gl"/>
         </div>
     </div><br>
    </form>
   </div>
   <?php
 }
elseif($do == "insert")
{
 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      echo " <h1 class='text-center'>INSERT ITEM</h1>";
      echo "<div class= 'container'>";
       
       $name          =$_POST['name'];
       $description   =$_POST['description'];
       $price         =$_POST['price'];
       $country       =$_POST['country'];
       $status        =$_POST['status'];
       $category      =$_POST['category'];
       $member        =$_POST['member'];
       $formerrors =array();
       if(empty($name))
       {
         $formerrors[] = " please enter your name ";
       }
       if(empty($description))
       {
         $formerrors[] = "please descripe the item ";
       } 
       if(empty($price))
       {
         $formerrors[] = "please enter price of item ";
       }
       if(empty($country))
       {
         $formerrors[] = "please enter country that made item ";
       }
       if($status < 1)
       {
         $formerrors[] = "please enter status of item ";
       }
       if($member < 1)
       {
         $formerrors[] = "please enter member who will add item ";
       }
       if($category < 1)
       {
         $formerrors[] = "please enter category of item ";
       }
       foreach($formerrors as $error )
       {
         echo  "<div class = 'alert alert-danger'> " .$error . '</div>';
       }
       
       if(empty($formerrors))
       {
        
         $stmt = $con->prepare("INSERT INTO item(name , description , price , 
         country ,status , adddate , catid, memberid)
          VALUES(:zname, :zdescription , :zprice , :zcountry , :zstatus , now() ,:zcategory ,:zmember )");
           $stmt->execute(array(
              'zname'        => $name,
              'zdescription' => $description,
              'zprice'       => $price,
              'zcountry'     => $country,
              'zstatus'      => $status,
              'zcategory'    => $category,
              'zmember'      => $member
         ));
        $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() ." "  . 'ITEM INSERTED</div>';
         redirecthome($themsg ,'back');
      }  
    }
    else 
    {
      echo "<div class ='container'>";
      $themsg = "<div class = 'alert alert-danger'>YOU CAN NOT BROWSE THIS PAGE</div>" ;
      redirecthome($themsg ,'back');
      echo "</div>";
    }
    echo "</div>";
}
elseif($do == "edit")
{
   
$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

$stmt = $con->prepare("SELECT * FROM item 
WHERE itemid = ?  ");
$stmt->execute(array($itemid));
$item = $stmt->fetch();
$count =$stmt->rowCount();
if ($stmt->rowCount() > 0)
{
?>
 <h1 class="text-center">EDIT ITEM</h1> 
    <div class="container  ">
    <form class ="form-horizontal" action ="?do=update" method="POST">
    <input type = "hidden" name ="itemid" value = "<?php  echo $itemid ?>"/>
     <div class ="form-group">
              <lable class="col-sm-2 control-label"> NAME </label>
              <div class ="col-sm-6">
              <input type ="text" name ="name" class="form-control" 
              required ="required"
              placeholder="item name "
              value="<?php echo $item['name'] ?>"
              />
             
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> DESCRIPTION </label>
            <div class ="col-sm-6">
            <input type ="text" name ="description" class="form-control"
            required ="required" 
            placeholder="item description "
            value="<?php echo $item['description'] ?>"
            />
         </div>
     </div><br>
     <div class ="form-group">
              <lable class="col-sm-2 control-label"> PRICE </label>
              <div class ="col-sm-6">
              <input type ="text" name ="price" class="form-control" 
              required ="required"
              placeholder="item price "
              value="<?php echo $item['price'] ?>"
              />
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> COUNTRY </label>
            <div class ="col-sm-6">
            <input type ="text" name ="country" class="form-control"
            required ="required" 
            placeholder="country made item "
            value="<?php echo $item['country'] ?>"
            />
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> STATUS </label>
            <div class ="col-sm-6">
                <select class="form-control"  name="status">
                  <!-- <option value="0">SELECT STATUS .... </option> -->
                  <option value="1" <?php if($item['status']==1) {echo 'selected';} ?> >NEW </option>
                  <option value="2" <?php if($item['status']==2) {echo 'selected';} ?>>LIKE NEW </option>
                  <option value="3" <?php if($item['status']==3) {echo 'selected';} ?>>USED </option>
                  <option value="4" <?php if($item['status']==4) {echo 'selected';} ?>>OLD </option>
                </select>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> MEMBER </label>
            <div class ="col-sm-6">
                <select  class="form-control" name="member">
                  <!-- <option value="0">SELECT MEMBER .... </option> -->
                   <?php
                     $stmt= $con->prepare("SELECT * FROM users");
                     $stmt->execute();
                     $users = $stmt->fetchAll();
                     foreach($users as $user)
                     {
                       echo "<option value = '" . $user['userid']."'";
                       if ($item['memberid'] ==$user['userid']) {echo 'selected';}
                       echo ">" .$user['username'] . "</option>";
                     }
                   ?>
                </select>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-2 control-label"> CATEGORY </label>
            <div class ="col-sm-6">
                <select  class="form-control" name="category">
                  <!-- <option value="0">SELECT CATEGORY .... </option> -->
                   <?php
                     $stmt2= $con->prepare("SELECT * FROM category WHERE parent =0");
                     $stmt2->execute();
                     $cats = $stmt2->fetchAll();
                     foreach($cats as $cat)
                     {
                        
                       echo "<option value = '" . $cat['id']."'";
                       if ($item['catid'] ==$cat['id']) {echo 'selected';}
                       echo ">" .$cat['name'] . "</option>";
                     }
                   ?>
                </select>
         </div>
     </div><br>
     <div class ="form-group">
         <div class ="col-sm-offset-2 col-sm-8">
         <input type ="submit" value ="SAVE ITEM" class="btn btn-primary btn-lg gl"/>
         </div>
     </div><br>
    </form>
    <?php
$stmt = $con->prepare("SELECT comment.* , users.username AS member
                       FROM comment 
                     
                       INNER JOIN users ON users.userid = comment.userid
                       WHERE itemid = ?
                       ");
$stmt->execute(array ($itemid));
$rows = $stmt->fetchAll();
if(! empty($rows))
{

?>
      <h1 class="text-center">MANAGE [<?php echo $item['name'] ?>] COMMENT</h1> 
     
        <div class='table-responsive'>
          <table class='main-table text-center table table-bordered'> 
            <tr>
              
              <td>COMMENT</td>
              <td>USER NAME</td>
              <td> ADDED DATE</td>
              <td>CONTROL</td>
            </tr>
            <?php
            foreach($rows as $row)
            {
              echo "<tr>";
           
                echo "<td>" .$row['comment'] ."</td>";
               
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
    <?php } ?>
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
    echo " <h1 class='text-center'>UPDATE ITEM</h1>";
    echo "<div class= 'container'>";
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
       $id           =$_POST['itemid'];
       $name         =$_POST['name'];
       $description  =$_POST['description'];
       $price        =$_POST['price'];
       $country      =$_POST['country'];
       $status       =$_POST['status'];
       $member       =$_POST['member'];
       $category     =$_POST['category'];
      
       $formerrors =array();
       if(empty($name))
       {
         $formerrors[] = " please enter your name ";
       }
       if(empty($description))
       {
         $formerrors[] = "please descripe the item ";
       } 
       if(empty($price))
       {
         $formerrors[] = "please enter price of item ";
       }
       if(empty($country))
       {
         $formerrors[] = "please enter country that made item ";
       }
       if($status < 1)
       {
         $formerrors[] = "please enter status of item ";
       }
       if($member < 1)
       {
         $formerrors[] = "please enter member who will add item ";
       }
       if($category < 1)
       {
         $formerrors[] = "please enter category of item ";
       }
       foreach($formerrors as $error )
       {
         echo  "<div class = 'alert alert-danger'> " .$error . '</div>';
       }
       if(empty($formerrors))
       {
         $stmt = $con->prepare("UPDATE item SET
          name = ? , description = ? , price = ? ,
          country= ? , status =? , memberid = ? ,catid =?
          WHERE itemid = ?");
         $stmt->execute(array($name , $description , $price ,$country ,$status , $member , $category ,$id ));
         $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'ITEM UPDATED </div> ';
         redirecthome($themsg ,'back');
       }
    }
    else 
    { 
      echo "<div class ='container'>";
      $themsg = "<div class='alert alert-danger'> YOU CAN NOT BROWSE THIS PAGE </div>";
      redirecthome($themsg );
      echo "</div";
    }
    echo "</div>";
 }

elseif($do =='delete')
{
    echo " <h1 class='text-center'>DELETE ITEM</h1>";
    echo "<div class= 'container'>";
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
    $check = checkitem("itemid","item",$itemid);
   if ($check > 0)
   {
      $stmt = $con->prepare('DELETE FROM item WHERE itemid = :zitem');
      $stmt->bindparam("zitem",$itemid );
      $stmt->execute();
      $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'ITEM DELETED </div> ';
      redirecthome($themsg,'back' ); 
   }
   else
   {
     $themsg = "<div class = 'alert alert-danger'> THIS ID IS NO EXIST</div>";
     redirecthome($themsg );
   }
    echo "</div>";
}
elseif($do =='approve')
{
    echo " <h1 class='text-center'>APPROVE ITEM</h1>";
    echo "<div class= 'container'>";
   $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
    $check = checkitem("itemid","item","$itemid");
   if ($check > 0)
   {
      $stmt = $con->prepare('UPDATE item SET approve = 1 WHERE itemid = ?');
      $stmt->execute(array($itemid));
      $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'ITEM APPROVED </div> '; 
      redirecthome($themsg );    
   }
   else
   {
     $themsg = "<div class = 'alert alert-danger'> THIS ID IS NO EXIST</div>";
     redirecthome($themsg );
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