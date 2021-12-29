<?php

        if(isset($_SESSION['webuser']))						//controllo sessione
            {
            require('../DB_connections/webuser_access.php');           		//mi connetto al DB
            
            echo "<div>";
            $totale = 0;							//inizializzo il prezzo totale
	    $Id_Utente = $_SESSION['webuser'];
            $GetCarrello = "SELECT * FROM carrello WHERE id_utente = ?";	//scrivo query per ottenere elementi nel carrello
            $stmt = $con->prepare($GetCarrello);                             	//faccio prepared statement        
            $stmt->bind_param('i', $Id_Utente);	
            if(!$stmt->execute()){						//se ho errore nell'esecuzione vado alla error page
                header('Location: ../comuni/error_page.php');
                exit;
            }
            $res = $stmt->get_result();                                    	//prendo risultati query       
            $row = $res->fetch_assoc(); 
            $rowcount = $res->num_rows;
            $stmt->close();
            echo "<div>Carrello</div>";
            if($rowcount == 0){							//stampo messaggio di carrello vuoto se ho 0 elementi nel carrello
                echo "<div id='containerCarrello' >";
                    echo "<p id='vuoto' class='carrello_vuoto'>Carrello vuoto!</p>";
                echo "</div>";
            }
            else if($rowcount > 0){						//sennò per ogni libro presente faccio query per ottenere suoi dati
                echo "<div id='containerCarrello' class='scroll' >";
                $Id_Utente = $row['id_utente'];
                $_SESSION['id_utente'] = $Id_Utente;
                $GetAcquistaLibro = "SELECT libro.nome, libro.prezzo, id_utente, ISBN FROM (libro INNER JOIN carrello) WHERE id_utente = ?";		//scrivo query per ottenere dati del libro
                $stmt = $con->prepare($GetAcquistaLibro);                              									//faccio prepared statement 
                $stmt->bind_param('ii', $Id_Utente, $ISBN);				
                if(!$stmt->execute()){															//se ho errore nell'esecuzione vado alla error page
                    header('Location: ../comuni/error_page.php');
                    exit;
                }
                $res = $stmt->get_result();                                           				//prendo risultati query
                $row = $res->fetch_assoc(); 
                $rowcount = $res->num_rows;
                $i = 0;
                while($i < $rowcount){										//finchè ho libri, stampo i dati del libro corrente
                    $Acquisto = htmlspecialchars($row['nome']);
                    $Prezzo = $row['prezzo'];
                    $ISBN = $row['ISBN'];
		    $Quantita = $row['quantita'];
		    $Costo = $Prezzo * $Quantita;
                    echo "<div class='subordine'>";
                        echo "<span>".$Acquisto."</span>";
                        $url = '"../carrello/EliminaArticolo.php?ISBN='.$ISBN.'"';				//bottone per l'eliminazione del libro dal carrello
                        echo "<span><i onclick='remove(this, ".$url.")'></i></span>";
			echo "<span> Quantità: ".$Quantita."</span>";
			echo "<div>";
				echo "<span> Modifica Quantita: </span>";
				echo "<form id='mod_q' name='mod_q' method='POST' action='ModificaQuantita.php?ISBN=".$ISBN."&id_utente=".$Id_Utente."&quantita=".$Quantita."'>";
					echo "<input type='number' id='nuovaquantita' name='nuovaquantita' min='1'>";								
					echo "<input type='submit' id='immetti' value='Conferma'>";							//form per la modifica della quantita di libri con lo stesso ISBN che si desiderano acquistare
				echo "</form>";
			echo "</div>";
                        echo "<span>".$Costo." €</span>";
                    echo "</div>";
                    $i++;
                    $totale += $Prezzo;
                    $row = $res->fetch_assoc();  
                }
                $stmt->close();
                if($totale == 0)
                    echo "<p id='vuoto'>Carrello vuoto!</p>";
                echo "</div>";
		else {
			echo "<p>'.$Totale.'</p>";								//Stampa prezzo totale
		}
            }

            if(isset($_SESSION['id_utente'])){
                echo "<div id='ordina'>";				
                    echo "<div id='tot'>";
                        echo "<span>Totale:</span>";
                        echo "<span>".$totale." €</span>";
                    echo "</div>";

                    echo "<a id='link' href='../carrello/Ordina.php'><div id='ordina_ora'>Ordina ora</div></a>";			//link per ordinare, che rimanda allo script Ordina.php
                echo "</div>";
            }
            echo "</div>";
        }
    else
        header('Location: ../comuni/login.php');

?>