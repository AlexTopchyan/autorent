<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="d_banner" align=center>
        <a href="index.php"><img src="img/banner.png" class="d_banner-img" alt="banner"></a>

        <div class="d_reg">
            <?php 
                if (empty($_SESSION['login']) or empty($_SESSION['id'])) {
                    echo 'Добро пожаловать, Гость!';
                    echo '<br>';
                    echo '<a href="reg_form.php" class="d_reg-btn">Регистрация</a><a href="auth_form.php" class="d_reg-btn">Авторизация</a>';
                } else {
                    echo 'Добро пожаловать,' . $_SESSION['login'].'!';
                    echo '<br><a class="d_reg-btn auth-finish" href="?exit">Выйти</a>';
                }

                //Выход из сессии
                if (isset($_GET['exit'])) {
                    session_unset();
                    session_destroy();
                    echo '<meta http-equiv="refresh" content="0;URL='.$_SERVER['PHP_SELF'].'">';
                    exit;
                }
            ?>
        </div><br>  
    </div>

    <div class="d_menu">
        <ul class="menu">
            <li><a href="index.php">О нас</a></li>
            <li><a href="autos.php">Автомобили</a>
            </li>
            <li><a href="#">Прокат</a>
                <ul class="submenu">
                    <li><a href="rent.php">Сдача автомобилей в прокат</a></li>
                    <li><a href="clients.php">Клиенты</a></li>
                    <li><a href="search_rent.php">Поиск информации</a></li>
                </ul>
            </li>
        </ul>
    </div>
    
</body>
</html>