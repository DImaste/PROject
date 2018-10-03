<?php

# REMOVE! Errors showing.

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define( 'root_page', '' );
require_once root_page . 'functions.php';

// проверка существует ли БД, инициализирована ли она, если нет - редирект в setup

// Если авторизован, то редирект в личный профиль(myprofile) , если нет -  redirect login


session_start();



if(!$_SESSION['logged']){
    header("Location: myprofile.php");
    exit;
} else {

    echo 'Please LOGIN!';
}


echo 'Welcome, '.$_SESSION['username'];



//

//




?>

<head>
	
	<h1>Hi</h1>


</head>
