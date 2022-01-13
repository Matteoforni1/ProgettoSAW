<?php
			session_start();
            require('DB_connections/webuser_access.php');           		//mi connetto al DB
            
            echo "<div>";
			$Id_Utente = '7';
            $GetCarrello = "SELECT * FROM carrello WHERE id_utente = ?";	//scrivo query per ottenere elementi nel carrello
			$con = webuser_access();
            $stmt = $con->prepare($GetCarrello);                             	//faccio prepared statement        
            $stmt->bind_param('i', $Id_Utente);	
            if(!$stmt->execute()){						//se ho errore nell'esecuzione vado alla error page
                header('Location: Error_Page.php');
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
                $GetAcquistaLibro = "SELECT libro.nome, carrello.costo, carrello.id_utente, libro.ISBN, carrello.quantita FROM (libro INNER JOIN carrello) WHERE carrello.id_utente = ? AND carrello.ISBN = libro.ISBN";		//scrivo query per ottenere dati del libro
                $stmt = $con->prepare($GetAcquistaLibro);                              									//faccio prepared statement 
                $stmt->bind_param('i', $Id_Utente);				
                if(!$stmt->execute()){															//se ho errore nell'esecuzione vado alla error page
                    header('Location: Error_Page.php');
                    exit;
                }
                $res = $stmt->get_result();                                           				//prendo risultati query
                $row = $res->fetch_assoc(); 
                $rowcount = $res->num_rows;
                $i = 0;
				$Totale = 0;
                while($i < $rowcount){										//finchè ho libri, stampo i dati del libro corrente
                    $Acquisto = htmlspecialchars($row['nome']);
                    $Prezzo = $row['costo'];
                    $ISBN = $row['ISBN'];
					$Quantita = $row['quantita'];
					$Totale = $Totale + $Prezzo;
					$Costo = $Prezzo / $Quantita;
                    echo "<div class='subordine'>";
                        echo "<span>".$Acquisto."</span>";
                        $url = '"../carrello/EliminaArticolo.php?ISBN='.$ISBN.'"';				//bottone per l'eliminazione del libro dal carrello
                        echo "<span><i onclick='remove(this, ".$url.")'></i></span>";
			echo "<span> Quantità: ".$Quantita."</span>";
			echo "<div>";
				echo "<span> Modifica Quantita: </span>";
				echo "<form id='mod_q' name='mod_q' method='POST' action='ModificaQuantita.php?ISBN=".$ISBN."&id_utente=".$Id_Utente."&costo=".$Costo."'>";
					echo "<input type='number' id='nuovaquantita' name='nuovaquantita' min='1'>";								
					echo "<input type='submit' id='immetti' value='Conferma'>";							//form per la modifica della quantita di libri con lo stesso ISBN che si desiderano acquistare
				echo "</form>";
			echo "</div>";
                        echo "<span>".$Prezzo." €</span>";
						echo "<span>".$ISBN."</span>";
                    echo "</div>";
					echo "<div>";
						echo "<form id='elimina' name='elimina' method ='POST' action='EliminaArticolo.php?ISBN=".$ISBN."&id_utente=".$Id_Utente."'>";
							echo "<input type='submit' id='eliminazione' value='Elimina'>";
						echo "</form>";
					echo "</div>";
                    $i++;
                    $row = $res->fetch_assoc();  
                }
                $stmt->close();
                if($Costo == 0) {
                    echo "<p id='vuoto'>Carrello vuoto!</p>";
				}
                echo "</div>";
				echo "<div id='ordina'>";				
                    echo "<div id='tot'>";
                        echo "<span>Totale:</span>";
                        echo "<span>".$Totale." €</span>";
                    echo "</div>";
					if($Costo != 0) {
						echo "<a id='link' href='Ordina.php?totale=".$Totale."'><div id='ordina_ora'>Ordina ora</div></a>";			//link per ordinare, che rimanda allo script Ordina.php
					}
				echo "</div>";
            echo "</div>";
            }
			echo "<br>";
			echo "<br>";
			echo "<a href='Storico.php?id_utente=".$Id_Utente."'> Visualizza Acquisti Passati </a>";
			echo "<br>";
			echo "<br>";
			echo "<br>";
			echo "<a href='home.php'> Torna alla home </a>";
?>