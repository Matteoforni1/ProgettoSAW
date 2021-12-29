<?php
        
        session_start();
        if(isset($_SESSION['webuser']) && isset($_SESSION['id_utente']) && ($_SESSION['webuser'] == $_SESSION['id_utente'])) 			//controllo sessione e dati passati correttamente
                {   
                require('../DB_connections/webuser_access.php');				//connetto al DB

                $Id_Utente = $_SESSION['id_utente'];

                if(!is_numeric($Id_Acquisto) || !is_numeric($Id_utente)){			//controllo validità id acquisto e id utente
                        header('Location: ../comuni/error_page.php');
                        exit;
                        }
                        $AggiornaAcquisto = "SELECT * FROM carrello WHERE id_utente = ?"	//query per ottenere il carrello dell'utente
                        $stmt = $con->prepare($AggiornaAcquisto);                            	//faccio prepared statement 
                        $stmt->bind_param('i', $Id_Utente);
                        if(!$stmt->execute()){							//se ho errore nell'esecuzione vado alla error page
                                header('Location: ../comuni/error_page.php');
                                exit;
                                }
			$res = $stmt->get_result();						//prendo risultati query
			$row = $res->fetch_assoc();
			$rowcount = $res->num_rows;
			$i = 0;
			$Totale = 0;
			$data = date("Y-m-d");
			while ($i < $rowcount) {						//finchè ho libri nel carrello, li metto in acquisto libro
				$ISBN = $row['ISBN'];
				$Quantita = $row['quantita'];
				$Costo = $row['costo'];
				$Totale += $Costo;
				$InserisciAcquistoLibro = INSERT INTO acquisto_libro (id_acquisto_libro, ISBN, quantita, costo) VALUES (?, ?, ?, ?)"; 		//query per inserire dati libro in acquisto_libro
				$stmt = $con->prepare($InserisciAcquistoLibro);											//faccio prepared statement
				$stmt->bind_param('iiii', $Id_Acquisto_Libro, $ISBN, $Quantita, $Costo);
				if(!$stmt->execute()){														//se ho errore nell'esecuzione vado alla error page
                               		header('Location: ../comuni/error_page.php');
                                	exit;
                                }
				$num = $con->affected_rows();
				if ($num == 0) {														//se la query fallisce, vado alla error page
					echo "<span> C'è stato un errore! </span>";
					header('Location: ../comuni/error_page.php');
				}
				$row = $res->fetch_assoc();
				$i++;
			}
			$stmt->close();
			$InserisciAcquisto = "INSERT INTO acquisto (id_acquisto, id_utente, data, totale) VALUES (?, ?, ?, ?)";					//query per inserire l'acquisto
			$stmt = $con->prepare(InserisciAcquisto);												//faccio prepared statement
			$stmt->bind_param('iisi', $Id_Acquisto_Libro, $Id_Utente, $Data, $Totale);
			if(!$stmt->execute()){															//se ho errore nell'esecuzione vado alla error page
                               	header('Location: ../comuni/error_page.php');
                                exit;
                        }
			$num = $con->affected_rows();
			if ($num == 0) {															//se la query fallisce vado alla error page
				echo "<span> C'è stato un errore! </span>";
				header('Location: ../comuni/error_page.php');
			}
			$stmt->close();
                        $CancellaCarrello = "DELETE FROM carrello WHERE id_utente = ?";										//query per cancellare il carrello
			$stmt = $con->prepare($CancellaCarrello);												//faccio prepared statement
			$stmt->bind_param('i', $Id_Utente);
			$num = $con->affected_rows();
			if(!$stmt->execute()){															//se ho errore nell'esecuzione vado alla error page
                                header('Location: ../comuni/error_page.php');
                                exit;
                        }
			$num = $con->affected_rows();														//se fallisce la query vado alla error page
			if ($num == 0) {
				echo "<span> C'è stato un errore! </span>";
				header('Location: ../comuni/error_page.php');
			}
			$stmt->close();
                        $_SESSION["messaggio"] = "Abbiamo ricevuto il tuo ordine correttamente!";								//messaggio per stampa ordine completato
                        header('Location: ../menu/reserved_page.php');   
                }
        else
                {
                header('Location: ../comuni/error_page.php');
                }



?>