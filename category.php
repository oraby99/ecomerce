
<?php 

include "init.php"; ?>

<div class ='container'> 
<h1 class='text-center'>CATEGORY</h1>
<div class ='row'>

<?php  
  foreach(getitem( 'catid',$_GET['pageid']) as $item)
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

// function getcat()
// {
//    global $con;
//    $getcat = $con->prepare("SELECT * FROM category ORDER BY id ASC ");
//    $getcat->execute();
//    $cats = $getcat->fetchAll();
//    return $cats;
// }
function getitem($where , $value , $approve =NULL)
{
   global $con;
   if($approve == NULL)
   {
     $sql = "AND approve = 1";
   }
   else
   {
    $sql = NULL;
   }
   $getitem = $con->prepare("SELECT * FROM item WHERE $where = ? $sql ORDER BY itemid DESC ");
   $getitem->execute(array($value));
   $item = $getitem->fetchAll();
   return $item;
}
include "includes/templates/footer.php";
?>
