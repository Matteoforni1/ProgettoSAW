<!DOCTYPE html>
<html lang="it">
    <head>

        <title>Storico</title>

        <link href="../../css/stile.css" rel="stylesheet" type="text/css">
        <link href="../../css/fontawesome-free-5.14.0-web/fontawesome-free-5.14.0-web/css/all.min.css" rel="stylesheet" type="text/css">
        <link rel="shortcut icon" href="../../images/logo.png">

    </head>
    
    <body>

        <div>

            <div>
                <div>
                    <a href='../menu/reserved_page.php'><img src='../../images/logo.png' width='70' alt='logo'>
                        <span> Prefelibro </span>
                    </a>
                </div>
                <div>
                    <div>
                        <a href='../menu/reserved_page.php'>
                            Indietro
                        </a>
                    </div>
                </div>
            </div>

    <?php
        session_start();
        if(isset($_SESSION["webuser"]) && isset($_GET['id_utente']) && $_SESSION["webuser"] == $_GET['id_utente'])                                                              //Controllo sessione e id utente
            {                                                                                   //Se presente
            $Id_Utente = $_SESSION["webuser"];                                                            
            require('../DB_connections/webuser_access.php');                     //Connetto al DB
    
            echo "<div id='container_storico'>";
            $OttieniAcquisti = "SELECT id_acquisto, data FROM acquisto WHERE id_utente = ? ORDER BY id_acquisto DESC"; 		//query per ottenere tutti gli acquisti dell'utente
            $stmt = $con->prepare($OttieniAcquisti);                             //faccio prepared statement
            $stmt->bind_param('i', $Id_Utente);
            if(!$stmt->execute()){						//se ho errore nell'esecuzione vado alla error page
                header('Location: ../comuni/error_page.php');
                exit;
            }
            $res = $stmt->get_result();                                           //prendo risultati query
            $row = $res->fetch_assoc(); 
            $rowcount = $res->num_rows;
            if($rowcount > 0)							//finchè ho acquisti, li stampo a video
                {
                echo "<h1 class='center'>Ecco gli ordini che hai effettuato</h1>";
                for($i=0; $i<$rowcount; $i++)
                    {
                    $Id_Acquisto = $row['id_acquisto'];
                    $data = htmlspecialchars($row['data']);
                    echo "require(../Carrello/VisualizzaAcquistoPassato.php?id_acquisto='.$Id_Acquisto.');				//script per visualizzare info su acquisto passato
                    $row = $res->fetch_assoc();
                    }
                }
            else
                {
                echo "<h1>Non hai effettuato nessun ordine!</h1>";									//se non hai mai ordinato, ti stampa messaggio di nessun acquisto presente
                }
            $stmt->close();
            echo "</div>";
            $con->close();
        }
        else
            echo "<div><h1 style='width:100%'>Errore, pagina riservata</h1></div>";
        
    ?>

        </div>

        <?php
        require('../comuni/footer.php');         
        ?>

    </body>

</html>