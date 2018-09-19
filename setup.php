<?php

##
## Файл создает БД для работы приложения
## 

define( 'root_page', '' );
require_once root_page . 'functions.php';

?>

<?php

# Первый способ

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

/*

$link = mysqli_connect("localhost", "root", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt create database query execution
$sql = "CREATE DATABASE demo";
if(mysqli_query($link, $sql)){
    echo "Database created successfully";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
*/
?>


<?php

# Второй способ

if( isset( $_POST[ 'create_db' ] ) ) {
	// Anti-CSRF
	checkToken( $_REQUEST[ 'user_token' ], $_SESSION[ 'session_token' ], 'setup.php' );

	if( $DBMS == 'MySQL' ) {


			if( !@($GLOBALS["___mysqli_ston"] = mysqli_connect( $_DVWA[ 'db_server' ],  $_DVWA[ 'db_user' ],  $_DVWA[ 'db_password' ] )) ) {
				dvwaMessagePush( "Could not connect to the MySQL service.<br />Please check the config file." );
				if ($_DVWA[ 'db_user' ] == "root") {
					dvwaMessagePush( 'Your database user is root, if you are using MariaDB, this will not work, please read the README.md file.' );
				}
				dvwaPageReload();
			}


			// Create database
			$drop_db = "DROP DATABASE IF EXISTS {$_DVWA[ 'db_database' ]};";
			if( !@mysqli_query($GLOBALS["___mysqli_ston"],  $drop_db ) ) {
				dvwaMessagePush( "Could not drop existing database<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				dvwaPageReload();
			}

			$create_db = "CREATE DATABASE {$_DVWA[ 'db_database' ]};";
			if( !@mysqli_query($GLOBALS["___mysqli_ston"],  $create_db ) ) {
				dvwaMessagePush( "Could not create database<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				dvwaPageReload();
			}
			dvwaMessagePush( "Database has been created." );


			// Create table 'users'
			if( !@((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $_DVWA[ 'db_database' ])) ) {
				dvwaMessagePush( 'Could not connect to database.' );
				dvwaPageReload();
			}

			$create_tb = "CREATE TABLE users (user_id int(6),first_name varchar(15),last_name varchar(15), user varchar(15), password varchar(32),avatar varchar(70), last_login TIMESTAMP, failed_login INT(3), PRIMARY KEY (user_id));";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_tb ) ) {
				dvwaMessagePush( "Table could not be created<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				dvwaPageReload();
			}
			dvwaMessagePush( "'users' table was created." );


			// Insert some data into users
			$avatarUrl  = '/hackable/users/';

			$insert = "INSERT INTO users VALUES
				('1','admin','admin','admin',MD5('password'),'{$avatarUrl}admin.jpg', NOW(), '0'),
				('2','Gordon','Brown','gordonb',MD5('abc123'),'{$avatarUrl}gordonb.jpg', NOW(), '0'),
				('3','Hack','Me','1337',MD5('charley'),'{$avatarUrl}1337.jpg', NOW(), '0'),
				('4','Pablo','Picasso','pablo',MD5('letmein'),'{$avatarUrl}pablo.jpg', NOW(), '0'),
				('5','Bob','Smith','smithy',MD5('password'),'{$avatarUrl}smithy.jpg', NOW(), '0');";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
				dvwaMessagePush( "Data could not be inserted into 'users' table<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				dvwaPageReload();
			}
			dvwaMessagePush( "Data inserted into 'users' table." );


			// Create guestbook table
			$create_tb_guestbook = "CREATE TABLE guestbook (comment_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, comment varchar(300), name varchar(100), PRIMARY KEY (comment_id));";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_tb_guestbook ) ) {
				dvwaMessagePush( "Table could not be created<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				dvwaPageReload();
			}
			dvwaMessagePush( "'guestbook' table was created." );


			// Insert data into 'guestbook'
			$insert = "INSERT INTO guestbook VALUES ('1','This is a test comment.','test');";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
				dvwaMessagePush( "Data could not be inserted into 'guestbook' table<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				dvwaPageReload();
			}
			dvwaMessagePush( "Data inserted into 'guestbook' table." );




			// Copy .bak for a fun directory listing vuln
			$conf = DVWA_WEB_PAGE_TO_ROOT . 'config/config.inc.php';
			$bakconf = DVWA_WEB_PAGE_TO_ROOT . 'config/config.inc.php.bak';
			if (file_exists($conf)) {
				// Who cares if it fails. Suppress.
				@copy($conf, $bakconf);
			}

			dvwaMessagePush( "Backup file /config/config.inc.php.bak automatically created" );

			// Done
			dvwaMessagePush( "<em>Setup successful</em>!" );

			if( !dvwaIsLoggedIn())
				dvwaMessagePush( "Please <a href='login.php'>login</a>.<script>setTimeout(function(){window.location.href='login.php'},5000);</script>" );
			dvwaPageReload();


	}
	else {
		dvwaMessagePush( 'ERROR: Invalid database selected. Please review the config file syntax.' );
		dvwaPageReload();
	}
}

# Защита от CSRF

generateSessionToken();


?>