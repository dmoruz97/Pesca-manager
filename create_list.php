<?php
    session_start();

    if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }
    else {
        echo "<link type='text/css' rel='stylesheet' href='css/materialize.min.css' media='screen,projection'/>";
        echo "<div style='position: relative; margin-top: 20%; text-align: center; font-size: 32px;'>Impossibile caricare la pagina.<br>Effettuare prima il login!<br><a href='index.php'>Vai alla pagina di login</a></div>";
        die();
    }

    $in = $_GET['in'];
    if ($in == 'n') {
        $temp = $_POST['nome'];
    }
    else {
        $temp = $_POST['posizione'];
    }
    $list = '<ul>';

    require_once ("connection.php");
    if ($in == 'n') {
        $sql_select = "SELECT DISTINCT nome FROM premi WHERE nome LIKE '$temp%'";
    }
    else {
        $sql_select = "SELECT DISTINCT posizione FROM premi WHERE posizione LIKE '$temp%'";
    }

    $result = mysqli_query($connection, $sql_select);
    $row = mysqli_num_rows($result);

    if($row > 0){
        while($row = mysqli_fetch_array($result)){
            if ($in == 'n') {
                $list .= '<li>' . $row['nome'] . '</li>';
            }
            else {
                $list .= '<li>' . $row['posizione'] . '</li>';
            }
        }
    }

    $list .= '</ul>';
    mysqli_close($connection);

    echo $list;
    unset($list);

?>