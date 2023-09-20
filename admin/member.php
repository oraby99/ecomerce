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
 $query ='';
 if(isset($_GET['page']) && $_GET['page'] =='pending')
 {
  $query = 'AND regstatus = 0';
 }
$stmt = $con->prepare("SELECT * FROM users WHERE groupid != 1 $query");
$stmt->execute();
$rows = $stmt->fetchAll();
?>
      <h1 class="text-center">MANAGE MEMBERS</h1> 
      <div class="container  ">
        <div class='table-responsive'>
          <table class='main-table mngmember text-center table table-bordered'> 
            <tr>
              <td>ID</td>
              <td>AVATAR</td>
              <td>USERNAME</td>
              <td>EMAIL</td>
              <td>FULLNAME</td>
              <td> REGISTERED DATE</td>
              <td>CONTROL</td>
            </tr>
            <?php
            foreach($rows as $row)
            {
              echo "<tr>";
                echo "<td>" .$row['userid'] ."</td>";
                echo "<td>";
                  if(empty($row['avatar'])) 
                   {
                     echo "NO IMAGE ";
                    }
                  else {echo "<img src = 'upload/avatar/" .$row['avatar'] ."' alt = 'no image' />" ;}
                echo"</td>";
                echo "<td>" .$row['username'] ."</td>";
                echo "<td>" .$row['email'] ."</td>";
                echo "<td>" .$row['fullname'] ."</td>";
                echo "<td>" .$row['Date']           ."</td>";
                echo "<td>
                    <a href ='member.php?do=edit&ID="   . $row['userid'] ."' class='btn btn-success'><i class='fa fa-edit'></i> EDIT</a>
                    <a href ='member.php?do=delete&ID=" . $row['userid'] ."' class='btn btn-danger confirm'><i class='fas fa-backspace'></i> DELETE</a>";
              if($row['regstatus'] == 0)
              {
               echo " <a href ='member.php?do=activate&ID=" . $row['userid'] ."' class='btn btn-info '><i class='fas fa-toggle-on'></i> ACTIVATE</a>";
              }
              echo"</td>";
              echo "</tr>";
            }
            ?>
         
        
        
          </table>
        </div>
      <a href ='member.php?do=add' class='btn btn-primary'> 
        <i class="fa fa-plus"></i>
         NEW MEMBER </a>
      </div>
     
