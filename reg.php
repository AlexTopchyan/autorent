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
    
     require_once('menu.php');
     
    ?>

    <div class="d_cont"></div>

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

        $result = mysqli_query($link, "SELECT id FROM users WHERE login='$login'");
        $myrow = mysqli_fetch_array($result);

        if (!empty($myrow['id'])) {
            exit("Извините, введенный Вами логин уже зарегистрирован. Введите другой логин");
        } 

        $result2 = mysqli_query($link, "INSERT INTO users (login,password,status) VALUES ('$login','$password', 10)");

        if ($result2 == 'TRUE') {
            echo "Вы успешно зарегистрированы! Теперь Вы можете войти на сайт. <a href='auth_form.php'>Войти на сайт</a>";
        } else {
            echo 'Ошибка! Вы не зарегистрированы.';
        }
    
    ?>
</body>
</html>