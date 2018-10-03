<?php

##
##Файл содержит данные, необходимые для подключение к БД и некоторые функции
##

if( !defined( 'root_page' ) ) {
    die('Системная ошибка - страница с функциями не определена');
    exit;
}

##
## Подключение к базе данных MySQL
##

$DBMS = 'MySQL';

$_DVWA = array();
$_DVWA[ 'db_server' ]   = '127.0.0.1';
$_DVWA[ 'db_database' ] = 'vulnapp';
$_DVWA[ 'db_user' ]     = 'root';
$_DVWA[ 'db_password' ] = 'toor';

$_DVWA[ 'db_port '] = '5432';


##
## Запуск сессии
##

session_start(); // Creates a 'Full Path Disclosure' vuln. ??

##
## Переменные
##

if( !isset( $html ) ) {
	$html = "";
}

$DBMS_errorFunc = '';

##
## Функции
##

# Вывод сообщений

function dvwaMessagePush( $pMessage ) {
	$dvwaSession =& dvwaSessionGrab();
	if( !isset( $dvwaSession[ 'messages' ] ) ) {
		$dvwaSession[ 'messages' ] = array();
	}
	$dvwaSession[ 'messages' ][] = $pMessage;
}

function dvwaMessagePop() {
	$dvwaSession =& dvwaSessionGrab();
	if( !isset( $dvwaSession[ 'messages' ] ) || count( $dvwaSession[ 'messages' ] ) == 0 ) {
		return false;
	}
	return array_shift( $dvwaSession[ 'messages' ] );
}


function messagesPopAllToHtml() {
	$messagesHtml = '';
	while( $message = dvwaMessagePop() ) {   // TODO- sharpen!
		$messagesHtml .= "<div class=\"message\">{$message}</div>";
	}

	return $messagesHtml;
}


# Функции сессий

function checkToken( $user_token, $session_token, $returnURL ) {  # Validate the given (CSRF) token
	if( $user_token !== $session_token || !isset( $session_token ) ) {
		dvwaMessagePush( 'CSRF token is incorrect' );
		dvwaRedirect( $returnURL );
	}
}

function generateSessionToken() {  # Generate a brand new (CSRF) token
	if( isset( $_SESSION[ 'session_token' ] ) ) {
		destroySessionToken();
	}
	$_SESSION[ 'session_token' ] = md5( uniqid() );
}

function destroySessionToken() {  # Destroy any session with the name 'session_token'
	unset( $_SESSION[ 'session_token' ] );
}

function tokenField() {  # Return a field for the (CSRF) token
	return "<input type='hidden' name='user_token' value='{$_SESSION[ 'session_token' ]}' />";
}

function &dvwaSessionGrab() {
	if( !isset( $_SESSION[ 'dvwa' ] ) ) {
		$_SESSION[ 'dvwa' ] = array();
	}
	return $_SESSION[ 'dvwa' ];
}

function dvwaPageStartup( $pActions ) {
	if( in_array( 'authenticated', $pActions ) ) {
		if( !dvwaIsLoggedIn()) {
			dvwaRedirect( DVWA_WEB_PAGE_TO_ROOT . 'login.php' );
		}
	}
}

function dvwaIsLoggedIn() {
	$dvwaSession =& dvwaSessionGrab();
	return isset( $dvwaSession[ 'username' ] );
}


function dvwaLogout() {
	$dvwaSession =& dvwaSessionGrab();
	unset( $dvwaSession[ 'username' ] );
}

function dvwaCurrentUser() {
	$dvwaSession =& dvwaSessionGrab();
	return ( isset( $dvwaSession[ 'username' ]) ? $dvwaSession[ 'username' ] : '') ;
}

# Перезагрузка страницы

function dvwaPageReload() {
	dvwaRedirect( $_SERVER[ 'PHP_SELF' ] );
}

# Перенаправление

function dvwaRedirect( $pLocation ) {
	session_commit();
	header( "Location: {$pLocation}" );
	exit;
}



# Связь с базой данных

if( $DBMS == 'MySQL' ) {
	$DBMS = htmlspecialchars(strip_tags( $DBMS ));
	$DBMS_errorFunc = 'mysqli_error()';
}
else {
	$DBMS = "No DBMS selected.";
	$DBMS_errorFunc = '';
}

