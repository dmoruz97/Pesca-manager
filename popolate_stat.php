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

    $data = date('Y-m-d');

    require_once ("connection.php");

    $sql_search = "SELECT giorno FROM statistiche WHERE giorno='$data'";
    $result = mysqli_query($connection, $sql_search);

    $rows = mysqli_num_rows($result);
    if ($rows == 1){
        $sql2 = "UPDATE statistiche SET num_ricerche=num_ricerche+1 WHERE giorno='$data'";
    }
    else {
        $sql2 = "INSERT INTO statistiche VALUES (null,'$data',1)";
    }

    $result = mysqli_query($connection, $sql2);

    if (!$result){
        echo "Impossibile aggiornare la tabella 'Statistiche'";
    }

    mysqli_close($connection);

?>