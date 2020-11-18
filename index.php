<?php
    session_start();

	$ris = 0;
    if (isset($_POST['submit'])){
        if (isset($_POST['username']) && !empty($_POST['username'])){
            $username = $_POST['username'];

            if (isset($_POST['password']) && !empty($_POST['password'])){
                $password = $_POST['password'];

                $host = "localhost"; // Hostname
                $user = "root";   // Username database
                $pass = "root";   // Password database
                $db_name = "pesca";   // Nome database

                $connection = mysqli_connect($host, $user, $pass, $db_name);
                if (!$connection) {
                    die("Impossibile connettersi: ".mysqli_error($connection));
                }

                $username = strip_tags($username);
                $username = mysqli_real_escape_string($connection, $username);
                $password = strip_tags($password);
                $password = mysqli_real_escape_string($connection, $password);
                $password = md5($password);

                $sql = "SELECT * FROM utenti WHERE username='$username' AND password='$password'";

                $result = mysqli_query($connection, $sql);
                mysqli_close($connection);

                $rows = mysqli_num_rows($result);

                if ($rows == 1) {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['username'] = $row['username'];

                    if ($row['username'] == 'admin') {
                        echo "<script language=\"javascript\">document.location.href='index2.php'</script>";
                        exit;
                    }
                    else {
                        echo "<script language=\"javascript\">document.location.href='index_cerca.php'</script>";
                        exit;
                    }
                }
                else {
                    $ris = 1;
                }
            }
            else {
                $ris = 2;
            }
        }
        else {
            $ris = 3;
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

        <link rel="icon" href="img/chiesa_dosson.png" type="image/png">

        <link type="text/css" rel="stylesheet" href="css/login.css">

        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/fonts_family.css"/>
    </head>

    <body background="img/subtle-mosaic-pattern.png">
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>

        <div id="pagina">
            <div id="intestazione">
                <span id="titolo">Pesca Dosson</span>
                <br>
                <span id="sottotitolo">Parrocchia San Vigilio Dosson</span>
            </div>

            <div id="corpo">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="login">
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field inline">
                                <input id="username" name="username" type="text" class="validate" autofocus required>
                                <label style="font-size: 22px" for="username" data-error="wrong">Username</label>
                            </div>
                        </div>
                        <div style="color: #FFFFFF; font-size: 10px">spazio</div>
                        <div class="col s12">
                            <div class="input-field inline">
                                <input id="password" name="password" type="password" class="validate" required>
                                <label style="font-size: 22px" for="password" data-error="wrong">Password</label>
                            </div>
                        </div>
                    </div>
                    <div id="scelta">
                        <input class="waves-effect waves-light btn" type="submit" id="submit" name="submit" value="ACCEDI">
                        <input class="waves-effect waves-light btn" type="reset" id="reset" name="reset" value="ANNULLA">
                    </div>
                </form>
                <?php
                    if ($ris == 1){
                        echo "<div id='incorrect_input'>Username o Password errati!</div>";
                    }
                    else if ($ris == 2){
                        echo "<div id='incorrect_input'>Inserisci la password!</div>";
                    }
                    else if ($ris == 3){
                        echo "<div id='incorrect_input'>Inserisci lo username!</div>";
                    }
                ?>
            </div>
        </div>

        <footer>
            <div class="container">
                <a class="grey-text text-lighten-4" href="http://www.parrocchiadosson.it">Parrocchia San Vigilio Dosson</a>
            </div>
        </footer>
    </body>
</html>
