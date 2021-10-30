<?php
//Реализовать несколько страниц
//- Входа
//- Регистрации
//- Аккаунта пользователя
//
//При заходе на страницу пользователь попадает на страницу Входа. После 3й не удачной попытки - перекидывать на
//страницу Регистрации. После входа - пользователь попадает на страницу аккаунта. На эту страницу он должен попасть
//с любого браузера если была пройдена авторизация. На странице аккаунта должна быть кнопка выхода, которая завершит
//во всех браузерах вход.

session_id("ad136688-d1c1-4b44-b8a0-fbb9418fb51a");
session_start();

if (!empty($_SESSION["Login"])) {
    echo "<h1>Вы уже вошли, эта страница не доступна</h1>";
    return;
}

if (!isset($_SESSION['login_attempt']))
    $_SESSION['login_attempt'] = 0;

if (isset($_POST['submit']) and isset($_POST['user_login']) and isset($_POST['user_password'])) {
    $login = $_POST['user_login'];
    $password = $_POST['user_password'];
    $_SESSION['login_attempt']++;

    $file_name = 'users.txt';
    if (file_exists($file_name)){
        $file = file_get_contents($file_name);
        if (preg_match('/login='.$login.';password='.$password.'/', $file)){
            $_SESSION['login_attempt'] = 0;
            $_SESSION['Login'] = $login;
            header("Location: User account.php");
        }
    }
}

$error_message = ($_SESSION['login_attempt'] > 0 ?
    '<p class="error">Вы неудачно пытались залогинится '.$_SESSION['login_attempt'].' раз(а),</p> 
                <p class="error">у вас осталось '.(3 - $_SESSION['login_attempt']).' попытока(ок)</p>' : '');

if ($_SESSION['login_attempt'] < 3){
    echo'
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Login</title>
            <link href="style.css" rel="stylesheet"/>
        </head>
        <body>
        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
        <div class="top">
            <h1>Login</h1>
            <a href="Registrations.php">Registration</a>
            <br/>
            <a href="User%20account.php">User account</a>
        </div>
        <div class="box">
            <div class="content">
                <h2>Login</h2>
                <form action="Login.php" method="post">
                    <p><label>Login:<input type="text" placeholder="Login" name="user_login"></label><p>
                    <p><label>Password:<input type="text" placeholder="Password" name="user_password"></label></p>
                    <div>
                        <input type="reset" value="Reset ">
                        <input type="submit" value="Sing in" name="submit">
                    </div>
                </form>
                '.$error_message.'
            </div>
        </div>
        </body>
        </html>
    ';
} else {
    $_SESSION['login_attempt'] = 0;
    header("Location: Registrations.php");
}