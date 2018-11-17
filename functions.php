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

# DELETE IF CONFIG FILE IS RIGHT WORKING

	require 'config/DBconfig.php';

$DBMS = 'MySQL';

/*
$_VulnWapp = array();
$_VulnWapp[ 'db_server' ]   = 'localhost';
$_VulnWapp[ 'db_database' ] = 'vulnapp';
$_VulnWapp[ 'db_user' ]     = 'creator';
$_VulnWapp[ 'db_password' ] = 'toor';

$_VulnWapp[ 'db_port '] = '3306';
*/

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

$flags = array();
refreshFlags();


$sessionuser;

##
## Функции
##

# Вывод сообщений

function PushMessage( $pMessage ) {
    $VulnWappSession =& VulnWappSessionGet();
	if( !isset( $VulnWappSession[ 'messages' ] ) ) {
        $VulnWappSession[ 'messages' ] = array();
	}
    $VulnWappSession[ 'messages' ][] = $pMessage;
}






function MessagePop() {
	$VulnWappSession =& VulnWappSessionGet();
	if( !isset( $VulnWappSession[ 'messages' ] ) || count( $VulnWappSession[ 'messages' ] ) == 0 ) {
		return false;
	}
	return array_shift( $VulnWappSession[ 'messages' ] );
}

function messagesPopAllToHtml() {
	$messagesHtml = '';
	while( $message = MessagePop() ) {
		$messagesHtml .= "<div class=\"message\">{$message}</div>";
	}

	return $messagesHtml;
}

# Функции сессий

function checkToken( $user_token, $session_token, $returnURL ) {  # Проверка токена защиты от CSRF
	if( $user_token !== $session_token || !isset( $session_token ) ) {
		PushMessage( 'CSRF токен неверен! Возможно, производится атака!' );
		RedirectTo( $returnURL );
	}
}

function generateSessionToken() {  # Генерация нового CSRF токена
	if( isset( $_SESSION[ 'session_token' ] ) ) {
		destroySessionToken();
	}
	$_SESSION[ 'session_token' ] = md5( uniqid() );
}

function destroySessionToken() {  # Удалить Cookie - session_token
	unset( $_SESSION[ 'session_token' ] );
}

function tokenField() {  # Получить значение токена
	return "<input type='hidden' name='user_token' value='{$_SESSION[ 'session_token' ]}' />";
}

function &VulnWappSessionGet() {
	if( !isset( $_SESSION[ 'VulnWapp' ] ) ) {
		$_SESSION[ 'VulnWapp' ] = array();
	}
	return $_SESSION[ 'VulnWapp' ];
}

function PageStartup( $pActions ) {
	if( in_array( 'authenticated', $pActions ) ) {
		if( !IsLoggedIn()) {
			RedirectTo( root_page . 'login.php' );
		}
	}
}

function IsLoggedIn() {
	$VulnWappSession =& VulnWappSessionGet();
	return isset( $VulnWappSession[ 'username' ] );
}

function Logout() {
	$VulnWappSession =& VulnWappSessionGet();
	unset( $VulnWappSession[ 'username' ] );
    global $sessionuser;
    $sessionuser = 'NULL';
}

function Login( $pUsername ) {
    $VulnWappSession =& VulnWappSessionGet();
    $VulnWappSession[ 'username' ] = $pUsername;
    global $sessionuser;
    $sessionuser = $pUsername;
}

function CurrentUser() {
	$VulnWappSession =& VulnWappSessionGet();
	return ( isset( $VulnWappSession[ 'username' ]) ? $VulnWappSession[ 'username' ] : '') ;
}

# Перезагрузка страницы

function ReloadPage() {
	RedirectTo( $_SERVER[ 'PHP_SELF' ] );
}

# Работа с уязвимостями