function dvwaDatabaseConnect() {
	global $_DVWA;
	global $DBMS;
	//global $DBMS_connError;
	global $db;

	if( $DBMS == 'MySQL' ) {
		if( !@($GLOBALS["___mysqli_ston"] = mysqli_connect( $_DVWA[ 'db_server' ],  $_DVWA[ 'db_user' ],  $_DVWA[ 'db_password' ] ))
		|| !@((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $_DVWA[ 'db_database' ])) ) {
			//die( $DBMS_connError );
			dvwaLogout();
			dvwaMessagePush( 'Unable to connect to the database.<br />' . $DBMS_errorFunc );
			dvwaRedirect( DVWA_WEB_PAGE_TO_ROOT . 'setup.php' );
		}
		// MySQL PDO Prepared Statements (for impossible levels)
		$db = new PDO('mysql:host=' . $_DVWA[ 'db_server' ].';dbname=' . $_DVWA[ 'db_database' ].';charset=utf8', $_DVWA[ 'db_user' ], $_DVWA[ 'db_password' ]);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}

	else {
		die ( "Unknown {$DBMS} selected." );
	}	
}

$PHPUploadPath    = realpath( getcwd() . DIRECTORY_SEPARATOR . root_page . "hackable" . DIRECTORY_SEPARATOR . "uploads" ) . DIRECTORY_SEPARATOR;
$PHPCONFIGPath       = realpath( getcwd() . DIRECTORY_SEPARATOR . root_page . "config");


$phpDisplayErrors = 'PHP function display_errors: <em>' . ( ini_get( 'display_errors' ) ? 'Enabled</em> <i>(Easy Mode!)</i>' : 'Disabled</em>' );                                                  // Verbose error messages (e.g. full path disclosure)
$phpSafeMode      = 'PHP function safe_mode: <span class="' . ( ini_get( 'safe_mode' ) ? 'failure">Enabled' : 'success">Disabled' ) . '</span>';                                                   // DEPRECATED as of PHP 5.3.0 and REMOVED as of PHP 5.4.0
$phpMagicQuotes   = 'PHP function magic_quotes_gpc: <span class="' . ( ini_get( 'magic_quotes_gpc' ) ? 'failure">Enabled' : 'success">Disabled' ) . '</span>';                                     // DEPRECATED as of PHP 5.3.0 and REMOVED as of PHP 5.4.0
$phpURLInclude    = 'PHP function allow_url_include: <span class="' . ( ini_get( 'allow_url_include' ) ? 'success">Enabled' : 'failure">Disabled' ) . '</span>';                                   // RFI
$phpURLFopen      = 'PHP function allow_url_fopen: <span class="' . ( ini_get( 'allow_url_fopen' ) ? 'success">Enabled' : 'failure">Disabled' ) . '</span>';                                       // RFI
$phpGD            = 'PHP module gd: <span class="' . ( ( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) ? 'success">Installed' : 'failure">Missing' ) . '</span>';                    // File Upload
$phpMySQL         = 'PHP module mysql: <span class="' . ( ( extension_loaded( 'mysqli' ) && function_exists( 'mysqli_query' ) ) ? 'success">Installed' : 'failure">Missing' ) . '</span>';                // Core DVWA
$phpPDO           = 'PHP module pdo_mysql: <span class="' . ( extension_loaded( 'pdo_mysql' ) ? 'success">Installed' : 'failure">Missing' ) . '</span>';                // SQLi
$DVWARecaptcha    = 'reCAPTCHA key: <span class="' . ( ( isset( $_DVWA[ 'recaptcha_public_key' ] ) && $_DVWA[ 'recaptcha_public_key' ] != '' ) ? 'success">' . $_DVWA[ 'recaptcha_public_key' ] : 'failure">Missing' ) . '</span>';

$DVWAUploadsWrite = '[User: ' . get_current_user() . '] Writable folder ' . $PHPUploadPath . ': <span class="' . ( is_writable( $PHPUploadPath ) ? 'success">Yes' : 'failure">No' ) . '</span>';                                     // File Upload
$bakWritable = '[User: ' . get_current_user() . '] Writable folder ' . $PHPCONFIGPath . ': <span class="' . ( is_writable( $PHPCONFIGPath ) ? 'success">Yes' : 'failure">No' ) . '</span>';   // config.php.bak check                                  // File Upload


$DVWAOS           = 'Operating system: <em>' . ( strtoupper( substr (PHP_OS, 0, 3)) === 'WIN' ? 'Windows' : '*nix' ) . '</em>';
$SERVER_NAME      = 'Web Server SERVER_NAME: <em>' . $_SERVER[ 'SERVER_NAME' ] . '</em>';                                                                                                          // CSRF

$MYSQL_USER       = 'MySQL username: <em>' . $_DVWA[ 'db_user' ] . '</em>';
$MYSQL_PASS       = 'MySQL password: <em>' . ( ($_DVWA[ 'db_password' ] != "" ) ? '******' : '*blank*' ) . '</em>';
$MYSQL_DB         = 'MySQL database: <em>' . $_DVWA[ 'db_database' ] . '</em>';
$MYSQL_SERVER     = 'MySQL host: <em>' . $_DVWA[ 'db_server' ] . '</em>';


?>
