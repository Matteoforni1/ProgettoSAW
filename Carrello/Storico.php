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
        if(isset($_SESSION["webuser"]) && isset($_GET['id_utente']) && $_SESSION["webuser"] == $_GET['id_utente'])                                                              //Controllo la presenza della variabile di sessione, con ID utente
            {                                                                                   //Se presente
            $Id_Utente = $_SESSION["webuser"];                                                              //Salvo nella varibile il valore del cookie
            require('../DB_connections/webuser_access.php');                     //Includo la parte comune inerente la connessione al database
    
            echo "<div id='container_storico'>";
            //Selezioni tutti gli ID degli ordini di uno specifico utente (ci serve per lo storico)
            $OttieniAcquisti = "SELECT id_acquisto, data FROM acquisto WHERE id_utente = ? ORDER BY id_acquisto DESC"; 
            $stmt = $con->prepare($OttieniAcquisti);                             //Invio della query
            $stmt->bind_param('i', $Id_Utente);
            if(!$stmt->execute()){
                header('Location: ../comuni/error_page.php');
                exit;
            }
            $res = $stmt->get_result();                                           //Risultato della query
            $row = $res->fetch_assoc(); 
            $rowcount = $res->num_rows;
            if($rowcount > 0)
                {
                echo "<h1 class='center'>Ecco gli ordini che hai effettuato</h1>";
                for($i=0; $i<$rowcount; $i++)
                    {
                    $Id_Acquisto = $row['id_acquisto'];
                    $data = htmlspecialchars($row['data']);
                    echo "<div class='ordinazione'>";
                        echo "<span class='giorno'>In data: ".$data." hai effettuato quest'ordine: </span>";
                        //Ci serve per mostrare le ordinazioni degli ordini effettuati
                        $GetAcquistoLibro = "SELECT libro.nome, libro.prezzo, id_acquisto_libro FROM (libro INNER JOIN acquisto_libro ON libro.ISBN = acquisto_libro.ISBN) WHERE id_acquisto_libro = ?";
                        $stmt2 = $con->prepare($GetAcquistoLibro);                             //Invio della query
                        $stmt2->bind_param('i', $Id_Acquisto);
                        if(!$stmt2->execute()){
                            header('Location: ../comuni/error_page.php');
                            exit;
                        }
                        $res2 = $stmt2->get_result();                                           //Risultato della query
                        $row2 = $res2->fetch_assoc(); 
                        $rowcount2 = $res2->num_rows;
                        echo "<ul>";
                        $totale = 0;
                        for($j=0; $j<$rowcount2; $j++)
                            {
                            $articolo = htmlspecialchars($row2['nome']);
                            $prezzo = $row2['prezzo'];
                            echo "<li class='lista'>".$articolo."<span class='right2'>".$prezzo."€</span></li>";
                            $totale += $prezzo;
                            $row2 = $res2->fetch_assoc();
                            }
                        echo "</ul>";
                        echo "<div class='tot_storico'>Totale: <span class='right2'>".$totale."€</span></div>";
                        $stmt2->close();
                        echo "<div class='ordina_di_nuovo'><a href='Ordina_Ancora.php?id_acquisto=".$Id_Acquisto."'>Ordina di nuovo</a></div>";
                    echo "</div>";
                    $row = $res->fetch_assoc();
                    }
                }
            else
                {
                echo "<h1>Non hai effettuato nessun ordine!</h1>";
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
        require('../comuni/footer.php');         //Includo la parte comune (footer)
        ?>

    </body>

</html>