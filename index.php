<?php

# REMOVE! Errors showing.

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define( 'root_page', '' );
require_once root_page . 'functions.php';

PageStartup( array( 'authenticated', ' ' ) );

echo 'Welcome, '.$VulnWappSession['username'];


if(IsLoggedIn()){
    echo 'Welcome, '.$VulnWappSession['username'];
    refreshFlags();
    header("Location: myprofile.php");
    exit;
} else {

    echo 'Please LOGIN!';

}

echo "
        
    <html xmlns=\"http://www.w3.org/1999/xhtml\">	
    
    <body>	
        <br />
        <h1>Hi</h1>
        
        <br />
    </body>
    
    </html>";


?>


