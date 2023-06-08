<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/script.js"></script>
    <title>Автомобили</title>
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

            $query = 'SELECT * FROM autos';
            $res = mysqli_query($link, $query);

            echo '<div class="d_cont">';
            echo '<h2>Наши автомобили</h2>';
            echo '<button type="button" onClick="history.back();">Назад</button><br>';
            echo '<br><table border="1" class="data_tbl">';
            echo '<tr align="center"><th>Код автомобиля</th><th>Марка</th><th>Тип кузова</th><th>Год выпуска</th><th>Стоимость автомобиля/сутки</th><th>Залог</th><th colspan="7"></th></tr>';

            if (empty($_SESSION['id'])) {
                while ($item = mysqli_fetch_array($res)) {
                    echo '<tr align="center" class="tbl">';
                    echo '<td>'.$item['id_auto'].'</td>';
                    echo '<td>'.$item['name_auto'].'</td>';
                    echo '<td>'.$item['type_auto'].'</td>';
                    echo '<td>'.$item['auto_year'].'</td>';
                    echo '<td>'.$item['auto_price'].'</td>';
                    echo '<td>'.$item['auto_deposit'].'</td>';
                    echo '<td colspan="2"></td>';
                }

            } elseif ($_SESSION['status'] == 1){
                while ($item = mysqli_fetch_array($res)) {
                    echo '<tr align="center" class="tbl">';
                    echo '<td>'.$item['id_auto'].'</td>';
                    echo '<td>'.$item['name_auto'].'</td>';
                    echo '<td>'.$item['type_auto'].'</td>';
                    echo '<td>'.$item['auto_year'].'</td>';
                    echo '<td>'.$item['auto_price'].'</td>';
                    echo '<td>'.$item['auto_deposit'].'</td>';
                    echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=editform&id_auto='.$item['id_auto'].'"><img src="img/edit.png" title="Редактировать"></a></td>'; 
                    echo '<td><a href="'.$_SERVER['PHP_SELF'].'?action=delete&id_auto='.$item['id_auto'].'"><img src="img/drop.png" title="Удалить" onClick="return confirmDelete()"></a></td>'; 
                }

                echo '<tr align="center"><td colspan="10">
                    <a href="'.$_SERVER['PHP_SELF'].'?action=addform"<button class="btn" type="button">Добавить</button></a>
                </td></tr>';
                
            } else {
                while ($item = mysqli_fetch_array($res)) {
                    echo '<tr align="center" class="tbl">';
                    echo '<td>'.$item['id_auto'].'</td>';
                    echo '<td>'.$item['name_auto'].'</td>';
                    echo '<td>'.$item['type_auto'].'</td>';
                    echo '<td>'.$item['auto_year'].'</td>';
                    echo '<td>'.$item['auto_price'].'</td>';
                    echo '<td>'.$item['auto_deposit'].'</td>';
                    echo '<td colspan="2"></td>';
                }
            }

            echo '</table>';
            echo '</div>';
        }

        function get_add_item_form(){
            if ($_SESSION['status'] == 1) {
                echo '<div class="d_cont">';
                echo '<h2>Добавить автомобиль</h2>';
                echo '<form name="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">';
                echo '<button type="button" onClick="history.back();">Назад</button><br>';
                echo '<br><table border="1" class="data_tbl">';
                echo '<tr>';
                echo '<td>Автомобиль</td>';
                echo '<td><input class="input" type="text" name="name_auto" value="" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Тип кузова</td>';
                echo '<td><input class="input" type="text" name="type_auto" value="" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Год выпуска</td>';
                echo '<td><input class="input" type="text" name="auto_year" value="" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Стоимость автомобиля/сутки</td>';
                echo '<td><input class="input" type="text" name="auto_price" value="" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Залог</td>';
                echo '<td><input class="input" type="text" name="auto_deposit" value="" /></td>';
                echo '<tr>';
                echo '<tr align="center" class="tbl">';
                echo '<td colspan="2"><input class="btn" type="submit" value="Сохранить"/></td>';
                echo '</tr>';
                echo '</table>';
                echo '</form>';
                echo '</div>';
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=autos.php">';
            }
            
        }

        function add_item(){
            global $link;
                $name_auto = mysqli_escape_string($link, $_POST['name_auto']);
                $type_auto = mysqli_escape_string($link, $_POST['type_auto']);
                $auto_year = mysqli_escape_string($link, $_POST['auto_year']);
                $auto_price = mysqli_escape_string($link, $_POST['auto_price']);
                $auto_deposit = mysqli_escape_string($link, $_POST['auto_deposit']);
                $query = "INSERT INTO autos (name_auto, type_auto, auto_year, auto_price, auto_deposit) VALUES ('".$name_auto."','".$type_auto."','".$auto_year."','".$auto_price."','".$auto_deposit."');";
                mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                echo '<meta http-equiv="refresh" content="0;URL=autos.php">';
                die();
        }

        function get_edit_item_form(){
            global $link;
            $query = 'SELECT * FROM autos WHERE id_auto='.$_GET['id_auto'];
            $res = mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
            $item = mysqli_fetch_array($res);
            
            if ($_SESSION['status'] == 1) {
                echo '<div class="d_cont">';
                echo '<h2>Редактировать</h2>';
                echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id_auto='.$_GET['id_auto'].'" method="POST">';
                echo '<button type="button" onClick="history.back();">Назад</button><br>';
                echo '<br><table border="1" class="data_tbl">';
                echo '<tr>';
                echo '<td>Автомобиль</td>';
                echo '<td><input class="input" type="text" name="name_auto" value="'.$item['name_auto'].'" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Тип кузова</td>';
                echo '<td><input class="input" type="text" name="type_auto" value="'.$item['type_auto'].'" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Год выпуска</td>';
                echo '<td><input class="input" type="text" name="auto_year" value="'.$item['auto_year'].'" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Стоимость автомобиля/сутки</td>';
                echo '<td><input class="input" type="text" name="auto_price" value="'.$item['auto_price'].'" /></td>';
                echo '<tr>';
                echo '<tr>';
                echo '<td>Залог</td>';
                echo '<td><input class="input" type="text" name="auto_deposit" value="'.$item['auto_deposit'].'" /></td>';
                echo '<tr>';
                echo '<tr align="center" class="tbl">';
                echo '<td colspan="2"><input class="btn" type="submit" value="Сохранить"/></td>';
                echo '</tr>';
                echo '</table>';
                echo '</form>';
                echo '</div>';
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=autos.php">';
            }
        }

        function update_item(){
            global $link;
                $name_auto = mysqli_escape_string($link, $_POST['name_auto']);
                $type_auto = mysqli_escape_string($link, $_POST['type_auto']);
                $auto_year = mysqli_escape_string($link, $_POST['auto_year']);
                $auto_price = mysqli_escape_string($link, $_POST['auto_price']);
                $auto_deposit = mysqli_escape_string($link, $_POST['auto_deposit']);
                $query = "UPDATE autos SET name_auto='".$name_auto."', type_auto='".$type_auto."', auto_year='".$auto_year."', auto_price='".$auto_price."', auto_deposit='".$auto_deposit."' WHERE id_auto=".$_GET['id_auto'];
                mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                echo '<meta http-equiv="refresh" content="0;URL=autos.php">';
                die();
        }

        function delete_item(){
            if ($_SESSION['status'] == 1) {
                global $link;
                    $query = "DELETE FROM autos WHERE id_auto=".$_GET['id_auto'];
                    mysqli_query ($link, $query) or die ("Ошибка" . mysqli_error($link));
                    echo '<meta http-equiv="refresh" content="0;URL=autos.php">';
                    die();
            } else {
                echo '<meta http-equiv="refresh" content="0;URL=autos.php">';
            }
        }
    ?>
</body>
</html>