<?php
}
elseif($do == "add")
 {?>
   <h1 class="text-center">ADD NEW MEMBER</h1> 
   <div class="container  ">
   <form class ="form-horizontal" action ="?do=insert" method = "POST" enctype ="multipart/form-data">
 
    <div class ="form-group">
        <lable class="col-sm-2 control-label">USER NAME </label>
        <div class ="col-sm-6">
           <input type ="text" name ="username" class="form-control"  required ="required" autocomplete="off" placeholder="username to login"/>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">PASSWORD </label>
        <div class ="col-sm-6">
          
           
        <input type ="password" name ="password" required ="required" class="form-control password"  autocomplete ="new-password" placeholder="password must be complex"/>
        <i class="show-pass fa fa-eye "></i>
      </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">EMAIL </label>
        <div class ="col-sm-6">
           <input type ="email" name ="email"  required ="required" class="form-control" placeholder="must be valid email"/>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">FULL NAME </label>
        <div class ="col-sm-6">
           <input type ="text" name ="fullname" required ="required"  class="form-control" placeholder="the name that will apear in your profile"/>
        </div>
    </div><br>

    <div class ="form-group">
        <lable class="col-sm-2 control-label">USER IMAGE </label>
        <div class ="col-sm-6">
           <input type ="file" name ="avatar" 
           class="form-control"/>
        </div>
    </div><br>

    <div class ="form-group">
        <div class ="col-sm-offset-2 col-sm-8">
           <input type ="submit" value ="ADD MEMBER" class="btn btn-primary btn-lg gl"/>
        </div>
    </div><br>
   </form>
  </div>
<?php
}
elseif($do == "insert")
{
  // echo $_POST['username'] .$_POST['password'] .$_POST['email'] .$_POST['fullname'];
 
  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    echo " <h1 class='text-center'>UPDATE MEMBER</h1>";
    echo "<div class= 'container'>";
     
    // $avatar         = $_FILES['avatar'];

    $avatarname           = $_FILES['avatar']['name'];
    $avatarsize           = $_FILES['avatar']['size'];
    $avatartmp_name       = $_FILES['avatar']['tmp_name'];
    $avatartype           = $_FILES['avatar']['type'];
    $avatarallowextention = array("jpeg" , "jpg" , "png" , "gif" , "jfif");
    $imgtst               = explode('.' , $avatarname);
    $imgtst2              = end($imgtst);
    $avatarextention      = strtolower($imgtst2);

     $user  =$_POST['username'];
     $pass  =$_POST['password'];
     $email =$_POST['email'];
     $name  =$_POST['fullname'];
     $hashpass  =sha1($_POST['password']);
     $formerrors =array();
     if(empty($user))
     {
       $formerrors[] = " please enter your username ";
       // echo "please enter your username";
     }
     if(empty($name))
     {
       $formerrors[] = "fullname can not be empty ";
       
     } 
     if(empty($pass))
     {
       $formerrors[] = "please enter your password ";
     }

     if(empty($email))
     {
       $formerrors[] = "please enter your email ";
     }
     if(! in_array($avatarextention ,$avatarallowextention))
     {
      $formerrors[] = "please enter allowed extention ";
     }
     if(empty($avatarname))
     {
      $formerrors[] = "please choose file ";
     }
     if($avatarsize > 4194304 )
     {
      $formerrors[] = "please enter allowed size <= 4MB";
     }
     foreach($formerrors as $error )
     {
       echo  "<div class = 'alert alert-danger'> " .$error . '</div>';
     }

     if(empty($formerrors))
     {
       $avatar = rand(0 , 1000000) . '_' . $avatarname;
       move_uploaded_file($avatartmp_name , "upload\avatar\\" . $avatar);

      $check = checkitem("username","users","$user");
      if($check == 1)
      {
          $themsg =  "<div class = 'alert alert-danger'>THIS USER IS ALREADY EXIST </div>";
          redirecthome($themsg ,'back');
      }
      else
      {
       $stmt = $con->prepare("INSERT INTO users(username , password  ,email , fullname ,regstatus,Date ,avatar)
        VALUES(:zuser , :zpass , :zmail , :zname ,0, now(), :zavatar )");

       $stmt->execute(array(
            'zuser'   => $user,
            'zpass'   => $hashpass,
            'zmail'   => $email,
            'zname'   => $name,
            'zavatar' => $avatar,
       ));
      $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() ." "  . 'RECORD INSERTED</div>';
       redirecthome($themsg ,'back');
     }
    }    
  }
  else 
  {
    echo "<div class ='container'>";
    $themsg = "<div class = 'alert alert-danger'>YOU CAN NOT BROWSE THIS PAGE</div>" ;
    redirecthome($themsg );
    echo "</div>";
  }
  echo "</div>";
}
elseif($do == "edit")
{
    
$user = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 ;

    $stmt = $con->prepare("SELECT * FROM users 
    WHERE userid = ?  LIMIT 1");
    $stmt->execute(array($user));
    $row = $stmt->fetch();
    $count =$stmt->rowCount();
    if ($stmt->rowCount() > 0)
    {
?>
  <h1 class="text-center">EDIT MEMBER</h1>
  <div class="container  ">
   <form class ="form-horizontal" action ="?do=update" method = "POST">
     <input type = "hidden" name ="userid" value = "<?php  echo $user ?>"/>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">USER NAME </label>
        <div class ="col-sm-6">
           <input type ="text" name ="username" class="form-control" value="<?php echo $row['username'] ?>" required ="required" autocomplete="off"/>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">PASSWORD </label>
        <div class ="col-sm-6">
           <input type ="hidden" name ="oldpassword"  value="<?php echo $row['password'] ?>"/>
           <input type ="password" name ="newpassword" class="form-control"  autocomplete ="new-password" placeholder="leave blank if you don't want to change"/>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">EMAIL </label>
        <div class ="col-sm-6">
           <input type ="email" name ="email" value="<?php echo $row['email'] ?>" required ="required" class="form-control"/>
        </div>
    </div><br>
    <div class ="form-group">
        <lable class="col-sm-2 control-label">FULL NAME </label>
        <div class ="col-sm-6">
           <input type ="text" name ="fullname" value="<?php echo $row['fullname'] ?>" class="form-control"/>
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
  
   echo " <h1 class='text-center'>UPDATE MEMBER</h1>";
   echo "<div class= 'container'>";
   if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
      $id    =$_POST['userid'];
      $user  =$_POST['username'];
      $email =$_POST['email'];
      $name  =$_POST['fullname'];
      $pass  ="";
      if(empty($_POST['newpassword']))
      {
          $pass = $_POST['oldpassword'];
      }
      else 
      {
        $pass = sha1($_POST['newpassword']);
      }
      $formerrors =array();
      if(empty($user))
      {
        $formerrors[] = "<div class = 'alert alert-danger'> please enter your username </div>";
        // echo "please enter your username";
      }
      if(empty($name))
      {
        $formerrors[] = "<div class = 'alert alert-danger'> fullname can not be empty </div>";
        
        
      } 
      if(empty($email))
      {
        $formerrors[] = "<div class = 'alert alert-danger'> please enter your email </div>";
      }

      foreach($formerrors as $error )
      {
        echo $error ;
      }
      if(empty($formerrors))
      {
        $stmt6 =$con->prepare("SELECT  * FROM users WHERE username = ? AND userid != ?");
        $stmt6->execute(array($user , $id));
        $count = $stmt6->rowCount();
        if( $count ==1)
        {
          $themsg = "<div class = 'alert alert-danger'> THIS USER IS ALREADY EXIST</div>";
          redirecthome($themsg ,'back');
        }
else
{
        $stmt = $con->prepare("UPDATE users SET username = ? , email = ? , fullname = ? ,password= ? WHERE userid = ?");
        $stmt->execute(array($user , $email , $name ,$pass ,$id ));
        $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'RECORD UPDATED </div> ';
        redirecthome($themsg ,'back');
}
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
  echo " <h1 class='text-center'>DELETE MEMBER</h1>";
   echo "<div class= 'container'>";
  $user = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 ;
  $stmt = $con->prepare("SELECT * FROM users 
  WHERE userid = ?  LIMIT 1");
   $check = checkitem("userid","users","$user");
  // $stmt->execute(array($user));

  // $row = $stmt->fetch();
  // $count =$stmt->rowCount();
  if ($check > 0)
  {
     $stmt = $con->prepare('DELETE FROM users WHERE userid = :zuser');
     $stmt->bindparam("zuser",$user );
     $stmt->execute();
     $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'RECORD DELETED </div> ';
     
    
     redirecthome($themsg );
    
  }
  else
  {
    // echo "<div class = 'alert alert-danger'>"  THIS ID IS NO EXIST . ' </div> ';
    $themsg = "<div class = 'alert alert-danger'> THIS ID IS NO EXIST</div>";
    redirecthome($themsg );

  }
   echo "</div>";
}
   elseif($do =='activate')
{
  echo " <h1 class='text-center'>ACTIVATE MEMBER</h1>";
   echo "<div class= 'container'>";
  $user = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0 ;
  $stmt = $con->prepare("SELECT * FROM users 
  WHERE userid = ?  LIMIT 1");
   $check = checkitem("userid","users","$user");
  // $stmt->execute(array($user));

  // $row = $stmt->fetch();
  // $count =$stmt->rowCount();
  if ($check > 0)
  {
     $stmt = $con->prepare('UPDATE users SET regstatus = 1 WHERE userid = ?');
    //  $stmt->bindparam("zuser",$user );
     $stmt->execute(array($user));
     $themsg = "<div class = 'alert alert-success'>"  . $stmt->rowCount() . " " . 'RECORD ACTIVATED </div> ';
     
    
     redirecthome($themsg );
    
  }
  else
  {
    // echo "<div class = 'alert alert-danger'>"  THIS ID IS NO EXIST . ' </div> ';
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