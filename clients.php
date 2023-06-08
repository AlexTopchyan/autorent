<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/script.js"></script>
    <title>Клиенты</title>
</head>
<body>
    <?php
        require ('menu.php');
        require_once ('login.php');

        if ( !isset($_GET["action"]) ) $_GET["action"] = "showlist";
        
        switch ($_GET["action"]) {
            case "showlist":
                show_list($link); break;
            
            case "addform":
                get_add_item_form(); break;

            case "add":
                add_item(); break;    
            
            case "editform":
                get_edit_item_form(); break;
            
            case "update":
                update_item(); break;
                
            case "delete":
                delete_item(); break;    

            default:
                show_list($link);       
            }

            function show_list($link){
            global $link;

            $query = 'SELECT * FROM clients';
            $res = mysqli_query($link, $query);

            echo '<div class="d_cont">';
            echo '<h2 id="page_name">Клиенты</h2>';
            echo '<button type="button" onClick="history.back();">Назад</button><br>';
            echo '<br><table border="1" class="data_tbl">';
            echo '<tr align="center" class="tbl"><th>Код клиента</th><th>ФИО клиента</th><th>Телефон</th><th>Адрес</th><th>Паспортные данные</th><th colspan="5"></th></tr>';
            
            if (empty($_SESSION['id'])) {
                while ($item = mysqli_fetch_array($res)) {
                    echo '<tr align="center" class="tbl">';
                    echo '<td>'.$item['id_client'].'</td>';
                    echo '<td>'.$item['client_name'].'</td>';
                    echo '<td>'.$item['client_phone'].'</td>';
                    echo '<td>'.$item['client_adress'].'</td>';
                    echo '<td>'.$item['client_passport'].'</td>';
                    echo '<td colspan="2"></td>';
                }

                } elseif ($_SESSION['status'] == 1){
                    while ($item = mysqli_fetch_array($res)) {
                    
                        echo '<tr align="center" class="tbl">';
                        echo '<td>'.$item['id_client'].'</td>';
                        echo '<td>'.$item['client_name'].'</td>';
                        echo '<td>'.$item['client_phone'].'</td>';
                        echo '<td>'.$item['client_adress'].'</td>';
                        echo '<td>'.$item['client_passport'].'</td>';
                        echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_client='.$item['id_client'].'"><img src="img/edit.png" title="Редактировать"></a></td>'; 
                        echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_client='.$item['id_client'].'"><img src="img/drop.png" title="Удалить" onClick="return confirmDelete()"></a></td>'; 
                    }

                    echo '<tr align="center"><td colspan="11"><a href="'.$_SERVER['PHP_SELF'].'?action=addform"<button class="btn" type="button">Добавить</button></a>
                    </td></tr>';

                } else {
                    while ($item = mysqli_fetch_array($res)) {
                    echo '<tr align="center" class="tbl">';
                    echo '<td>'.$item['id_client'].'</td>';
                    echo '<td>'.$item['client_name'].'</td>';
                    echo '<td>'.$item['client_phone'].'</td>';
                    echo '<td>'.$item['client_adress'].'</td>';
                    echo '<td>'.$item['client_passport'].'</td>';
                    echo '<td colspan="2"></td>';
                }   
                }
                    
                echo '</table>';
                echo '</div>';
            }


        function get_add_item_form(){
            if ($_SESSION['status'] == 1) {
                echo '<div class="d_cont">';
                echo '<h2>Добавить клиента</h2>';
                echo '<form name="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">';
                echo '<button type="button" onClick="history.back();">Назад</button><br>';
                echo '<br><table border="1" class="data_tbl">';
                echo '<tr>';
                echo '<td>ФИО</td>';
                echo '<td><input class="input" type="text" name="client_name" value="" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Телефон</td>';
                echo '<td><input class="input" type="text" name="client_phone" value="" /></td>';
                echo '<tr>';
                echo '<td>Адрес</td>';
                echo '<td><input class="input" type="text" name="client_adress" value="" /></td>';
                echo '<tr>';
                echo '<td>Паспортные данные</td>';
                echo '<td><input class="input" type="text" name="client_passport" value="" /></td>';
                echo '<tr>';
                echo '<tr align="center" class="tbl">';
                echo '<td colspan="2"><input class="btn" type="submit" value="Сохранить"/></td>';
                echo '</tr>';
                echo '</table>';
                echo '</form>';
                echo '</div>';
             } else {
                echo '<meta http-equiv="refresh" content="0;URL=clients.php">';
            }    
        }

        function add_item(){
            global $link;
                $client_name = mysqli_escape_string($link, $_POST['client_name']);
                $client_phone = mysqli_escape_string($link, $_POST['client_phone']);
                $client_adress = mysqli_escape_string($link, $_POST['client_adress']);
                $client_passport= mysqli_escape_string($link, $_POST['client_passport']);
                $query = "INSERT INTO clients (client_name, client_phone, client_adress, client_passport) VALUES ('".$client_name."','".$client_phone."','".$client_adress."','".$client_passport."');";
                mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                echo '<meta http-equiv="refresh" content="0;URL=clients.php">';
                die();
        }

        function get_edit_item_form(){
            global $link;
            $query = 'SELECT * FROM clients WHERE id_client='.$_GET['id_client'];
            $res = mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
            $item = mysqli_fetch_array($res);
            if ($_SESSION['status'] == 1) {
                echo '<div class="d_cont">';
                echo '<h2>Редактировать</h2>';
                echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_client='.$_GET['id_client'].'" method="POST">';
                echo '<button type="button" onClick="history.back();">Назад</button><br>';
                echo '<br><table border="1" class="data_tbl">';
                echo '<tr>';
                echo '<td>ФИО клиента</td>';
                echo '<td><input class="input" type="text" name="client_name" value="'.$item['client_name'].'" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Телефон</td>';
                echo '<td><input class="input" type="text" name="client_phone" value="'.$item['client_phone'].'" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Адрес</td>';
                echo '<td><input class="input" type="text" name="client_adress" value="'.$item['client_adress'].'" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Паспортные данные</td>';
                echo '<td><input class="input" type="text" name="client_passport" value="'.$item['client_passport'].'" /></td>';
                echo '<tr>';
                echo '<tr align="center" class="tbl">';
                echo '<td colspan="2"><input class="btn" type="submit" value="Сохранить"/></td>';
                echo '</tr>';
                echo '</table>';
                echo '</form>';
                echo '</div>';
             } else {
                echo '<meta http-equiv="refresh" content="0;URL=clients.php">';
            }
        }

        function update_item(){
            global $link;
                $client_name = mysqli_escape_string($link, $_POST['client_name']);
                $client_phone = mysqli_escape_string($link, $_POST['client_phone']);
                $client_adress = mysqli_escape_string($link, $_POST['client_adress']);
                $client_passport= mysqli_escape_string($link, $_POST['client_passport']);
                $query = "UPDATE clients SET client_name='".$client_name."', client_phone='".$client_phone."', client_adress='".$client_adress."', client_passport='".$client_passport."' WHERE id_client=".$_GET['id_client'];
                mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                echo '<meta http-equiv="refresh" content="0;URL=clients.php">';
                die();
        }

        function delete_item(){
            if ($_SESSION['status'] == 1) {
                global $link;
                    $query = "DELETE FROM clients WHERE id_client=".$_GET['id_client'];
                    mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                    echo '<meta http-equiv="refresh" content="0;URL=clients.php">';
                    die();
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=clients.php">';
            }        
        }
    ?>
</body>
</html>