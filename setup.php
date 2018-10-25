<?php

##
## Файл создает БД для работы приложения
## 

    define( 'root_page', '' );
    require_once root_page . 'functions.php';

	if( $DBMS == 'MySQL' ) {


			if( !@($GLOBALS["___mysqli_ston"] = mysqli_connect( $_VulnWapp[ 'db_server' ],  $_VulnWapp[ 'db_user' ],  $_VulnWapp[ 'db_password' ] )) ) {
				PushMessage( "Не удалось соединииться с MySQL.<br />Проверьте конфигурационный файл." );
				if ($_VulnWapp[ 'db_user' ] == "root") {
					PushMessage( 'Вы указали root в качестве пользователя, такая конфигурация не сработает с  MariaDB, нужно создать отдельного пользователя.' );
				}
				ReloadPage();
			}


			# Создание БД
			$drop_db = "DROP DATABASE IF EXISTS {$_VulnWapp[ 'db_database' ]};";
			if( !@mysqli_query($GLOBALS["___mysqli_ston"],  $drop_db ) ) {
				PushMessage( "Не удалось удалить существующую базу данных<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}

			$create_db = "CREATE DATABASE {$_VulnWapp[ 'db_database' ]};";
			if( !@mysqli_query($GLOBALS["___mysqli_ston"],  $create_db ) ) {
				PushMessage( "Не удалось создать базу данных<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}
			PushMessage( "База данных была создана." );


			# Создание таблицы пользователей
			if( !@((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $_VulnWapp[ 'db_database' ])) ) {
				PushMessage( 'Не удалось соединиться с базой данных.' );
				ReloadPage();
			}

			$create_tb = "CREATE TABLE users (user_id int(6),first_name varchar(15),last_name varchar(15), user varchar(15), password varchar(32),avatar varchar(70), last_login TIMESTAMP, failed_login INT(3), PRIMARY KEY (user_id));";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_tb ) ) {
				PushMessage( "Не удалось создать таблицу<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}
			PushMessage( "Таблица пользователей создана." );


			# Внесение данных в таблицу
			$avatarUrl  = 'includes/users/';

			$insert = "INSERT INTO users VALUES
				('1','admin','admin','admin',MD5('P@ssw0rd'),'{$avatarUrl}man.png', NOW(), '0'),
				('2','Usual','Student','student',MD5('lovehomework'),'{$avatarUrl}boy.png', NOW(), '0');";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
				PushMessage( "Не удалось внести данные в таблицу пользователей<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}
			PushMessage( "Данные внесены в таблицу пользователей." );


			# Создание таблицы для гостевой книги
			$create_tb_guestbook = "CREATE TABLE guestbook (comment_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, comment varchar(300), name varchar(100), PRIMARY KEY (comment_id));";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_tb_guestbook ) ) {
				PushMessage( "Не удалось создать таблицу<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}
			PushMessage( "Таблица гостевой книги создана." );


			# Внесение данных в гостевую книгу
			$insert = "INSERT INTO guestbook VALUES ('1','Привет, мир. Это тест.','test');";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
				PushMessage( "Не удалось внести данные в таблицу гостевой книги<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}
			PushMessage( "Данные внесены в таблицу гостевой книги." );

			# Создание резерного файла конфигурации
			$conf = root_page . 'config/DBconfig.php';
			$bakconf = root_page . 'config/DBconfig.php~';
			if (file_exists($conf)) {
				@copy($conf, $bakconf);
			}

			PushMessage( "Резервный файл /config/DBconfig.php~ был создан" );


			PushMessage( "<em>Установка прошла успешно.</em>!" );

			if( !IsLoggedIn())
				PushMessage( "Пожалуйста, <a href='login.php'>авторизуйтесь</a>.<script>setTimeout(function(){window.location.href='login.php'},5000);</script>" );
			RedirectTo( root_page . 'login.php' );


	}
	else {
		PushMessage( 'Ошибка. Выбрана неверная база данных. Проверьте конфигурационный файл..' );
		ReloadPage();
	}

    # Защита от CSRF
    generateSessionToken();

    echo "
        
    <html xmlns=\"http://www.w3.org/1999/xhtml\">	
    
    <body>	
        <br />
        {$messagesHtml}
        <br />
    </body>
    
    </html>";

?>
