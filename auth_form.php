<?php session_start();
    require ('menu.php');
    require_once ('login.php');
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>
    

    <div class="d_cont">
        <h2>Авторизация</h2>

        <?php

        if (empty($_SESSION['login']) or empty($_SESSION['id'])) {

        ?>

        <form action="auth.php" method="post">
            <button type="button" onClick="history.back();">Отменить</button>

            <div class="form_block">
                <p>
                <label for="">Ваш логин:</br></label>
                <input class="input" name="login" type="text" size="15" maxlength="15">
            </p>

            <p>
                <label for="">Ваш пароль:</br></label>
                <input class="input" name="password" type="password" size="15" maxlength="15">
            </p>

            <input class="btn" type="submit" name="submit" value="Войти">
            </div>
            
        </form>
        <?php 
            } else {
                echo 'Вы уже вошли, как '.$_SESSION['login'].'.<a href="?exit">Выйти?</a>';
            }
        ?>
    </div>  
</body>
</html>