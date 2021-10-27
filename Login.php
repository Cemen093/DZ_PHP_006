<?php
session_id("ad136688-d1c1-4b44-b8a0-fbb9418fb51a");
session_start();
if (!isset($_SESSION['login_attempt']))
    $_SESSION['login_attempt'] = 0;

$post_received = false;
if (isset($_POST['user_login'])) {
    $user_login = $_POST['user_login'];
}

if (isset($_POST['user_password'])){
    $user_password = $_POST['user_password'];
}

if (isset($_POST['user_login']) or isset($_POST['user_password'])) {
    $_SESSION['login_attempt']++;

    $file_name = 'users.txt';
    if(!file_exists($file_name)){
        echo 'Файл не найден';
        return;
    }
    $file = fopen($file_name, 'r');
    while (!feof($file)){
        $arr = preg_split('/\s/', fgets($file, 999));
        $Login = $arr[0];
        $Password = $arr[1];
        if ($_POST['user_login'] == $Login){
            if ($_POST['user_password'] == $Password){
                $_SESSION['Login'] = $Login;
                header("Location: User account.php");
            }
            return;
        }
    }
    echo '<h2>Пользователь не найден</h2>';
    return;
}

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
                        <input type="submit" value="Sing in">
                    </div>
                </form>
                '.($_SESSION['login_attempt'] > 0 ?
                '<p class="red">Вы неудачно пытались залогинится '.$_SESSION['login_attempt'].' раз(а), 
                у вас осталось '.(3 - $_SESSION['login_attempt']).' попытока(ок)</p>':
                '').'
            </div>
        </div>
    ';
} else {
    unset($_SESSION['login_attempt']);
    header("Location: Registrations.php");
}
?>
</body>
</html>
