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

        <link rel="icon" href="img/chiesa_dosson.png" type="image/png">

        <link type="text/css" rel="stylesheet" href="css/main.css">

        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/fonts_family.css"/>

        <script language="JavaScript" type="text/javascript">
            function cerca_premio(){

                var input = document.getElementById('search').value;

                if (input != "") {
                    // GESTIONE RICHIESTA AJAX
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        var xmlhttp = new XMLHttpRequest();
                    }
                    else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            var ris = xmlhttp.responseText;

                            if (ris == ''){
                                document.getElementById('box_risultato').innerHTML = "Nessun premio trovato!";
                            }
                            else {
                                var premio = ris.split('::');

                                var num = premio[0];
                                var nome = premio[1];
                                var pos = premio[2];
                                var des = premio[3];

                                var new_txt = "<div id='risultato'><span class='bold'>NUMERO:</span> "+num+"<br><span class='bold'>NOME:</span> "+nome+"<br><span class='bold'>POSIZIONE:</span> "+pos+"<br><span class='bold'>DESCRIZIONE:</span> "+des+"</div>";

                                document.getElementById('box_risultato').innerHTML = new_txt;
                            }
                        }
                    };

                    var call_page = "cerca_premio_out.php?in=" + input;

                    xmlhttp.open("GET", call_page, true);
                    xmlhttp.send();
                    xmlhttp.close();
                }
                else {
                    document.getElementById('box_risultato').innerHTML = "Inserisci un numero<br>nella casella di ricerca.";
                }
            }

        </script>

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

            span#titolo_sezione {
                color: #FFFFFF;
                font-size: 34px;
            }
            div#barra_sup {
                text-align: center;
            }
            nav {
                width: 550px;
            }
            div.nav-wrapper {
                width: 550px;
            }
            div#box_ricerca {
                position: relative;
                left: 400px;
                top: 20px;
                text-align: center;
                z-index: 3;
            }
            div#box_risultato {
                position: relative;
                font-size: 46px;
                left: 40px;
                text-align: center;
            }
            div#corpo {
                background-color: #FAFAFA;
                text-align: center;
            }
            div#orologio {
                position: absolute;
                top: 350px;
                left: 30px;
                font-size: 48px;
            }
            span#ggmmaaaa {
                font-size: 26px;
            }
        </style>

        <script type="text/javascript">
            window.onload = function(){
                clock()
            };

            function clock() {

                var data = new Date();

                var day = ["Domenica", "Lunedì", "Martedì", "Mercoledì","Giovedì", "Venerdì","Sabato"];
                var giorno_str = day[data.getDay()];
                var giorno = data.getDate();

                var month = ["gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"];
                var mese = month[data.getMonth()];

                var anno = data.getFullYear();

                var ora = data.getHours();
                var min = data.getMinutes();
                var sec = data.getSeconds();

                if (ora < 10) {
                    ora = '0' + ora;
                }
                if (min < 10) {
                    min = '0' + min;
                }
                if (sec < 10){
                    sec = '0' + sec;
                }

                var output = '<span id="ggmmaaaa">' + giorno_str + ' ' + giorno + ' ' + mese + ' ' + anno + '</span><br>' + ora + ':' + min + ':' + sec;

                document.getElementById('orologio').innerHTML = output;

                setTimeout('clock()',1000);
            }

            function clearBox() {
                document.getElementById('search').value = '';

                /* PER POPOLARE TABELLA 'Statistiche' */
                var xmlhttp;

                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

                    }
                };

                var call_page = 'popolate_stat.php';
                xmlhttp.open("GET", call_page, true);
                xmlhttp.send();
                xmlhttp.close();
            }

            function changeColorSearch2() {
                document.getElementById('imm_lente').src = 'http://localhost/Pesca/img/search_black.png';
            }
        </script>
    </head>

    <body>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

        <div id="pagina">
            <header>
                <div style="position: absolute; font-size: 32px">
                    <img src="img/san_vigilio.png" title="Parrocchia San Vigilio Dosson" style="position: relative; left: 35px;">
                </div>

                <img src="img/chiesa_dosson.png" id="chiesa" alt="Chiesa di Dosson" width="700px" height="250px">
                <div id="titolo">Pesca Dosson</div>

                <div id="utente">
                    <span id="user"><?php echo $username; ?></span>
                    <a class="waves-effect waves-light btn" href="logout.php">ESCI</a>
                </div>
                <div id="giorno">
                    Oggi, <?php echo date('d/m/Y', time()); ?>
                </div>
            </header>

            <div id="corpo">
                <div id="barra_sup">
                    <span id="titolo_sezione">Parrocchia San Vigilio di Dosson</span>
                </div>

                <div id="orologio">

                </div>

                <div id="box_ricerca">
                    <nav>
                        <div class="nav-wrapper">
                            <div class="input-field">
                                <input onclick="changeColorSearch2()" onkeyup="if(event.keyCode!=13) cerca_premio()" onkeydown="if(event.keyCode==13) clearBox()" id="search" type="search" required>
                                <label class="label-icon" for="search"><i class="material-icons"><img id="imm_lente" src="img/search_white.png" style="position: relative; top: 10px" width="40" height="40"></i></label>
                            </div>
                        </div>
                    </nav>
                </div>
                <br><br>
                <div id="box_risultato">
                    Inserisci un numero<br>nella casella di ricerca.
                </div>
            </div>
        </div>

        <footer>
            <div class="container">
                <a class="grey-text text-lighten-4" href="http://www.parrocchiadosson.it">Parrocchia San Vigilio Dosson</a>
            </div>
        </footer>
    </body>
</html>
