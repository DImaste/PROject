<?php

##
## Файл создает БД для работы приложения
## 

    define( 'root_page', '' );
    require_once root_page . 'functions.php';

# TODO вопрос - вы действительно хотите переустановить приложение? Текущий прогресс будет утерян.

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

			$create_tb = "CREATE TABLE users (user_id int(6),first_name varchar(15),last_name varchar(15), user varchar(15), password varchar(32),avatar varchar(70), last_login TIMESTAMP, failed_login INT(3), PRIMARY KEY (user_id), percent int(6), active bool, flag1 bool, flag2 bool, flag3 bool, flag4 bool, flag5 bool);";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_tb ) ) {
				PushMessage( "Не удалось создать таблицу<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}
			PushMessage( "Таблица пользователей создана." );

			# Внесение данных в таблицу
			$avatarUrl  = 'includes/users/';

			$insert = "INSERT INTO users VALUES
				('1','admin','admin','admin',MD5('P@ssw0rd!74y^$372jfHF'),'{$avatarUrl}man.png', NOW(), '0','0', false, false, false, false, false, false),
				('2','Usual','Student','student',MD5('lovehomework'),'{$avatarUrl}boy.png', NOW(), '0','0', false, false, false, false, false, false);";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
				PushMessage( "Не удалось внести данные в таблицу пользователей<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}
			PushMessage( "Данные внесены в таблицу пользователей." );

			# Создание таблицы для гостевой книги
			$create_tb_flags = "CREATE TABLE flags (id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT, flag varchar(300), active bool, PRIMARY KEY (id));";
			if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_tb_flags ) ) {
				PushMessage( "Не удалось создать таблицу<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
				ReloadPage();
			}
			PushMessage( "Таблица флагов создана." );

			# Внесение данных в гостевую книгу

		    for ($i=1; $i<6; $i++)
            {
                $ToInsert = getFlag($i-1);
                $insert = "INSERT INTO flags VALUES ('{$i}','{$ToInsert}', false);";

                if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
                    PushMessage( "Не удалось внести данные в таблицу флагов<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );

            };
			}

			PushMessage( "Данные внесены в таблицу флагов" );

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
