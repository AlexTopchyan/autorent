<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/script.js"></script>
    <title>Сдача автомобилей в прокат</title>
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

            $query = 'SELECT * FROM v_rent';
            $res = mysqli_query($link, $query) or die ("Ошибка" . mysqli_error($link));

            echo '<div class="d_cont">';
            echo '<h2>Сдача автомобилей в прокат</h2>';
            echo '<button type="button" onClick="history.back();">Назад</button><br>';
            echo '<br><table border="1" class="data_tbl">';
            echo '<tr align="center"><th>Код проката</th><th>Код клиента</th><th>ФИО</th>
            <th>Код автомобиля</th><th>Марка</th><th>Дата аренды</th><th>Дата сдачи</th>
            <th colspan="7"></th></tr>';

            if (empty($_SESSION['id'])) {
                while ($item = mysqli_fetch_array($res)) {
                    echo '<tr align="center" class="tbl">';
                    echo '<td>'.$item['id_rent'].'</td>';
                    echo '<td>'.$item['id_client'].'</td>';
                    echo '<td>'.$item['client_name'].'</td>';
                    echo '<td>'.$item['id_auto'].'</td>';
                    echo '<td>'.$item['name_auto'].'</td>';
                    echo '<td>'.$item['rent_date'].'</td>';
                    echo '<td>'.$item['return_date'].'</td>';

                }
            } elseif ($_SESSION['status'] == 1){
                while ($item = mysqli_fetch_array($res)) {
                    echo '<tr align="center" class="tbl">';
                    echo '<td>'.$item['id_rent'].'</td>';
                    echo '<td>'.$item['id_client'].'</td>';
                    echo '<td>'.$item['client_name'].'</td>';
                    echo '<td>'.$item['id_auto'].'</td>';
                    echo '<td>'.$item['name_auto'].'</td>';
                    echo '<td>'.$item['rent_date'].'</td>';
                    echo '<td>'.$item['return_date'].'</td>';
                    echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_rent='.$item['id_rent'].'"><img src="img/edit.png" title="Редактировать"></a></td>'; 
                    echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_rent='.$item['id_rent'].'"><img src="img/drop.png" title="Удалить" onClick="return confirmDelete()"></a></td>'; 
                }
                    echo '<tr align="center"><td colspan="11">
                        <a href="'.$_SERVER['PHP_SELF'].'?action=addform"<button class="btn" type="button">Добавить</button></a>
                    </td></tr>';
            } else {
                while ($item = mysqli_fetch_array($res)) {
                    echo '<tr align="center" class="tbl">';
                    echo '<td>'.$item['id_rent'].'</td>';
                    echo '<td>'.$item['id_client'].'</td>';
                    echo '<td>'.$item['client_name'].'</td>';
                    echo '<td>'.$item['id_auto'].'</td>';
                    echo '<td>'.$item['name_auto'].'</td>';
                    echo '<td>'.$item['rent_date'].'</td>';
                    echo '<td>'.$item['return_date'].'</td>';
                }
            }
               
                echo '</table>';
                echo '</div>';
            }

        function get_add_item_form(){
            if ($_SESSION['status'] == 1) {
                global $link;
                
                echo '<div class="d_cont">';
                echo '<h2>Добавить</h2>';
                echo '<form name="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">';
                echo '<button type="button" onClick="history.back();">Назад</button><br>';
                echo '<br><table border="1" class="data_tbl">';

                //Код проката

                echo '<tr>';
                echo '<td>Код проката</td>';
                echo '<td>';
                echo '<input class="input" type="text" name="id_rent" value="'.$item['id_rent'].'">';
                echo '</td>';

                //ФИО клиента

                echo '<tr>'; 
                echo '<td>ФИО</td>'; 
                echo '<td>'; 
                $sql1 = 'SELECT * FROM clients'; 

                $res1 = mysqli_query($link,$sql1) or die( "Error in $sql1 : " . mysql_error());
                
                echo '<select class="input" name="id_client">\r\n';
                echo '<option selected value="'.(int)$item['id_client'].'">'.$item['client_name'].'</option>';
                echo '<option disabled>------------------</option>';
                while($row = mysqli_fetch_array($res1)) 
                { 
                    $id_client = intval($row['id_client']); 
                    $client_name = htmlspecialchars($row['client_name']);
                    echo "<option value=$id_client>$client_name</option>\r\n"; 
                } 
                echo "</select>\r\n";
                echo '</td>';
                echo '</tr>';

                //Марка

                echo '<tr>'; 
                echo '<td>Марка</td>'; 
                echo '<td>'; 
                $sql2 = 'SELECT * FROM autos'; 

                $res2 = mysqli_query($link,$sql2) or die( "Error in $sql2 : " . mysql_error());
                
                echo '<select class="input" name="id_auto">\r\n';
                echo '<option selected value="'.(int)$item['id_auto'].'">'.$item['name_auto'].'</option>';
                echo '<option disabled>------------------</option>';
                while($row = mysqli_fetch_array($res2)) 
                { 
                    $id_auto = intval($row['id_auto']); 
                    $name_auto = htmlspecialchars($row['name_auto']);
                    echo "<option value=$id_auto>$name_auto</option>\r\n"; 
                } 
                echo "</select>\r\n";
                echo '</td>';
                echo '</tr>';

                //Дата аренды

                echo '<tr>';
                echo '<td>Дата аренды</td>';
                echo '<td>';
                echo '<input class="input" type="text" name="rent_date" value="'.$item['rent_date'].'">';
                echo '</td>';

                //Дата сдачи

                echo '<tr>';
                echo '<td>Дата сдачи</td>';
                echo '<td>';
                echo '<input class="input" type="text" name="return_date" value="'.$item['return_date'].'">';
                echo '</td>';
                echo '</td>';
                echo '</tr>';

                echo '<tr align="center" class="tbl">';
                echo '<td colspan="2"><input class="btn" type="submit" value="Сохранить"/></td>';
                echo '</tr>';
                echo '</table>';
                echo '</form>';
                echo '</div>';
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=rent.php">';
            }    
        }

        function add_item(){
            global $link;
                $id_rent = mysqli_escape_string($link, $_POST['id_rent']);
                $id_client = mysqli_escape_string($link, $_POST['id_client']);
                $client_name = mysqli_escape_string($link, $_POST['client_name']);
                $id_auto = mysqli_escape_string($link, $_POST['id_auto']);
                $name_auto = mysqli_escape_string($link, $_POST['name_auto']);
                $rent_date = mysqli_escape_string($link, $_POST['rent_date']);
                $return_date = mysqli_escape_string($link, $_POST['return_date']);

               // $query = "INSERT INTO active (inv_n, name_act, id_cat, ed_izm, quantity, price, id_dep, comments, id_stat) 
                //VALUES ('".$inv_n."','".$name_act."','".$id_cat"','".$ed_izm"','".$quantity"','".$price"','".$ed_dep"','".$comments"','".$id_stat"');";
                
                $query = "INSERT INTO rent (id_rent, id_client, id_auto, rent_date, return_date) 
                VALUES ('".$id_rent."','".$id_client."','".$id_auto."','".$rent_date."','".$return_date."')";
                mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                echo '<meta http-equiv="refresh" content="0;URL=rent.php">';
                die();
        }

        function get_edit_item_form(){
            if ($_SESSION['status'] == 1) {
                global $link;

                echo '<div class="d_cont">';
                echo '<h2>Редактировать</h2>'; 
                $query = 'SELECT * FROM v_rent WHERE id_rent='.$_GET['id_rent']; 
                $res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
                $item = mysqli_fetch_array($res); 
                echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_rent='.$_GET['id_rent'].'" method="POST">'; 
                echo '<button type="button" onClick="history.back();">Отменить</button><br />';
                echo '<br><table border="1" class="data_tbl">';

                //Код проката

                echo '<tr>';
                echo '<td>Код проката</td>';
                echo '<td>';
                echo '<input class="input" type="text" name="id_rent" value="'.$item['id_rent'].'">';
                echo '</td>';

                //ФИО клиента

                echo '<tr>'; 
                echo '<td>ФИО</td>'; 
                echo '<td>'; 
                $sql1 = 'SELECT * FROM clients'; 

                $res1 = mysqli_query($link,$sql1) or die( "Error in $sql1 : " . mysql_error());
                
                echo '<select class="input" name="id_client">\r\n';
                echo '<option selected value="'.(int)$item['id_client'].'">'.$item['client_name'].'</option>';
                echo '<option disabled>------------------</option>';
                while($row = mysqli_fetch_array($res1)) 
                { 
                    $id_client = intval($row['id_client']); 
                    $client_name = htmlspecialchars($row['client_name']);
                    echo "<option value=$id_client>$client_name</option>\r\n"; 
                } 
                echo "</select>\r\n";
                echo '</td>';
                echo '</tr>';

                //Марка

                echo '<tr>'; 
                echo '<td>Марка</td>'; 
                echo '<td>'; 
                $sql2 = 'SELECT * FROM autos'; 

                $res2 = mysqli_query($link,$sql2) or die( "Error in $sql2 : " . mysql_error());
                
                echo '<select class="input" name="id_auto">\r\n';
                echo '<option selected value="'.(int)$item['id_auto'].'">'.$item['name_auto'].'</option>';
                echo '<option disabled>------------------</option>';
                while($row = mysqli_fetch_array($res2)) 
                { 
                    $id_auto = intval($row['id_auto']); 
                    $name_auto = htmlspecialchars($row['name_auto']);
                    echo "<option value=$id_auto>$name_auto</option>\r\n"; 
                } 
                echo "</select>\r\n";
                echo '</td>';
                echo '</tr>';

                //Дата аренды

                echo '<tr>';
                echo '<td>Дата аренды</td>';
                echo '<td>';
                echo '<input class="input" type="text" name="rent_date" value="'.$item['rent_date'].'">';
                echo '</td>';

                //Дата сдачи

                echo '<tr>';
                echo '<td>Дата сдачи</td>';
                echo '<td>';
                echo '<input class="input" type="text" name="return_date" value="'.$item['return_date'].'">';
                echo '</td>';
                echo '</td>';
                echo '</tr>';

                echo '<tr align="center" class="tbl">';
                echo '<td colspan="2"><input class="btn" type="submit" value="Сохранить"/></td>';
                echo '</tr>';
                echo '</table>';
                echo '</form>';
                echo '</div>';
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=rent.php">';
            }  
        }
        function update_item(){
            global $link;
                $id_rent = mysqli_escape_string($link, $_POST['id_rent']);
                $id_client = mysqli_escape_string($link, $_POST['id_client']);
                $client_name = mysqli_escape_string($link, $_POST['client_name']);
                $id_auto = mysqli_escape_string($link, $_POST['id_auto']);
                $name_auto = mysqli_escape_string($link, $_POST['name_auto']);
                $rent_date = mysqli_escape_string($link, $_POST['rent_date']);
                $return_date = mysqli_escape_string($link, $_POST['return_date']);

                $query = "UPDATE rent SET id_rent='".$id_rent."',id_client='".$id_client."',client_name='".$client_name."',id_auto='".$id_auto."',name_auto='".$name_auto."',rent_date='".$rent_date."',return_date='".$return_date."' WHERE id_rent=".$_GET['id_rent'];
                mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                echo '<meta http-equiv="refresh" content="0;URL=rent.php">';
                die();
        }

        function delete_item(){ 
            if ($_SESSION['status'] == 1) {
                global $link; 
                    $query = "DELETE FROM rent WHERE id_rent=".$_GET['id_rent'];
                    mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                    echo '<meta http-equiv="refresh" content="0;URL=rent.php">';
                    die();
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=rent.php">';
            }    
        }
        
    ?>
</body>
</html>