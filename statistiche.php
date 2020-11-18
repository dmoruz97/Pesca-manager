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
?>
<!DOCTYPE html>
<html lang="it" xmlns="http://www.w3.org/1999/xhtml" xml:lang="it">
    <head>
        <title>Pesca di Beneficenza</title>
        <meta charset="UTF-8">
        <meta name="author" content="Davide Moruzzi">
        <meta name="description" content="Pesca di Beneficenza">
        <meta name="copyright" content="www.parrocchiadosson.it">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/fonts_family.css"/>

        <style type="text/css">
            @font-face {
                font-family: "Roboto";
                src: url(fonts/roboto/Roboto-Light.ttf) format("truetype");
            }
            @font-face {
                font-family: "Roboto";
                src: url(fonts/roboto/Roboto-Light.woff) format("woff");
            }
            @font-face {
                font-family: "Roboto";
                src: url(fonts/roboto/Roboto-Light.eot) format("eot");
            }
        </style>

        <style type="text/css">
            html,body {
                font-family: "Roboto";
            }
            table {
                position: absolute;
                left: 250px;
                width: 400px;
            }
            td {
                font-size: 20px;
                width: 200px;
                text-align: center;
            }
            th {
                font-size: 22px;
                width: 200px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
            require_once ("connection.php");

            $sql_select = "SELECT giorno,num_ricerche FROM statistiche";
            $result = mysqli_query($connection, $sql_select);

            $rows = mysqli_num_rows($result);
            if ($rows == 0){
            echo "<div id=\"box_risultato\">
                Impossibile aggiornare<br>la tabella 'Statistiche'.
            </div>";
            }
            else {
            echo "<div id='tab_ricerche'>";
                echo "
                    <table class=\"striped responsive-table\">\n
                        <thead>\n
                            <tr>\n
                                <th class='th_class'>GIORNO</th>\n
                                <th class='th_class'>#RICERCHE</th>\n
                            </tr>\n
                        </thead>\n
                    <tbody>\n
                ";
                $row = mysqli_fetch_array($result);
                while ($row){
                    $giorno = $row['giorno'];
                    $num = $row['num_ricerche'];

                    $d = explode('-',$giorno);
                    $giorno = $d[2].'-'.$d[1].'-'.$d[0];

                    echo "<tr>\n
                            <td class='num'>$giorno</td>\n
                            <td class='nome'>$num</td>\n
                         </tr>\n
                    ";

                    $row = mysqli_fetch_array($result);
                }
                echo "</div>";
            }

            mysqli_close($connection);
        ?>
    </body>
</html>
