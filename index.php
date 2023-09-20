
<?php 

session_start();

include "init.php";
?>

<div class ='container'> 

<div class ='row'>

<?php  
$allads = getall('item' ,'where approve = 1');
echo " <h1 class='text-center'>ALL ITEMS </h1>";
  foreach($allads as $item )
  {
       
            echo '<div class="itembox col-sm-6 col-md-4">';
             echo '<span class="price">'. $item['price'].'$'.'</span>';
            echo '<div class="thumbnail ">';
            echo '<img class="" src ="image/hg.jpg" alt ="tttttstttt" />';
            echo '<div class="caption">';
            echo '<h3><a href = "items.php?itemid=' .$item["itemid"]. '">'. $item['name'].'</h3></a>';
            echo '<p> '. $item['description'].'</p>';
            echo '<p> '. $item['adddate'].'</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
  }
?>
</div>

</div>
<?php

include "includes/templates/footer.php";
?>
