
<?php 
session_start();
$nonav ="";
$pagetitle ="login";
if(isset($_SESSION["username"]))
{
    //  header("location:dashboard.php");
     
}

include "init.php";
include "includes/templates/header.php";

if ($_SERVER["REQUEST_METHOD"] =="POST")  {
  $username = $_POST["user"];
  $password = $_POST["pass"];
  $hashedpass=sha1($password);
  
  $stmt = $con->prepare("SELECT userid, username , password FROM users 
  WHERE username = ? AND password = ? AND groupid = 1 LIMIT 1");
  $stmt->execute(array($username , $hashedpass));
  $row = $stmt->fetch();
  $count =$stmt->rowCount();
  if($count > 0)
  {
    $_SESSION["username"] = $username;
    $_SESSION["id"] = $row['userid'];
    header("location:dashboard.php");
    exit();
  }
}
?>
   <form class ="login" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
     <h5 class = "text-center">ADMIN LOGIN</h5>
     <input class="form-control " type ="text" name = "user" placeholder ="username" autocomplete="off" />
     <input class="form-control " type ="password" name = "pass" placeholder ="password" autocomplete="new-password"/>
     <input class="btn  btn-block" type ="submit" value = "LOGIN" />
   </form>
<?php 
include "includes/templates/footer.php";
?>
