<?php
    $host = 'localhost';
    $login_db = 'admin_autos';
    $password_bd = 'autos_admin';
    $db_name = 'autorent';
    $link = mysqli_connect($host, $login_db, $password_bd, $db_name);
    mysqli_query($link, 'set names utf8');
    mysqli_query($link, "SET CHATACTER SET 'utf8'");
    mysqli_query($link, "SET SESSION collation_connection = 'utf8_general_ci';");
?>