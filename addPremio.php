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

	$nome = "";
	$posizione = "";
	$descrizione = "";
    $ctrl_nome = 0;
    $ctrl_pos = 0;
    $quantita = 1;

    if (isset($_POST["submit"])) {

        $nome = $_POST['nome'];
        $quantita = $_POST['quantita'];
        $posizione = $_POST['posizione'];
        $descrizione = $_POST['descrizione'];

		$posizione = str_replace ("°", "^", $posizione);

        if ($nome == '') {
            $ctrl_nome = 1;
        }
        if ($posizione == ''){
            $ctrl_pos = 1;
        }

        if ($ctrl_nome != 1 && $ctrl_pos != 1) {
            require_once("connection.php");

            // Ottenimento dell'indice da cui far partire i premi da inserire
            $goodQuery = false;
            $num = 0;
            $sql_select = "SELECT indice FROM indice_premio";
            $goodQuery = mysqli_query($connection, $sql_select);
            if ($goodQuery) {
                $row = mysqli_fetch_array($goodQuery);
                $num = $row['indice'];
            }

            $goodQuery = false;

            for ($i = 0; $i < $quantita; $i++) {
                $sql_insert = "INSERT INTO premi VALUES (null,'$num','$nome','$posizione','$descrizione')";
                $goodQuery = mysqli_query($connection, $sql_insert);
                $num++;
            }

            $sql_update = "UPDATE indice_premio SET indice='$num'";
            $goodQuery = mysqli_query($connection, $sql_update);

            mysqli_close($connection);

            if ($goodQuery) {
                echo "<script type='text/javascript' language='javascript'>
                            var finestra_padre = window.opener;
                            finestra_padre.noOpacity();
                            window.close();
                            finestra_padre.showToastMex('Premio inserito correttamente!');
                            finestra_padre.select_actions('VP');
                      </script>";
            } else {
                echo "<script type='text/javascript' language='javascript'>
                            var finestra_padre = window.opener;
                            finestra_padre.noOpacity();
                            window.close();
                            finestra_padre.showToastMex('Impossibile inserire il premio!');
                      </script>";
            }
        }
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

        <script type="text/javascript" language="javascript">
            function chiudiFinestra(){
                var finestra_padre = window.opener;
                finestra_padre.noOpacity();
                window.close();
            }

            function changeValueText(){
                var val = document.getElementById('quantita').value;

                document.getElementById('quant').style.color = '#03A69B';
                document.getElementById('show_quantita').value = val;
            }

            function changeValueRange(){
                var val = document.getElementById('show_quantita').value;

                document.getElementById('quantita').value = val;
            }

            function resetColor(){
                document.getElementById('quant').style.color = '#9E9E9E';
            }
        </script>

        <style type="text/css">
            html,body {
                font-family: "Roboto";
                text-align: center;
            }
            div#testa {
                font-size: 32px;
                margin-bottom: 20px;
            }
            div#scelta {
                font-size: 24px;
            }
            input#quantita {
                width: 180px;
                position: relative;
                left: 125px;
            }
            label#quant {
                position: relative;
                bottom: 20px;
                font-size: 20px;
            }
            div#quantity {
                width: 40px;
                height: 20px;
                position: absolute;
                right: 60px;
                top: 130px;
            }
            div#suggestBoxList,#suggestBoxList2 {
                font-size: 20px;
                z-index: 3;
                color: #FFFFFF;
                background-color: #03A69B;
            }
            li:hover {
                cursor: pointer;
            }
            span.empty {
                color: #F06E73;
                position: absolute;
                left: -20px;
                top: 20px;
                font-size: 32px;
            }
        </style>
    </head>

    <body>
        <!-- Import Scriptacolous .js file to autocomplete input -->
        <script type="text/javascript" src="js/prototype.js"></script>
        <script type="text/javascript" src="js/effects.js"></script>
        <script type="text/javascript" src="js/controls.js"></script>

        <div id="testa">
            Aggiungi Premio
        </div>
        <div id="corpo">
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="addPremio">
                <div class="row">
                    <div class="col s12">
                        <div class="input-field inline">
                            <?php if ($ctrl_nome == 1){ echo "<span class='empty'>*</span>"; } ?>
                            <input id="nome" name="nome" type="text" class="validate" value="<?php echo $nome; ?>" autofocus required>
                            <label style="font-size: 22px; top: -25px" for="nome" data-error="wrong">Nome</label>
                            <div id="suggestBoxList" class="suggestBox"></div>
                            <script type="text/javascript">
                                new Ajax.Autocompleter("nome", "suggestBoxList", "create_list.php?in=n", {minChars: 1});
                            </script>
                        </div>
                    </div>
                    <div style="color: #FFFFFF; font-size: 10px">spazio</div>
                    <div class="col s12">
                        <p class="range-field">
                            <input onmousemove="changeValueText()" onmouseout="resetColor()" type="range" id="quantita" name="quantita" min="1" max="200" value="1" required/>
                            <label id="quant" for="quantita">Quantit&agrave;</label>
                        </p>
                        <div id="quantity">
                            <input onkeyup="changeValueRange()" id="show_quantita" type="text" class="validate" value="<?php echo $quantita; ?>">
                            <label for="show_quantita" data-error="wrong"></label>
                        </div>
                    </div>
                    <div style="color: #FFFFFF; font-size: 10px">spazio</div>
                    <div class="col s12">
                        <div class="input-field inline">
                            <?php if ($ctrl_pos == 1){ echo "<span class='empty'>*</span>"; } ?>
                            <input id="posizione" name="posizione" type="text" class="validate" value="<?php echo $posizione; ?>" required>
                            <label style="font-size: 22px; top: -25px" for="posizione" data-error="wrong">Posizione</label>
                            <div id="suggestBoxList2" class="suggestBox2"></div>
                            <script type="text/javascript">
                                new Ajax.Autocompleter("posizione", "suggestBoxList2", "create_list.php?in=p", {minChars: 1});
                            </script>
                        </div>
                    </div>
                    <div style="color: #FFFFFF; font-size: 10px">spazio</div>
                    <div class="col s12">
                        <div class="input-field inline">
                            <input id="descrizione" name="descrizione" type="text" class="validate" value="<?php echo $descrizione; ?>">
                            <label style="font-size: 22px; top: -25px" for="descrizione" data-error="wrong">Descrizione</label>
                        </div>
                    </div>
                </div>
                <div id="scelta">
                    <input class="waves-effect waves-light btn" type="submit" id="submit" name="submit" value="AGGIUNGI">
                    <input class="waves-effect waves-light btn" type="reset" id="reset" name="reset" value="ANNULLA" onclick="chiudiFinestra()">
                </div>
            </form>
        </div>
    </body>
</html>
