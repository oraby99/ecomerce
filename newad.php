
<?php 

session_start();
include "init.php";

   if (isset($_SESSION['user'])) 
   {
   
       if($_SERVER['REQUEST_METHOD'] == 'POST')
       {
          $formerrors = array();
          $name        = filter_var($_POST['name'] ,       FILTER_SANITIZE_STRING);
          $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
          $price       = filter_var($_POST['price'],       FILTER_SANITIZE_NUMBER_INT);
          $country     = filter_var($_POST['country'],     FILTER_SANITIZE_STRING);
          $status      = filter_var($_POST['status'],      FILTER_SANITIZE_NUMBER_INT);
          $category    = filter_var($_POST['category'],    FILTER_SANITIZE_NUMBER_INT);
          if(strlen($name)< 4)
          {
              $formerrors[] = "name must be bigger than 4 char";
          }
          if(strlen($description)< 5)
          {
              $formerrors[] = "description must be bigger than 10 char";
          }
          if(strlen($country)< 2)
          {
              $formerrors[] = "country must be bigger than 2 char";
          }
          if(empty($price))
          {
              $formerrors[] = "price must not be empty";
          }
          if(empty($status))
          {
              $formerrors[] = "status must not be empty";
          }
          if(empty($category))
          {
              $formerrors[] = "category must not be empty";
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
                 'zmember'      => $_SESSION['uid']
            ));
          
            $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() ." "  . 'ITEM INSERTED</div><br>';
            redirecthome($themsg ,'back');
            
         } 
       }
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
<h2 class="text-center">CREATE NEW ITEM </h2>
<div class="ad block">
  <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">CREATE NEW ITEM</div>
        <div class="panel-body">
              <div class="row">
                  <div class="col-md-8">
                  <form class ="form-horizontal" action =" <?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  
     <div class ="form-group">
              <lable class="col-sm-3 control-label"> NAME </label>
              <div class ="col-sm-10">
              <input type ="text" name ="name" class="form-control livename" 
              required ="required"
              placeholder="item name "/>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-3 control-label"> DESCRIPTION </label>
            <div class ="col-sm-10">
            <input type ="text" name ="description" class="form-control livedesc"
            required ="required" 
            placeholder="item description "/>
         </div>
     </div><br>
     <div class ="form-group">
              <lable class="col-sm-3 control-label"> PRICE </label>
              <div class ="col-sm-10">
              <input type ="text" name ="price" class="form-control liveprice" 
              required ="required"
              placeholder="item price "/>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-3 control-label"> COUNTRY </label>
            <div class ="col-sm-10">
            <input type ="text" name ="country" class="form-control"
            required ="required" 
            placeholder="country made item "/>
         </div>
     </div><br>
     <div class ="form-group">
            <lable class="col-sm-3 control-label"> STATUS </label>
            <div class ="col-sm-10">
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
            <lable class="col-sm-3 control-label"> CATEGORY </label>
            <div class ="col-sm-10">
                <select  class="form-control" name="category">
                  <option value="0">SELECT CATEGORY .... </option>
                   <?php
                     $stmt2= $con->prepare("SELECT * FROM category WHERE parent = 0");
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
         <input type ="submit" value ="ADD ITEM" class="btn btn-primary xx"/>
         </div>
     </div><br>
    </form>
                    </div>
                    <div class="col-md-4 itembox">
                    <span class="price">0$</span>
                    <div class="thumbnail ">
                    <img class="" src ="image/hg.jpg" alt ="tttttstttt" />
                    <div class="caption">
                    <h3>title</h3>
                    <p> description</p>
                    </div>
                    </div>
                  </div>
              </div>
              <?php 
                if(! empty($formerrors))
                {
                    foreach ($formerrors as $error )
                     {
                        echo "<div class='alert alert-danger'>". $error."</div><br>";
                     }
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
