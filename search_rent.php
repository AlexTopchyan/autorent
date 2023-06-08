<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/script.js"></script>
    <title>Поиск информации о аренде</title>
</head>
<body> 
        <?php
        require_once('menu.php');
    ?>

    <div class="d_cont">
        <h2>Поиск информации о аренде</h2>

        
            <table border="0" class="data_tbl">
                <tr>
                    <td>
                        <b>Марка автомобиля</b>
                        <input class="input" type="text" list="auto_list" name="auto_list">
                    </td>

                    <td>
                        <b>ФИО Клиента</b>
                        <input class="input" type="text" list="client_list" name="client_list">
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <input class="btn" type="button" onClick="ajaxFunction()" value="Поиск">
                        <input class="btn" type="button" onClick="res()" value="Сброс">
                    </td>
                </tr>
            </table>

       <div id="ajaxDiv"></div>

        <?php 
            require_once('login.php');

            /* Список автомобилей */

            $sql1 = "SELECT DISTINCT name_auto FROM v_rent";
            $res1 = mysqli_query($link, $sql1) or die( "Error in $sql1 : " . mysqli_error()); 

            echo '<datalist id="auto_list">';
            while($row = mysqli_fetch_array($res1)) 
            { 
                $name_auto = htmlspecialchars($row['name_auto']);
                echo "<option value='$name_auto'></option>\r\n"; 
            } 
            echo "</datalist>";

            /* Клиенты */

            $sql2 = "SELECT DISTINCT client_name FROM v_rent";
            $res2 = mysqli_query($link, $sql2) or die( "Error in $sql2 : " . mysqli_error()); 

            echo '<datalist id="client_list">';
            while($row = mysqli_fetch_array($res2)) 
            { 
                $client_name = htmlspecialchars($row['client_name']);
                echo "<option value='$client_name'></option>\r\n"; 
            } 
            echo "</datalist>";

            /* Сдача автомобилей в прокат */
            /*
            $sql3 = "SELECT DISTINCT name_act FROM v_active";
            $res3 = mysqli_query($link, $sql3) or die( "Error in $sql3 : " . mysqli_error()); 

            echo '<datalist id="rent_list">';
            while($row = mysqli_fetch_array($res3)) 
            { 
                $name_auto = htmlspecialchars($row['name_auto']);
                echo "<option value='$name_auto'></option>\r\n"; 
            } 
            echo "</datalist>";

            */
        ?>
    
    </div>
    
    <script>
        function ajaxFunction() {

        var ajaxRequest;  // The variable that makes Ajax possible!

        try {
            // Opera 8.0+, Firefox, Safari
            ajaxRequest = new XMLHttpRequest();
        } catch (e) {
            // Internet Explorer Browsers
            try {
                ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    // Something went wrong
                    alert("Your browser broke!");
                    return false;
                }
            }
        }
        // Create a function that will receive data sent from the server
        ajaxRequest.onreadystatechange = function () {
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('ajaxDiv');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
        }

        var search1 = document.getElementsByName('auto_list')[0].value;
        var search2 = document.getElementsByName('client_list')[0].value;
       

        var queryString1 = "?search1=" + search1;
        var queryString2 = "search2=" + search2;
        

        ajaxRequest.open("GET", "search_all.php" + queryString1 + "&" + queryString2 + "&", true);
        ajaxRequest.send(null);

        }

        function res() {
            document.getElementsByName('auto_list')[0].value = '';
            document.getElementsByName('client_list')[0].value = '';
            document.getElementById('ajaxDiv').innerHTML = '';
        }
    </script>
</body>
</html>