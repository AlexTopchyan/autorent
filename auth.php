<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Личный кабинет</title>
</head>
<body>
    <?php 
    
     require_once('menu.php');
     
    ?>

    <div class="d_cont">

    <?php 
        if (isset($_POST['login'])) {
            $login = $_POST['login'];

            if ($login == "") {
                unset($login);
            }
        }

        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        
            if ($password == "") {
                unset($password);
            }
        }
        if (empty($login) or empty ($password)) {
            exit("Вы ввели не всю информацию, вернитесь назад и заполните всю информацию");
        }    

        $login = stripslashes($login);
        $login = htmlspecialchars($login);

        
        $password = stripslashes($password);
        $password = htmlspecialchars($password);

        $login = trim($login);
        $password = trim($password);

        $password = md5($password);

        require_once('login.php');

        $result = mysqli_query($link, "SELECT * FROM users WHERE login='$login'");
        $myrow = mysqli_fetch_array($result);

        if (empty($myrow['password'])) {
            exit("Извините, введенный Вами логин или пароль неверный");
        } else {
            if ($myrow['password']==$password) {
                $_SESSION['id']=$myrow['id'];
                $_SESSION['login']=$myrow['login'];
                $_SESSION['status']=$myrow['status'];

                echo "Добро пожаловать, ".$_SESSION['login']." Вы успешно вошли на сайт!";
                echo '<br>';
                print_r($_SESSION);
        } else {
                exit("Извините, введенный вами логин или пароль неверный");
            }
        }
    
    ?>
</div>    
</body>
</html>