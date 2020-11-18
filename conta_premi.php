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

    $sql_select = "SELECT COUNT(*) AS tot FROM premi";
    $result = mysqli_query($connection, $sql_select);

    $tot = 0;

    if ($result){
        $row = mysqli_fetch_array($result);
        $tot = $row['tot'];
    }

    mysqli_close($connection);

    echo $tot;

?>