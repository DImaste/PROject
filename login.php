<?php

define( 'root_page', '' );
require_once root_page . './functions.php';

DatabaseConnect();





?>

<form action="verify.php" method="post">
    User Name:<br>
    <input type="text" name="username"><br><br>
    Password:<br>
    <input type="password" name="password"><br><br>
    <input type="submit" name="submit" value="Login">
</form>


<h1>Войти на сайт</h1>
<p>Введите ваши учетные данные.</p>
<form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">
    <p><label for="login">Логин:</label><br />
        <input type="text" id="login" name="login" size="20" autocomplete="off"></p>
    <p><label for="password">Пароль:</label><br />
        <input type="password" id="password" name="password" size="20" autocomplete="off"></p>
    <input type="text" id="redirectUrl" name="redirectUrl" style="display: none" value="<?php echo $redirectUrl?>">
    <button type="submit" name="form" value="submit">Войти</button>
</form>


if(isset($_POST["redirectUrl"]) && $_POST["redirectUrl"]){
header("Location: " . $_POST["redirectUrl"]);
}else{
header("Location: /");
