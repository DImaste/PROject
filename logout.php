<?php

define( 'root_page', '' );
require_once root_page . 'functions.php';

if( !IsLoggedIn() ) {
    RedirectTo( 'login.php' );
}

Logout();

DatabaseConnect();

$query = ("SELECT table_schema, table_name, create_time
				FROM information_schema.tables
				WHERE table_schema='{$_VulnWapp['db_database']}' AND table_name='users'
				LIMIT 1");
$result = @mysqli_query($GLOBALS["___mysqli_ston"],  $query );
if( mysqli_num_rows( $result ) != 1 ) {
    PushMessage( "В первый раз используете приложение?<br />Переход к установке - 'setup.php'." );
    RedirectTo( root_page . 'setup.php' );
}

$insert = "UPDATE `users` SET active=false";
if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
    PushMessage( "Не удалось деактивировать пользователя<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) ); }

PushMessage( "Вы вышли из системы!" );
RedirectTo( 'login.php' );

?>

