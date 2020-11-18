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
        <title>Pesca di Beneficenza 2017</title>
        <meta charset="UTF-8">
        <meta name="author" content="Davide Moruzzi">
        <meta name="description" content="Pesca di Beneficenza 2017">
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
            nav {
                width: 550px;
            }
            div.nav-wrapper {
                width: 550px;
            }
            div#box_ricerca {
                position: relative;
                left: 200px;
                top: 30px;
                text-align: center;
                z-index: 3;
            }
            div#box_risultato {
                position: relative;
                font-size: 46px;
                left: -160px;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div id="box_ricerca">
            <nav>
                <div class="nav-wrapper">
                    <div class="input-field">
                        <input id="search" onclick="changeColorSearch2()" onkeyup="if(event.keyCode!=13) cerca_premio()" onkeydown="if(event.keyCode==13) clearBoxForAdmin2()" type="search">
                        <label class="label-icon" for="search"><i class="material-icons"><img id="imm_lente" src="img/search_white.png" style="position: relative; top: 10px" width="40" height="40"></i></label>
                    </div>
                </div>
            </nav>
        </div>
        <br><br><br>
        <div id="box_risultato">
            Inserisci un numero<br>nella casella di ricerca.
        </div>
    </body>
</html>
