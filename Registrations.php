<?php
session_start();
$pattern_name = '/\w{3,}/';
$pattern_password = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
$pattern_mail = '/\w+@\w+\.\w+/';


if (isset($_POST['user_login']) and isset($_POST['user_password']))
{
    if(!preg_match($pattern_name, $_POST['user_login'])){
        echo "<h2 class='error'>LOGIN ERROR</h2>";
        return;
    }
    if(!preg_match($pattern_password, $_POST['user_password'])){
        echo "<h2 class='error'>PASSWORD ERROR</h2>";
        return;
    }

    $file_name = 'users.txt';

    if (!file_exists($file_name)){
        //создание файла
        $file = fopen($file_name, 'w');
        fwrite($file, "User Password");
    } else {
        //проверка на существования логина
        $file = fopen($file_name, 'r');
        while (!feof($file)) {
            if ($_POST['user_login'] == preg_split('/\s/', fgets($file, 999))[0]) {
                echo '<h2 class="error">Данный логин уже занят</h2>';
                return;
            }
        }
    }
    fclose($file);

    $file = fopen($file_name, 'a');
    if (!$file or !fwrite($file, PHP_EOL.$_POST['user_login'].' '.$_POST['user_password'])){
        echo '<h2 class="error">Ошибка регистрации</h2>';
        return;
    }
    fclose($file);

    $_SESSION['Login'] = $_POST['user_login'];
    header("Location: User account.php");
} else {
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
            <h1>Registration</h1>
        </div>
        <div class="box">
            <div class="content">
                <h2>Registration</h2>
                <form action="Registrations.php" method="post">
                    <p><label>Login:<input type="text" placeholder="Login" name="user_login"></label><p>
                    <p><label>Password:<input type="text" placeholder="Password" name="user_password"></label></p>
                    <div>
                        <input type="reset" value="Reset ">
                        <input type="submit" value="Registrations">
                    </div>
                </form>
            </div>
        </div>
    ';
}
?>