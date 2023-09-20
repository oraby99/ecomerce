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
    $sort ='ASC';
    $sortarray = array('ASC' ,'DESC' );
    if(isset($_GET['sort']) && in_array($_GET['sort'], $sortarray))
    {
        $sort = $_GET['sort'];
    }
    else 
    {
      
    }

  $stmt4= $con->prepare("SELECT *FROM category WHERE parent = 0 ORDER BY ordering $sort");
  $stmt4->execute();
  $cats = $stmt4->fetchAll();?>
  <h1 class="text-center">MANAGE CATEGORIES</h1>
  <div class="container category">
  <div class="panel panel-default">
      <div class ='ordering '>
          ORDERING CATEGORIES BY : [
         <a class="<?php if($sort == 'ASC') {echo 'active';} ?>" href='?sort=ASC'>ASC</a> |
         <a class="<?php if($sort == 'DESC') {echo 'active';} ?>" href='?sort=DESC'>DESC</a> ]
         <?php
         echo "<hr>";
         ?>
      </div>
      <div class="panel-body">
          <?php
       foreach($cats as $cat)
       {
           
            echo "<div class='cat'>";
            echo "<div class='hidden-btn'>";
            echo " <a href='category.php?do=edit&catid="  .$cat['id'] . "' class='btn  btn-info'>EDIT <i class='fa fa-edit'></i></a>";
            echo " <a href='category.php?do=delete&catid="  .$cat['id'] . "' class='confirm btn  btn-danger'>DELETE <i class='fa fa-trash'></i></a>";
            echo "</div>";
            echo "<h3>". $cat['name'] .'</h3>';
                echo "<div class='full'>";
                    echo "<p>"; if($cat['description'] == ''){ echo 'empty description';} 
                    else 
                    {
                    echo $cat['description'];
                    }
                    echo "</p>";
                        if($cat['visability'] ==1)    {echo '<span class="visability">HIDDEN</span>';} 
                        if($cat['allowcomment'] ==1){echo '<span class="comment">COMMENT DISABLE</span>';} 
                        if($cat['allowads'] ==1)    {echo '<span class="ads">ADS DISABLE</span>';} 
                echo "</div>";
           
                $getsub =getsubcat(" * " , "category" ,  "parent = {$cat['id']}" );
                if( ! empty($getsub))
                {
                   echo "</br><h6>SUB CATEGORY </h6>";
                }
                
                foreach( $getsub as $c)
                {
                echo '<li>
                <a class="navbar-brand " href ="category.php?do=edit&catid='.$c['id'].'">'. $c['name'] . '</a>
                <a class="confirm   " href ="category.php?do=delete&catid='.$c['id'].'">
                <i class="fa fa-trash "></i></a>
                </li>';
                }
             echo "</div>";
             echo "<hr>";
            //  function getsubcat($select , $table ,$where)
            //  {
            //     global $con;
            //     $getsubcat = $con->prepare("SELECT $select FROM $table  WHERE $where ");
            //     $getsubcat->execute();
            //     $cats = $getsubcat->fetchAll();
            //     return $cats;
            //  } 
           
       }
      ?>
      </div>
  </div>
  
      <a href ='category.php?do=add' class='btn btn-primary'> 
       
         NEW CATEGORY  <i class="fa fa-plus"></i></a>
     <br><br> <br><br>
  </div>
  <?php
}
elseif($do == "add")
 {?>
   <h1 class="text-center">ADD NEW CATEGORY</h1> 
   <div class="container  ">
   <form class ="form-horizontal" action ="?do=insert" method = "POST">
 
    <div class ="form-group">
        <lable class="col-sm-2 control-label"> NAME </label>
        <div class ="col-sm-6">
           <input type ="text" name ="name" class="form-control"  required ="required" autocomplete="off" placeholder="category name "/>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">DESCRIPTION </label>
        <div class ="col-sm-6"> 
        <input type ="text" name ="description" class="form-control "  placeholder="descripe the category"/>
        
      </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">ORDERING </label>
        <div class ="col-sm-6">
           <input type ="text" name ="ordering" class="form-control" 
           placeholder="number to arrange the category"/>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label"> parent ?</label>
        <div class ="col-sm-6">
          <select name = "parent">
              <option value="0">NONE</option>
              <?php 
              
            $getsubcat =  getsubcat( "*"  , "category " ," parent = 0");
            
            foreach($getsubcat as $cat)
            {
                echo "<option value='" . $cat['id']. "'>" . $cat['name'] ." </option>";
            }
        ?>
          </select>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">VISABILITY </label>
        <div class ="col-sm-6">
          <div>
              <input id ="vis-yes" type ="radio" name ="visible" value="0" checked>
              <label for="vis-yes">YES</label>
          </div>
          <div>
              <input id ="vis-no" type ="radio" name ="visible" value="1" >
              <label for="vis-no">NO</label>
          </div>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">ALLOW COMMENTING </label>
        <div class ="col-sm-6">
          <div>
              <input id ="com-yes" type ="radio" name ="comment" value="0" checked>
              <label for="com-yes">YES</label>
          </div>
          <div>
              <input id ="com-no" type ="radio" name ="comment" value="1" >
              <label for="com-no">NO</label>
          </div>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">ALLOW ADS </label>
        <div class ="col-sm-6">
          <div>
              <input id ="ads-yes" type ="radio" name ="ads" value="0" checked>
              <label for="ads-yes">YES</label>
          </div>
          <div>
              <input id ="ads-no" type ="radio" name ="ads" value="1" >
              <label for="ads-no">NO</label>
          </div>
        </div>
    </div><br>
    <div class ="form-group">

        <div class ="col-sm-offset-2 col-sm-8">
           <input type ="submit" value ="ADD CATEGORY" class="btn btn-primary btn-lg gl"/>
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
      echo " <h1 class='text-center'>UPDATE CATEGORY</h1>";
      echo "<div class= 'container'>";
       
       $name          =$_POST['name'];
       $description   =$_POST['description'];
       $parent        =$_POST['parent'];
       $ordering      =$_POST['ordering'];
       $visible       =$_POST['visible'];
       $comment       =$_POST['comment'];
       $ads           =$_POST['ads']; 
        $check = checkitem("name","category","$name");
        if($check == 1)
        {
            $themsg =  "<div class = 'alert alert-danger'>THIS CATEGORY IS ALREADY EXIST </div>";
            redirecthome($themsg ,'back');
        }
        else
        { 
$stmt = $con->prepare("INSERT INTO category(name ,description , parent,ordering ,visability ,allowcomment,allowads)
VALUES(:zname , :zdescription ,:zparent, :zordering , 
:zvisability ,:zallowcomment ,:zallowads) ");
  
         $stmt->execute(array(
              'zname'        => $name,
              'zdescription' => $description,
              'zparent'      => $parent,
              'zordering'    => $ordering,
              'zvisability'  => $visible,
              'zallowcomment'=> $comment,
              'zallowads'    => $ads
             
         ));
        $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() ." "  . 'CATEGORY INSERTED</div>';
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
   
    $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
    
        $stmt = $con->prepare("SELECT * FROM category 
        WHERE id = ? ");
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        $count =$stmt->rowCount();
        if ($stmt->rowCount() > 0)
        {
    ?>
      <h1 class="text-center">EDIT CATEGORY</h1>
      <div class="container  ">
      <form class ="form-horizontal" action ="?do=update" method = "POST">
      <input type = "hidden" name ="catid" value = "<?php  echo $catid ?>"/>
 <div class ="form-group">
     <lable class="col-sm-2 control-label"> NAME </label>
     <div class ="col-sm-6">
        <input type ="text" name ="name" class="form-control"  required ="required"  placeholder="category name " value ="<?php echo $cat['name'] ?>"/>
     </div>
 </div><br>
 <div class ="form-group">
     <lable class="col-sm-2 control-label">DESCRIPTION </label>
     <div class ="col-sm-6"> 
     <input type ="text" name ="description" class="form-control "  placeholder="descripe the category" value ="<?php echo $cat['description'] ?>"/>
     
   </div>
 </div><br>
 <div class ="form-group">
     <lable class="col-sm-2 control-label">ORDERING </label>
     <div class ="col-sm-6">
        <input type ="text" name ="ordering" class="form-control" 
        placeholder="number to arrange the category" value ="<?php echo $cat['ordering'] ?>"/>
     </div>
 </div><br>
 <div class ="form-group">
        <lable class="col-sm-2 control-label"> parent ?</label>
        <div class ="col-sm-6">
          <select name = "parent">
              <option value="0">NONE</option>
              <?php 
              
            $getsubcat =  getsubcat( "*"  , "category " ," parent = 0");
            
            foreach($getsubcat as $ca)
            {
                echo "<option value='" . $ca['id']. "'";
                if($cat['parent'] == $ca['id']) { echo "selected";}
                echo ">" . $ca['name'] . "</option>";
            }
        ?>
          </select>
        </div>
    </div><br>
 <div class ="form-group">
     <lable class="col-sm-2 control-label">VISABILITY </label>
     <div class ="col-sm-6">
       <div>
           <input id ="vis-yes" type ="radio" name ="visible" value="0" <?php if($cat['visability']== 0) {echo 'checked';} ?> >
           <label for="vis-yes">YES</label>
       </div>
       <div>
           <input id ="vis-no" type ="radio" name ="visible" value="1"<?php if($cat['visability']== 1) {echo 'checked';} ?> >
           <label for="vis-no">NO</label>
       </div>
     </div>
 </div><br>
 <div class ="form-group">
     <lable class="col-sm-2 control-label">ALLOW COMMENTING </label>
     <div class ="col-sm-6">
       <div>
           <input id ="com-yes" type ="radio" name ="comment" value="0" <?php if($cat['allowcomment']== 0) {echo 'checked';} ?>>
           <label for="com-yes">YES</label>
       </div>
       <div>
           <input id ="com-no" type ="radio" name ="comment" value="1" <?php if($cat['allowcomment']== 1) {echo 'checked';} ?>>
           <label for="com-no">NO</label>
       </div>
     </div>
 </div><br>
 <div class ="form-group">
     <lable class="col-sm-2 control-label">ALLOW ADS </label>
     <div class ="col-sm-6">
       <div>
           <input id ="ads-yes" type ="radio" name ="ads" value="0" <?php if($cat['allowads']== 0) {echo 'checked';} ?>>
           <label for="ads-yes">YES</label>
       </div>
       <div>
           <input id ="ads-no" type ="radio" name ="ads" value="1" <?php if($cat['allowads']== 1) {echo 'checked';} ?>>
           <label for="ads-no">NO</label>
       </div>
     </div>
 </div><br>
 <div class ="form-group">

     <div class ="col-sm-offset-2 col-sm-8">
        <input type ="submit" value ="SAVE CATEGORY" class="btn btn-primary"/>
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
  
    echo " <h1 class='text-center'>UPDATE CATEGORY</h1>";
    echo "<div class= 'container'>";
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
       $id           =$_POST['catid'];
       $name         =$_POST['name'];
       $description  =$_POST['description'];
       $ordering     =$_POST['ordering'];
       $parent       =$_POST['parent'];
       $visible      =$_POST['visible'];
       $comment      =$_POST['comment'];
       $ads          =$_POST['ads'];

         $stmt = $con->prepare("UPDATE category SET name = ? , description = ? , ordering = ? ,parent = ?,visability = ?
         ,allowcomment= ?,allowads= ?
          WHERE id = ?");
         $stmt->execute(array( $name , $description ,$ordering ,$parent,$visible,$comment ,$ads ,$id 
        ));
         $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'CATEGORY UPDATED </div> ';
         redirecthome($themsg ,'back');
       
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
    echo " <h1 class='text-center'>DELETE CATEGORY</h1>";
    echo "<div class= 'container'>";
   $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
   $stmt = $con->prepare("SELECT * FROM users 
   WHERE userid = ?  LIMIT 1");
    $check = checkitem("id","category","$catid");
   if ($check > 0)
   {
      $stmt = $con->prepare('DELETE FROM category WHERE id = :zid');
      $stmt->bindparam("zid",$catid );
      $stmt->execute();
      $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'RECORD DELETED </div> ';
      redirecthome($themsg,'back' );
   }
   else
   {
     $themsg = "<div class = 'alert alert-danger'> THIS ID IS NO EXIST</div>";
     redirecthome($themsg );
   }
    echo "</div>";
}
    include "includes/templates/footer.php";
}
else
{
  header("location:index.php");
  exit();
}

?>