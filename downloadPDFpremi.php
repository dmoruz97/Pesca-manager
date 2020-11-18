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

    require('fpdf181/mysql_table.php');

    class PDF extends PDF_MySQL_Table {

        function Header(){
            $this->Image('img/san_vigilio.png',90,5,20,20);
            $this->SetTextColor(6,152,236);
            $this->SetFontSize(42);
            $this->Ln(10);
            $this->Ln(10);
            $this->Cell(0,6,'Pesca Dosson',0,1,'C');
            $this->Ln(10);
            parent::Header();
        }

        function Footer(){
            $this->SetY(-15);
            $this->SetFontSize(8);
            $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
            parent::Footer();
        }
    }
	$host = "localhost"; // Hostname
    $user = "root";   // Username database
    $password = "root";   // Password database
    $db_name = "pesca"; // Nome database

    $connection = mysqli_connect($host, $user, $password, $db_name);
    if (!$connection) {
        die("Impossibile connettersi: ".mysqli_error($connection));
    }

    //mysql_connect('localhost','root','root');
    //mysql_select_db('pesca');

    //$link = mysqli_connect('localhost','root','root','pesca');

    $pdf = new PDF();
    $pdf->SetTitle('Pesca Dosson');
    $pdf->SetAuthor('Davide Moruzzi');
    $pdf->AddFont('Roboto','','Roboto-Light.php');
    $pdf->SetFont('Roboto','',18);

    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->Cell(0,6,"Parrocchia San Vigilio di Dosson",0,1,'C');
    $pdf->Ln(10);

    $pdf->SetFont('Roboto','',18);

    /* The 1st parameter must match the column names in MySQL table */
    $pdf->AddCol("numero",20,'NUMERO','C');
    $pdf->AddCol("nome",50,'NOME','C');
    $pdf->AddCol("posizione",50,'POSIZIONE','C');
    $pdf->AddCol("descrizione",50,'DESCRIZIONE','C');

    //$pdf->SetTextColor(255,255,255);
    $format = array(
        "HeaderColor"=>array(244,109,117),
        "color1"=>array(230,230,230),
        "color2"=>array(250,250,250),
        "padding"=>1
    );
    $pdf->Table($connection,'SELECT numero,nome,posizione,descrizione FROM premi', $format);



    //mysqli_close();

    $pdf->Output('I',"PescaDosson.pdf");

?>
