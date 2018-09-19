<?php

define( 'functions_page', '' );
require_once root_page . './functions.php';

?>

<?php 
session_start(); 
if(!$_SESSION['logged']){ 
    header("Location: login_page.php"); 
    exit; 
} 
echo 'Welcome, '.$_SESSION['username']; 
?> 