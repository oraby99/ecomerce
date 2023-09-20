<?php

ini_set('display_error' , 'On');
error_reporting(E_ALL);

include "admin/connect.php";
$sessionuser = '';
if (isset($_SESSION['user'])) {
    $sessionuser = $_SESSION['user'];
 }

include  "includes/languages/english.php";
include  "includes/functions/function.php";
include  "includes/templates/header.php";


?>

