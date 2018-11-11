<?php

define( 'root_page', '' );
require_once root_page . '../../../functions.php';


if( !IsLoggedIn() ) {
    PushMessage( "Пожалуйста, авторизуйтесь!" );
    RedirectTo( 'login.php' );
}

#if (!isset($_COOKIE['reserve']))
if ($_COOKIE['reserve']=='day')
{
    echo "
    
    
    ";

    getFlag(0);
}
else
{
    echo "
    
    
    ";
}





?>