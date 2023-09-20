<?php
 function lang( $phrase )
 {
   static $lang = array(
    "home_admin" => "Home",
    "sections" => "Categories",
    "admin" => "ORABII",
    "edit" => "Edit profile",
    "settings" => "Settings",
    "logout" => "Log out",
    "item" => "Items",
    "member" => "Members",
    "statistic" => "Statistics",
    "log" => "Logs",
    "comments" => "Comments"
    
   );
   return $lang[$phrase];
 }
?>