<?php

define( 'root_page', '' );
require_once root_page . 'functions.php';

if( !IsLoggedIn() ) {
    RedirectTo( 'login.php' );
}

Logout();
PushMessage( "You have logged out" );
RedirectTo( 'login.php' );

?>
