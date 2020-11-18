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

    $num = $_GET['num'];

    $sql_delete = "DELETE FROM premi WHERE numero='$num'";
    $goodQuery = mysqli_query($connection, $sql_delete);

    if ($goodQuery){
        $sql_update = "UPDATE premi SET numero=numero-1 WHERE numero>'$num'";
        mysqli_query($connection, $sql_update);

        $sql_update2 = "UPDATE indice_premio SET indice=indice-1";
        mysqli_query($connection, $sql_update2);
    }

    mysqli_close($connection);

?>
