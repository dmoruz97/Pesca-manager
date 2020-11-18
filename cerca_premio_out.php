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

    require_once ("connection.php");

    $in = $_GET['in'];

    $sql_select = "SELECT numero,nome,posizione,descrizione FROM premi WHERE numero LIKE '$in'";
    $result = mysqli_query($connection, $sql_select);

    $rows = mysqli_num_rows($result);
    if ($rows == 0){
        $out = '';
    }
    else {
        $row = mysqli_fetch_array($result);

        $out = $row['numero']."::".$row['nome']."::".$row['posizione']."::".$row['descrizione'];
    }

    mysqli_close($connection);

    echo $out;
?>