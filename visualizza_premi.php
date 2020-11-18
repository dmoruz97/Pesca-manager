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
            td {
                font-size: 18px;
                width: 200px;
                float: left;
                padding-bottom: 0;
            }
            .action {
                width: 80px;
            }
            td.num {
                text-align: center;
            }
            .descr {
                width: 180px;
            }
            .col_descr {
                width: 180px;
            }
            .pos {
                width: 240px;
            }
            .col_pos {
                width: 240px;
            }
            th {
                font-size: 18px;
                width: 200px;
                float: left;
            }
            th.empty {
                width: 80px;
            }
        </style>
    </head>

    <body>
        <?php
            require_once ("connection.php");

            $sql = "SELECT numero,nome,posizione,descrizione FROM premi";
            $result = mysqli_query($connection, $sql);

            $rows = mysqli_num_rows($result);
            if ($rows == 0){
                echo "<div class=\"warning\">NESSUN PREMIO INSERITO!</div>";
            }
            else {
                echo "
                 <table class=\"striped responsive-table\">\n
                    <thead>\n
                        <tr>\n
                            <th>&nbsp;&nbsp;&nbsp;NUMERO (o DAL AL)</th>\n
                            <th>NOME</th>\n
                            <th class='col_pos'>POSIZIONE</th>\n
                            <th class='col_descr'>DESCRIZIONE</th>\n
                            <th class='empty'></th>\n
                            <th class='empty'></th>\n
                        </tr>\n
                    </thead>\n
                    <tbody>\n
                ";

                $id = 0;

                $row = mysqli_fetch_array($result);

                while ($row) {

                    $conta = 1;
                    $next = mysqli_fetch_array($result);

                    while ($row['nome'] == $next['nome']){
                        $conta++;
                        $next = mysqli_fetch_array($result);
                    }

                    if ($conta == 1){
                        echo "<tr>\n
                                <td class='num'>&nbsp;&nbsp;&nbsp;" . $row['numero'] . "</td>\n
                                <td class='nome'>" . $row['nome'] . "</td>\n
                                <td class='pos'>" . $row['posizione'] . "</td>\n
                                <td class='descr'>" . $row['descrizione'] . "</td>\n
                                <td class='action'><a onclick=\"riconosciBottone('" . $id . "x1')\"><img class=\"imm_actions\" title=\"Modifica premio\" width=\"30\" height=\"30\" src=\"img/edit.png\"></a></td>\n
                                <td class='action'><a onclick=\"riconosciBottone('" . $id . "x2')\"><img class=\"imm_actions\" title=\"Rimuovi premio\" width=\"30\" height=\"30\" src=\"img/delete.png\"></a></td>\n
                             </tr>\n
                        ";
                    }
                    else if ($conta <= 5){
                        $i = 0;
                        while ($i < $conta){
                            echo "<tr>\n
                                      <td class='num'>&nbsp;&nbsp;&nbsp;" . ($row['numero']+$i) . "</td>\n
                                      <td class='nome'>" . $row['nome'] . "</td>\n
                                      <td class='pos'>" . $row['posizione'] . "</td>\n
                                      <td class='descr'>" . $row['descrizione'] . "</td>\n
                                      <td class='action'><a onclick=\"riconosciBottone('" . $id . "x1')\"><img class=\"imm_actions\" title=\"Modifica premio\" width=\"30\" height=\"30\" src=\"img/edit.png\"></a></td>\n
                                      <td class='action'><a onclick=\"riconosciBottone('" . $id . "x2')\"><img class=\"imm_actions\" title=\"Rimuovi premio\" width=\"30\" height=\"30\" src=\"img/delete.png\"></a></td>\n
                                 </tr>\n
                            ";
                            $id++;
                            $i++;
                        }
                        $id--;
                    }
                    else if ($conta > 5) {
                        echo "<tr>\n
                                <td class='num'>DAL " . $row['numero'] . " AL " . ($row['numero']+$conta-1) . "</td>\n
                                <td class='nome'>" . $row['nome'] . "</td>\n
                                <td class='pos'>" . $row['posizione'] . "</td>\n
                                <td class='descr'>" . $row['descrizione'] . "</td>\n
                                <td class='action'><img width=\"30\" height=\"30\" src=\"img/blank.png\"></td>\n
                                <td class='action'><img width=\"30\" height=\"30\" src=\"img/blank.png\"></td>\n
                             </tr>\n
                        ";
                    }
                    $id++;
                    $row = $next;
                }
                echo "
                        </tr>\n
                    </tbody>\n
                </table>\n
                ";
            }
            mysqli_close($connection);
        ?>

    </body>
</html>
