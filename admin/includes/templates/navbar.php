<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
<div class="container">
  <a class="navbar-brand " href="dashboard.php"> <?php echo lang("home_admin") ?></a>
  <a class="navbar-brand " href="category.php"><?php echo lang("sections") ?></a>
  <a class="navbar-brand " href="item.php"> <?php echo lang("item") ?></a>
  <a class="navbar-brand " href="member.php"><?php echo lang("member") ?></a>
  <a class="navbar-brand " href="comments.php"> <?php echo lang("comments") ?></a>
 
</div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
 
  <div class="collapse navbar-collapse  " id="navbarSupportedContent">
    <ul class="navbar-nav pos mr-auto ">
    
      <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle m-l ch" href="#" id="navbarDropdown"  role="button" data-toggle="dropdown" aria-expanded="false">
        <?php echo lang("admin") ?>
        </a>
        <div class="dropdown-menu bg " aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="../index.php" target="_blank">VISIT SHOP </a>
          <a class="dropdown-item" href="member.php?do=edit&ID=<?php echo $_SESSION['id']?>"><?php echo lang("edit") ?></a>
         
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php"> <?php echo lang("logout") ?> </a>
        </div>
      </li>
    
    </ul>
  
  </div>
</nav>

