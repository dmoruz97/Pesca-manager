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

    if (isset($_POST["submit"])) {
        require_once("connection.php");

        $numero = $_POST['numero'];
        $nome = $_POST['nome'];
        $posizione = $_POST['posizione'];
        $descrizione = $_POST['descrizione'];

        $posizione = str_replace ("°", "^", $posizione);

        $sql = "UPDATE premi SET nome='$nome',posizione='$posizione',descrizione='$descrizione' WHERE numero='$numero'";

        $goodQuery = mysqli_query($connection, $sql);
        mysqli_close($connection);

        if ($goodQuery){
            echo "<script type='text/javascript' language='javascript'>
                        var finestra_padre = window.opener;
                        finestra_padre.noOpacity();
                        window.close();
                        finestra_padre.showToastMex('Premio modificato correttamente!');
                        finestra_padre.select_actions('VP');
                  </script>";
        }
        else {
            echo "<script type='text/javascript' language='javascript'>
                        var finestra_padre = window.opener;
                        finestra_padre.noOpacity();
                        window.close();
                        finestra_padre.showToastMex('Impossibile modificare il premio!');
                  </script>";
        }
    }
    else {
        $numero = $_GET['num'];
        $nome = $_GET['nom'];
        $posizione = $_GET['pos'];
        $descrizione = $_GET['des'];
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
            span#showNum {
                font-size: 20px;
            }
        </style>
    </head>

    <body>
        <div id="testa">
            Modifica Premio <span id="showNum">numero <?php echo $numero; ?></span>
        </div>
        <div id="corpo">
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="editPremio">
                <input type="text" name="numero" value="<?php echo $numero; ?>" hidden required>
                <div class="row">
                    <div class="col s12">
                        <div class="input-field inline">
                            <input id="nome" name="nome" type="text" class="validate" value="<?php echo $nome; ?>" required>
                            <label id="nom_id" style="font-size: 22px; top: -25px" for="nome" data-error="wrong">Nome</label>
                        </div>
                    </div>
                    <div style="color: #FFFFFF; font-size: 10px">spazio</div>
                    <div class="col s12">
                        <div class="input-field inline">
                            <input id="posizione" name="posizione" type="text" class="validate" value="<?php echo $posizione; ?>" required>
                            <label id="pos_id"style="font-size: 22px; top: -25px" for="posizione" data-error="wrong">Posizione</label>
                        </div>
                    </div>
                    <div style="color: #FFFFFF; font-size: 10px">spazio</div>
                    <div class="col s12">
                        <div class="input-field inline">
                            <input id="descrizione" name="descrizione" type="text" class="validate" value="<?php echo $descrizione; ?>">
                            <label id="descr_id" style="font-size: 22px; top: -25px" for="descrizione" data-error="wrong">Descrizione</label>
                        </div>
                    </div>
                </div>
                <div id="scelta">
                    <input class="waves-effect waves-light btn" type="submit" id="submit" name="submit" value="MODIFICA">
                    <input class="waves-effect waves-light btn" type="reset" id="reset" name="reset" value="ANNULLA" onclick="chiudiFinestra()">
                </div>
            </form>
        </div>
    </body>
</html>