function generateFlag($length = 40){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789!"%:?*(){};<>?[],';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}

function refreshFlags()
{
    global $flags;
    for ($i =0; $i<5; $i++)
    {
        $flags[$i] = generateFlag();

        #print $flags[$i];
        #echo ' <br> ';
        #echo ' <h1> var_dump($flags[$i])  </h1>
        #print $flags[$i];

        #return $flags[$i];


    }
    return $flags;
}

function getFlag($i){
    global $flags;
    return $flags[$i];
}

function vardump($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}



# Перенаправление

function RedirectTo($pLocation ) {
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

function DatabaseConnect() {
	global $_VulnWapp;
	global $DBMS;
    global $DBMS_errorFunc;
	//global $DBMS_connError;
	global $db;

	if( $DBMS == 'MySQL' ) {
		if( !@($GLOBALS["___mysqli_ston"] = mysqli_connect( $_VulnWapp[ 'db_server' ],  $_VulnWapp[ 'db_user' ],  $_VulnWapp[ 'db_password' ] ))
		|| !@((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $_VulnWapp[ 'db_database' ])) ) {
			Logout();
			PushMessage( 'Unable to connect to the database.<br />' . $DBMS_errorFunc );
			RedirectTo( root_page . 'setup.php' );
		}
	}
	else {
		die ( "Unknown {$DBMS} selected." );
	}	
}

$PHPUploadPath    = realpath( getcwd() . DIRECTORY_SEPARATOR . root_page . "temp" . DIRECTORY_SEPARATOR . "uploads" ) . DIRECTORY_SEPARATOR;
$PHPCONFIGPath       = realpath( getcwd() . DIRECTORY_SEPARATOR . root_page . "config");

$phpDisplayErrors = 'PHP function display_errors: <em>' . ( ini_get( 'display_errors' ) ? 'Enabled</em> <i>(Easy Mode!)</i>' : 'Disabled</em>' );                                                  // Verbose error messages (e.g. full path disclosure)
$phpSafeMode      = 'PHP function safe_mode: <span class="' . ( ini_get( 'safe_mode' ) ? 'failure">Enabled' : 'success">Disabled' ) . '</span>';                                                   // DEPRECATED as of PHP 5.3.0 and REMOVED as of PHP 5.4.0
$phpMagicQuotes   = 'PHP function magic_quotes_gpc: <span class="' . ( ini_get( 'magic_quotes_gpc' ) ? 'failure">Enabled' : 'success">Disabled' ) . '</span>';                                     // DEPRECATED as of PHP 5.3.0 and REMOVED as of PHP 5.4.0
$phpURLInclude    = 'PHP function allow_url_include: <span class="' . ( ini_get( 'allow_url_include' ) ? 'success">Enabled' : 'failure">Disabled' ) . '</span>';                                   // RFI
$phpURLFopen      = 'PHP function allow_url_fopen: <span class="' . ( ini_get( 'allow_url_fopen' ) ? 'success">Enabled' : 'failure">Disabled' ) . '</span>';                                       // RFI
$phpGD            = 'PHP module gd: <span class="' . ( ( extension_loaded( 'gd' ) && function_exists( 'gd_info' ) ) ? 'success">Installed' : 'failure">Missing' ) . '</span>';                    // File Upload
$phpMySQL         = 'PHP module mysql: <span class="' . ( ( extension_loaded( 'mysqli' ) && function_exists( 'mysqli_query' ) ) ? 'success">Installed' : 'failure">Missing' ) . '</span>';                // Есть ли СУБД
$phpPDO           = 'PHP module pdo_mysql: <span class="' . ( extension_loaded( 'pdo_mysql' ) ? 'success">Installed' : 'failure">Missing' ) . '</span>';                // SQLi

$UploadsWrite = '[User: ' . get_current_user() . '] Writable folder ' . $PHPUploadPath . ': <span class="' . ( is_writable( $PHPUploadPath ) ? 'success">Yes' : 'failure">No' ) . '</span>';                                     // File Upload
$bakWritable = '[User: ' . get_current_user() . '] Writable folder ' . $PHPCONFIGPath . ': <span class="' . ( is_writable( $PHPCONFIGPath ) ? 'success">Yes' : 'failure">No' ) . '</span>';   // config backup check                                  // File Upload


$VulnWappOS       = 'Operating system: <em>' . ( strtoupper( substr (PHP_OS, 0, 3)) === 'WIN' ? 'Windows' : '*nix' ) . '</em>';
$SERVER_NAME      = 'Web Server SERVER_NAME: <em>' . $_SERVER[ 'SERVER_NAME' ] . '</em>';                                                                                                          // CSRF

$MYSQL_USER       = 'MySQL username: <em>' . $_VulnWapp[ 'db_user' ] . '</em>';
$MYSQL_PASS       = 'MySQL password: <em>' . ( ($_VulnWapp[ 'db_password' ] != "" ) ? '******' : '*blank*' ) . '</em>';
$MYSQL_DB         = 'MySQL database: <em>' . $_VulnWapp[ 'db_database' ] . '</em>';
$MYSQL_SERVER     = 'MySQL host: <em>' . $_VulnWapp[ 'db_server' ] . '</em>';

?>
