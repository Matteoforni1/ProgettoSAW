<?php
        
        session_start();
        if(isset($_SESSION['webuser']) && isset($_SESSION['id_utente']) && ($_SESSION['webuser'] == $_SESSION['id_utente']))
                {   
                require('../DB_connections/webuser_access.php');

                $Id_Utente = $_SESSION['id_utente'];

                if(!is_numeric($Id_Acquisto) || !is_numeric($Id_utente)){
                        header('Location: ../comuni/error_page.php');
                        exit;
                        }
                        //Quando si invia l'ordine, aggiorniamo i dati di esso
                        $AggiornaAcquisto = "SELECT * FROM carrello WHERE id_utente = ?"
                        $stmt = $con->prepare($AggiornaAcquisto);                             //Invio della query
                        $stmt->bind_param('i', $Id_Utente);
                        if(!$stmt->execute()){
                                header('Location: ../comuni/error_page.php');
                                exit;
                                }
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();
			$rowcount = $res->num_rows;
			$i = 0;
			$Totale = 0;
			$data = date("Y-m-d");
			while ($i < $rowcount) {
				$ISBN = $row['ISBN'];
				$Quantita = $row['quantita'];
				$Costo = $row['costo'];
				$Totale += $Costo;
				$InserisciAcquistoLibro = INSERT INTO acquisto_libro (id_acquisto_libro, ISBN, quantita, costo) VALUES (?, ?, ?, ?)";
				$stmt = $con->prepare($InserisciAcquistoLibro);
				$stmt->bind_param('iiii', $Id_Acquisto_Libro, $ISBN, $Quantita, $Costo);
				if(!$stmt->execute()){
                               		header('Location: ../comuni/error_page.php');
                                	exit;
                                }
				$num = $con->affected_rows();
				if ($num == 0) {
					echo "<span> C'è stato un errore! </span>";
					header('Location: ../comuni/error_page.php');
				}
				$row = $res->fetch_assoc();
				$i++;
			}
			$stmt->close();
			$InserisciAcquisto = "INSERT INTO acquisto (id_acquisto, id_utente, data, totale) VALUES (?, ?, ?, ?)";
			$stmt = $con->prepare(InserisciAcquisto);
			$stmt->bind_param('iisi', $Id_Acquisto_Libro, $Id_Utente, $Data, $Totale);
			if(!$stmt->execute()){
                               	header('Location: ../comuni/error_page.php');
                                exit;
                        }
			$num = $con->affected_rows();
			if ($num == 0) {
				echo "<span> C'è stato un errore! </span>";
				header('Location: ../comuni/error_page.php');
			}
			$stmt->close();
                        $CancellaCarrello = "DELETE FROM carrello WHERE id_utente = ?";
			$stmt = $con->prepare($CancellaCarrello);
			$stmt->bind_param('i', $Id_Utente);
			$num = $con->affected_rows();
			if(!$stmt->execute()){
                                header('Location: ../comuni/error_page.php');
                                exit;
                        }
			$num = $con->affected_rows();
			if ($num == 0) {
				echo "<span> C'è stato un errore! </span>";
				header('Location: ../comuni/error_page.php');
			}
			$stmt->close();
                        $_SESSION["messaggio"] = "Abbiamo ricevuto il tuo ordine correttamente!";
                        header('Location: ../menu/reserved_page.php');   
                }
        else
                {
                header('Location: ../comuni/error_page.php');
                }



?>