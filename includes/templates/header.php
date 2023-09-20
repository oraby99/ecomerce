<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> E-COMMERCE </title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="layout/css/front.css" >
</head>
<body>
 <?php   
if(isset($_SESSION["user"]))
       { ?>
             <img class="myinfo" src ="image/hg.jpg" alt ="tttttstttt" />
             <div class="btn-group mr container"> 
             <span class ="btn dropdown-toggle mn" data-toggle="dropdown">
             <?php echo $_SESSION["user"] ?>
             <span class ="caret"></span>
             </span>
              <div class="test  container">
              <ul class="dropdown-menu  " aria-labelledby="navbarDropdown">
              <li><a href ='profile.php'>MY PROFILE <i class='fas fa-tag'></i></a> </li>
              <li><a href ='newad.php'> NEW ITEM <i class='fas fa-plus'></i></a></li>
              <li><a href ='profile.php#my-ads'> MY ITEMS <i class='fas fa-tag'></i></a> </li>
              <li><a href ='logout.php'> LOGOUT <i class='fas fa-sign-out-alt'></i></a></li>
              </ul>
              </div>

             </div>
         

<?php
          
       }
else
{?>
  
 <div class='upepr-bar'> 
    <div class='container '> 
      <a  href="login.php">
        <span class="pull">LOGIN/SIGNUP</span>
    </div>
    </div> 
    <?php } ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
<div class="container">
  <a class="navbar-brand " href="index.php"> HOME PAGE</a>
<ul class="nav navbar-navbar navbar-right ">
    <?php
     function getcat()
     {
        global $con;
        $getcat = $con->prepare("SELECT * FROM category WHERE parent =0 ORDER BY id DESC ");
        $getcat->execute();
        $cats = $getcat->fetchAll();
        return $cats;
     }
  
    foreach(getcat() as $cat)
    {
      echo '<li><a class="navbar-brand" href ="category.php?pageid='.$cat['id'].'" >
                                         '.$cat['name'] . '</a></li>';
    }
    ?>
</div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse  " id="navbarSupportedContent">
    <ul class="navbar-nav pos mr-auto ">
  </div>
</nav>


    
