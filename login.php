<?php
session_start();

if(isset($_SESSION["user"]))
{
    
     header("location: index.php");
}
include "init.php";
if ($_SERVER["REQUEST_METHOD"] =="POST")  {
  
    if(isset($_POST['login']))
    {
  
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $hashedpass=sha1($pass);
    $stmt = $con->prepare("SELECT userid , username , password FROM users 
    WHERE username = ? AND password = ? ");
    $stmt->execute(array($user, $hashedpass));
    $get = $stmt->fetch();
    $count =$stmt->rowCount();
    if($count > 0)
    {
      $_SESSION["user"] = $user;
      $_SESSION['uid'] = $get['userid'];
      header("location:index.php");
      exit();
            
    }
    }
    else
    {
          $formerrors  = array();
          
          if(isset($_POST['username']) )
          {
              $filtername = filter_var($_POST['username'], FILTER_SANITIZE_STRING) ;
               if(strlen($filtername)<4)
               {
                   $formerrors[] = "username can not be smaller than 4 letters";
               }
          }
          if(isset($_POST['password']) && isset($_POST['password2']))
          {
            if(empty($_POST['password'] ))
            {
               $formerrors[] = "sorry this password is empty";
            }
             $pass1 = sha1($_POST['password']);
             $pass2 = sha1($_POST['password2']);
             if($pass1 !== $pass2)
             {
                $formerrors[] = "sorry password is not match";
             }
          }
          if(isset($_POST['email']) )
          {
              $filteremail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
               if(filter_var($filteremail , FILTER_VALIDATE_EMAIL)!= true) 
               {
                   $formerrors[] = "this email is not valid";
               }
          }
          if(empty($formerrors))
          {
           $check = checkitem("username","users",$_POST['username']);
           if($check == 1)
           {
            //    $themsg =  "<div class = 'alert alert-danger'>THIS USER IS ALREADY EXIST </div>";
                  $formerrors[] = "this user is already exist";
           }
           else
           {
            $stmt = $con->prepare("INSERT INTO users(username , password  ,email  ,regstatus, Date)
             VALUES(:zuser , :zpass , :zmail , 0, now()) ");
     
            $stmt->execute(array(
                 'zuser' => $_POST["username"],
                 'zpass' => sha1($_POST["password"]),
                 'zmail' => $_POST["email"],
                
            ));
           $successmsg = "congrats you are registered user";
            
          }
         }    
    }
   }
?>
<div class="container loginpage">
    <h1 class="text-center">
        <span class=" active" data-class="login">LOGIN </span> | 
        <span data-class="signup">SIGNUP </span> 
    </h1>
    <form class="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
     <input class="form-control"   type="text"     name = "username"     autocomplete = "off" 
                                   placeholder="ENTER YOUR USERNAME"
     />
     <input class="form-control"   type="password" name = "password"     autocomplete = "new-password" 
                                   placeholder="ENTER YOUR PASSWORD"
     />
     <input class="btn btn-primary"type="submit"  name ="login" value ="LOGIN"/>
    </form>

    

    <form class="signup" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
     <input  pattern =".{4, 8}" title ="username must be biger than 4 char"
     class="form-control"   type="text"     name = "username"     autocomplete = "off" 
          required="required"      placeholder="ENTER YOUR USERNAME"
     />
     <input class="form-control"   type="password" name = "password"     autocomplete = "new-password" 
                                   placeholder="ENTER YOUR PASSWORD"
     />
     <input class="form-control"   type="password" name = "password2"     autocomplete = "new-password" 
                                   placeholder="CONFIRM YOUR PASSWORD"
     />
     <input class="form-control"   type="email"    name = "email"      
                                   placeholder="ENTER YOUR E-MAIL"
     />
     <input class="btn btn-success"type="submit" name ="signup"  value ="SIGNUP"/>
    </form>
    
         <?php  
           if(!empty($formerrors))
           {
             foreach ($formerrors as $error ) 
             {
                echo ' <div class=" alert alert-danger text-center">' .$error. '</div> ';
             }
           } 
          if(isset($successmsg))
          {
            echo ' <div class=" alert alert-success text-center">' .$successmsg. '</div> ';
          }
         ?>
    
</div>
<?php
include "includes/templates/footer.php";
?>