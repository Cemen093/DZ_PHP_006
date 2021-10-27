<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
<div class="top">
    <h1>User account</h1>
</div>
<div class="box">
    <div class="content">
        <h2>User account</h2>
        <?php
        if (empty($_SESSION['Login']))
        {
            echo '
                    <p>Вы зашли как гость</p>
                    <a href="Login.php">Login</a>
                    <br>
                    <a href="Registrations.php">Registration</a>';
        }
        else
        {
            echo '<p>Вы зашли как '.$_SESSION['Login'].'</p>';
            echo '<a href="Logout.php">Logout</a>';
        }
        ?>
    </div>
</div>
