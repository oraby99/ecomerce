<?php
 function lang( $phrase )
 {
   static $lang = array(

    "message" => "welcome in arabic",
    "admin" => "arabic administrator "
   );
   return $lang[$phrase];
 }
?>