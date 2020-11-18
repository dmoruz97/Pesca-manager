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

    $current_pass = md5($_GET['cp']);
    $new_pass = md5($_GET['np']);
    $new_pass_confirm = md5($_GET['npc']);

    $out = 0;

    require_once("connection.php");

    $sql_select = "SELECT password FROM utenti WHERE username='$username'";
    $result = mysqli_query($connection, $sql_select);

    if ($result){
        $row = mysqli_fetch_array($result);
        $pass = $row['password'];

        if ($pass == $current_pass){
            if ($new_pass == $new_pass_confirm){
                if ($new_pass == $pass){
                    $out = 1;
                }
                else {
                    $sql_update = "UPDATE utenti SET password='$new_pass' WHERE username='$username'";
                    $goodQuery = mysqli_query($connection, $sql_update);

                    if ($goodQuery){
                        $out = 2;
                    }
                    else {
                        $out = 3;
                    }
                }
            }
            else {
                $out = 4;
            }
        }
        else {
            $out = 5;
        }
    }
    else {
        $out = 6;
    }

    mysqli_close($connection);

    echo $out;

?>