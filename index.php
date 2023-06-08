<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сервис по прокату автомобилей</title>
</head>
<body>
    <?php
        require ('menu.php');
    ?>

    <div class="d_cont">
        <hr>

        <table>
            <tr>
                <td colspan="2">
                    <font size="5" color="green"><b><h2>Почему мы?</h2></b></font>
                    
                </td>
            </tr>

            <tr>
                <td>
                    <img class="service-block" src="img/promoting.svg" width="50" height="50">
                </td>
                <td align="left">
                    <b><i>Удобный сервис по прокату автомобилей</i></b>
                </td>
            </tr>

            <tr>
                <td align="center">
                    <img class="service-block" src="img/best-price.svg" width="50" height="50">
                </td>
                <td>
                    <b><i>Лучшие автомобили и лояльные цены</i></b>
                </td>
            </tr>

            <tr>
                <td align="center">
                    <img class="service-block" src="img/customer-support.svg" width="50" height="50">
                </td>
                <td align="left"> 
                    <b><i>Тех.поддержка 24/7</i></b>
                </td>
            </tr>
        </table>
        
        <hr>
    </div>

</body>
</html>