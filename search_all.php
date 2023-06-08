<?php 
    require_once('login.php');

    $search1 = $_GET['search1'];
    $search2 = $_GET['search2'];
    $search3 = $_GET['search3'];

    $search1 = mysqli_real_escape_string($link, $search1);
    $search2 = mysqli_real_escape_string($link, $search2);
    $search3 = mysqli_real_escape_string($link, $search3);

    if (empty ($search1) && empty($search2)) {
       /* $query = "SELECT * FROM v_rent WHERE name_act LIKE '%$search3%'"; */
    } elseif (empty ($search1) && empty($search2)) {
        $query = "SELECT * FROM v_rent WHERE client_name LIKE '%$search2%'";
    } elseif (empty ($search2) && empty($search3)) {
        $query = "SELECT * FROM v_rent WHERE name_auto LIKE '%$search1%'";
    } elseif (empty ($search1)){
        $query = "SELECT * FROM v_rent WHERE client_name LIKE '%$search2%'  AND name_auto  LIKE '%$search3'";
    } elseif (empty ($search2)){
        $query = "SELECT * FROM v_rent WHERE name_auto LIKE '%$search1%' AND  client_name LIKE '%$search3'";
    } elseif (empty ($search3)){
        $query = "SELECT * FROM v_rent WHERE name_auto LIKE '%$search1%' AND client_name LIKE '%$search2'";
    } else {
        $query = "SELECT * FROM v_rent WHERE name_auto LIKE '%$search1%' AND client_name LIKE '%$search2' LIKE '$search3'";
    }

    $qry_result = mysqli_query($link, $query) or die (mysqli_error());

    echo "<br/><table border=1 class='data_tbl'>";
    echo '<tr>';
    echo "<th>Код проката</th>";
    echo "<th>Код клиента</th>";
    echo "<th>ФИО клиента</th>";
    echo "<th>Код автомобиля</th>";
    echo "<th>Марка автомобиля</th>";
    echo "<th>Дата аренды</th>";
    echo "<th>Дата сдачи</th>";
    
    echo "</tr>";

    while ($row = mysqli_fetch_array($qry_result)) {
    
    echo "<tr align='center'>";
    echo "<td>$row[id_rent]</td>";
    echo "<td>$row[id_client]</td>";
    echo "<td>$row[client_name]</td>";
    echo "<td>$row[id_auto]</td>";
    echo "<td>$row[name_auto]</td>";
    echo "<td>$row[rent_date]</td>";
    echo "<td>$row[return_date]</td>";
    echo "</tr>";
    }

    echo "</table><br/>"
?>