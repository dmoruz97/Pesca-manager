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
                html, body {
                    font-family: "Roboto";
                }

                #pass_form {
                    position: relative;
                    left: 100px;
                    top: 70px;
                }

                input {
                    width: 200px;
                }

                div#scelta_pass {
                    font-size: 24px;
                    position: relative;
                    top: -50px;
                    left: 220px;
                }

                div.row {
                    position: relative;
                    left: 100px;
                }

                div#pass {
                    position: relative;
                    left: 120px;
                }

                div#new_pass1 {
                    position: relative;
                    top: 30px;
                }

                div#new_pass2 {
                    position: relative;
                    left: 250px;
                    top: -45px;
                }
            </style>
        </head>

        <body>
            <div id="pass_form">
                <div class="row">
                    <div class="col s12">
                        <div id="pass" class="input-field inline">
                            <input id="current_pass" name="current_pass" type="password" class="validate" autofocus required>
                            <label style="font-size: 22px; text-align: center" for="current_pass" data-error="wrong">Password</label>
                        </div>
                    </div>
                    <div id="new_pass1" class="col s12">
                        <div class="input-field inline">
                            <input id="new_pass" name="new_pass" type="password" class="validate" required>
                            <label style="font-size: 22px; text-align: center" for="new_pass" data-error="wrong">Nuova password</label>
                        </div>
                    </div>
                    <div id="new_pass2" class="col s12">
                        <div class="input-field inline">
                            <input id="new_pass_confirm" name="new_pass_confirm" type="password" class="validate" required>
                            <label style="font-size: 22px; text-align: center; width: 200px" for="new_pass_confirm" data-error="wrong">Conferma password</label>
                        </div>
                    </div>
                </div>
                <div id="scelta_pass">
                    <input onclick="mod_pass()" class="waves-effect waves-light btn" type="submit" id="submit" name="submit" value="CONFERMA">
                </div>
            </div>
        </body>
</html>
