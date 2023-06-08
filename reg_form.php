<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Регистрация</title>
</head>
<body>
    <?php
        require ('menu.php');
    ?>

    <div class="d_cont">
        <h2>Регистрация</h2>

        <form action="reg.php" method="post">
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

            <input class="btn" type="submit" name="submit" value="Зарегистрироваться">
            </div>
           
        </form>
    </div>  
</body>
</html>