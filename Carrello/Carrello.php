<?php

        if(isset($_SESSION['webuser']))
            {
            require('../DB_connections/webuser_access.php');           
            
            echo "<div>";
            $totale = 0;
	    $Id_Utente = $_SESSION['webuser'];
            $GetCarrello = "SELECT * FROM carrello WHERE id_utente = ?";
            $stmt = $con->prepare($GetCarrello);                                     
            $stmt->bind_param('i', $Id_Utente);
            if(!$stmt->execute()){
                header('Location: ../comuni/error_page.php');
                exit;
            }
            $res = $stmt->get_result();                                           
            $row = $res->fetch_assoc(); 
            $rowcount = $res->num_rows;
            $stmt->close();
            echo "<div>Carrello</div>";
            if($rowcount == 0){
                echo "<div id='containerCarrello' >";
                    echo "<p id='vuoto' class='carrello_vuoto'>Carrello vuoto!</p>";
                echo "</div>";
            }
            else if($rowcount > 0){
                echo "<div id='containerCarrello' class='scroll' >";
                $Id_Utente = $row['id_utente'];
                $_SESSION['id_utente'] = $Id_Utente;
                $GetAcquistaLibro = "SELECT libro.nome, libro.prezzo, id_utente, ISBN FROM (libro INNER JOIN carrello) WHERE id_utente = ?";
                $stmt = $con->prepare($GetAcquistaLibro);                               
                $stmt->bind_param('ii', $Id_Utente, $ISBN);
                if(!$stmt->execute()){
                    header('Location: ../comuni/error_page.php');
                    exit;
                }
                $res = $stmt->get_result();                                           
                $row = $res->fetch_assoc(); 
                $rowcount = $res->num_rows;
                $i = 0;
                while($i < $rowcount){
                    $Acquisto = htmlspecialchars($row['nome']);
                    $Prezzo = $row['prezzo'];
                    $ISBN = $row['ISBN'];
		    $Quantita = $row['quantita'];
		    $Costo = $Prezzo * $Quantita;
                    echo "<div class='subordine'>";
                        echo "<span>".$Acquisto."</span>";
                        $url = '"../carrello/EliminaArticolo.php?ISBN='.$ISBN.'"';
                        echo "<span><i onclick='remove(this, ".$url.")'></i></span>";
			echo "<span> Quantità: ".$Quantita."</span>";
			echo "<div>";
				echo "<span> Modifica Quantita: </span>";
				echo "<form id='mod_q' name='mod_q' method='POST' action='ModificaQuantita.php?ISBN=".$ISBN."&id_utente=".$Id_Utente."&quantita=".$Quantita."'>";
					echo "<input type='number' id='nuovaquantita' name='nuovaquantita' min='1'>";
					echo "<input type='submit' id='immetti' value='Conferma'>";
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
            }

            if(isset($_SESSION['id_utente'])){
                echo "<div id='ordina'>";
                    echo "<div id='tot'>";
                        echo "<span>Totale:</span>";
                        echo "<span>".$totale." €</span>";
                    echo "</div>";

                    echo "<a id='link' href='../carrello/Ordina.php'><div id='ordina_ora'>Ordina ora</div></a>";
                echo "</div>";
            }
            echo "</div>";
        }
    else
        header('Location: ../comuni/error_page.php');

?>