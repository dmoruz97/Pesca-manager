<?php
	if(!isset($_SESSION)){
		session_start();
	}

    if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
    }
    else {
        echo "<link type='text/css' rel='stylesheet' href='css/materialize.min.css' media='screen,projection'/>";
        echo "<div style='position: relative; margin-top: 20%; text-align: center; font-size: 32px;'>Impossibile caricare la pagina.<br>Effettuare prima il login!<br><a href='index.php'>Vai alla pagina di login</a></div>";
        die();
    }

    $host = "localhost"; // Hostname
    $user = "root";   // Username database
    $password = "root";   // Password database
    $db_name = "pesca"; // Nome database

    $connection = mysqli_connect($host, $user, $password, $db_name);
    if (!$connection) {
        die("Impossibile connettersi: ".mysqli_error($connection));
    }

?>
