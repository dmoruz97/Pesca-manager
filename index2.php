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

            function noOpacity(){
                document.getElementById('pagina').style.opacity = '';
            }

            function showToastMex(str){
                Materialize.toast(str, 3000, 'rounded')
            }

            function clearBoxForAdmin() {
                document.getElementById('my_search').value = '';
                select_actions('VP');
            }
            function clearBoxForAdmin2() {
                document.getElementById('search').value = '';
            }

            function changeColorSearch2() {
                document.getElementById('imm_lente').src = 'http://localhost/Pesca/img/search_black.png';
            }

            function add_action(){

                var w = 450;
                var h = 500;
                var l = Math.floor((screen.width-w)/2);
                var t = Math.floor((screen.height-h)/2);

                document.getElementById('pagina').style.opacity = '0.2';
                window.open("addPremio.php","Aggiungi Premio","width=" + w + ",height=" + h + ",top=" + t + ",left=" + l + ",scrollbars=no,resizable=no");
            }

            function conta_numero_premi() {
                /* OTTENIMENTO NUMERO TOTALE DEI PREMI */
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
                        var tot_premi = xmlhttp.responseText;
                        document.getElementById('titolo_scelta').innerHTML = 'VISUALIZZA PREMI <span id=\"totale\">(totale: '+tot_premi+')</span>';

                        /* VISUALIZZAZIONE DEI PREMI */
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
                                document.getElementById('contesto').innerHTML = xmlhttp.responseText;
                            }
                        };

                        xmlhttp.open("GET", 'visualizza_premi.php', true);
                        xmlhttp.send();
                        xmlhttp.close();
                    }
                };

                xmlhttp.open("GET", 'conta_premi.php', true);
                xmlhttp.send();
                xmlhttp.close();
            }

            function select_actions(codice){

                var call_page = '';
                var xmlhttp;

                var s_box = document.getElementById('ricerca_sup');
                document.getElementById('my_search').value = '';

                var pul_add = document.getElementById('pulsante_add');
                var tit = document.getElementById('titolo_scelta');

                switch (codice){
                    case 'VP':
                        s_box.style.visibility = 'visible';
                        pul_add.style.visibility = 'visible';
                        call_page = 'visualizza_premi';
                        conta_numero_premi();
                        break;
                    case 'CP':
                        s_box.style.visibility = 'hidden';
                        pul_add.style.visibility = 'hidden';
                        call_page = 'cerca_premi';
                        tit.innerHTML = 'CERCA PREMI';
                        break;
                    case 'MP':
                        s_box.style.visibility = 'hidden';
                        pul_add.style.visibility = 'hidden';
                        call_page = 'modifica_password';
                        tit.innerHTML='MODIFICA PASSWORD';
                        break;
                    case 'S':
                        s_box.style.visibility = 'hidden';
                        pul_add.style.visibility = 'hidden';
                        call_page = 'statistiche';
                        tit.innerHTML='STATISTICHE';
                        break;
                    default:
                        alert("Stringa NON valida!");
                }

                if (codice != 'VP') {
                    call_page = call_page + '.php';

                    /* GESTIONE RICHIESTA AJAX */
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    }
                    else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById('contesto').innerHTML = xmlhttp.responseText;
                        }
                    };

                    xmlhttp.open("GET", call_page, true);
                    xmlhttp.send();
                    xmlhttp.close();
                }
            }

            function riconosciBottone(str){

                var cod = str.split('x');

                var row = cod[0];
                var col = cod[1];     // col = 1 --> Modifica premio
                                      // col = 2 --> Rimuovi premio

                var numbers = document.getElementsByClassName('num');
                var numero = Number(numbers.item(row).textContent);

                var names = document.getElementsByClassName('nome');
                var nome = names.item(row).textContent;

                var positions = document.getElementsByClassName('pos');
                var posizione = positions.item(row).textContent;

                var descriptions = document.getElementsByClassName('descr');
                var descrizione = descriptions.item(row).textContent;

                var query_string = '?num='+numero+'&nom='+nome+'&pos='+posizione+'&des='+descrizione;

                if (col == 1){  // MODIFICA PREMIO
                    var w = 450;
                    var h = 450;
                    var l = Math.floor((screen.width-w)/2);
                    var t = Math.floor((screen.height-h)/2);

                    document.getElementById('pagina').style.opacity = '0.2';
                    window.open("editPremio.php"+query_string,"Modifica Premio","width=" + w + ",height=" + h + ",top=" + t + ",left=" + l + ",scrollbars=no,resizable=no");
                }
                else {  // ELIMINA PREMIO
                    var ris = confirm("Vuoi davvero rimuovere il premio?");
                    if (ris === true) {
                        // GESTIONE RICHIESTA AJAX
                        if (window.XMLHttpRequest) {
                            // code for IE7+, Firefox, Chrome, Opera, Safari
                            var xmlhttp = new XMLHttpRequest();
                        }
                        else {
                            // code for IE6, IE5
                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange = function() {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                showToastMex('Premio eliminato correttamente!');
                                select_actions('VP');
                            }
                        };

                        var call_page = "elimina_premio.php?num="+numero;

                        xmlhttp.open("GET", call_page, true);
                        xmlhttp.send();
                        xmlhttp.close();
                    }
                }

            }

            function mod_pass(){
                /* GESTIONE RICHIESTA AJAX */
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
                        var ris = xmlhttp.responseText;

                        if (ris == 1){
                            showToastMex('La nuova password coincide con quella già in uso!');
                        }
                        else if (ris == 2){
                            showToastMex('Password modificata correttamente!');
                        }
                        else if (ris == 3 || ris == 6){
                            showToastMex('Impossibile modificare la password esistente!');
                        }
                        else if (ris == 4){
                            showToastMex('La nuova password non coincide!');
                        }
                        else if (ris == 5){
                            showToastMex('Password non valida!');
                        }

                        if (ris == 2){
                            select_actions('VP');
                        }
                        else {
                            select_actions('MP');
                        }
                    }
                };

                var cp = document.getElementById('current_pass').value;
                var np = document.getElementById('new_pass').value;
                var npc = document.getElementById('new_pass_confirm').value;

                var query_string = '?cp='+cp+'&np='+np+'&npc='+npc;
                var call_page = "modifica_password_noForm.php" + query_string;

                xmlhttp.open("GET", call_page, true);
                xmlhttp.send();
                xmlhttp.close();
            }

            function search_premi() {

                var txt = document.getElementById('my_search').value;

                if (txt != "") {
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
                            document.getElementById('contesto').innerHTML = xmlhttp.responseText;
                        }
                    };

                    var call_page = "cerca_premio_filtro.php?in="+txt;

                    xmlhttp.open("GET", call_page, true);
                    xmlhttp.send();
                    xmlhttp.close();
                }
                else {
                    select_actions('VP');
                }
            }

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

        <!-- SCRIPT PER L'ANIMAZIONE DEL MESSAGGIO INIZIALE -->
        <script type="text/javascript" language="javascript">
            function nascondi_messaggio_iniziale(){
                var el = document.getElementById("messaggio_iniziale");
                el.style.opacity = 1;

                var tick = function(){
                    el.style.opacity = +el.style.opacity - 0.01;
                    if (+el.style.opacity > 0){
                        (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick,16)
                    }
                };
                tick();
            }
            setTimeout("nascondi_messaggio_iniziale()", 3000);
            document.getElementById("messaggio_iniziale").style.opacity = 0;
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
        </style>
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
                    <div id="scelta">Scegli un'azione</div>
                    <div id="titolo_scelta">Parrocchia San Vigilio di Dosson</div>

                    <div id="ricerca_sup">
                        <label class="label-icon" for="my_search"><i class="material-icons"><img id="imm_lente2" src="img/search_black.png" style="position: relative; top: 10px" width="40" height="40"></i></label>
                        <input onkeyup="if(event.keyCode!=13)search_premi()" onkeydown="if(event.keyCode==13) clearBoxForAdmin()" id="my_search" type="search">
                    </div>

                    <a onclick="add_action()" id="pulsante_add" title="Aggiungi premio" class="btn-floating btn-large waves-effect waves-light">+</a>
                    <a href="downloadPDFpremi.php" target="_blank">
                        <img src="img/print.png" id="print_imm" width="40" height="40" title="Genera PDF premi">
                    </a>
                </div>

                <div id="contenuto">
                    <div id="menu">
                        <br>
                        <div class="azione" onclick="select_actions('VP')">Visualizza premi</div>
                        <div class="azione" onclick="select_actions('CP')">Cerca premi</div>
                        <div class="azione" onclick="select_actions('MP')">Modifica password</div>
                        <div class="azione" onclick="select_actions('S')">Statistiche</div>
                    </div>
                    <div id="contesto">

                    </div>

                    <div id="messaggio_iniziale">
                        Benvenuto!<br>
                        Seleziona un'operazione<br>
                        a lato per cominciare.
                    </div>
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
