<?php

##
## Файл содержит данные, необходимые для подключение к БД и некоторые функции
##

if( !defined( 'root_page' ) ) {
    die('Системная ошибка - страница с функциями не определена');
    exit;
}

##
## Подключение к базе данных MySQL
##

require 'config/DBconfig.php';

$DBMS = 'MySQL';

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

# Обновление флагов

refreshFlags();

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
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789!"%:?*)};>?[],';
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

?>
