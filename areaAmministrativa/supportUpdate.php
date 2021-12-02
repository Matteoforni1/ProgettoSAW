<?php 
	function check_book($ISBN,$con) {
		$check_query="SELECT ISBN FROM libro WHERE libro.ISBN='$ISBN'";
		$check=mysqli_query($con,$check_query);
		if (mysqli_affected_rows($con) == 1) {
			mysqli_free_result($check);
			return 0;
		}
		else {
			mysqli_free_result($check);
			return 1;
		}
	}


		 session_start();
	    if (!isset($_SESSION["admin"])){
			header('Location: adiminLogin.php');
			exit();
		}
		else {
			
			require('../comuni/header.php');    
		    require('../comuni/nav.php');
			require('../DB_connections/db_admin_access.php');
			$conn=superadmin_access();
			if (isset($_GET['id'])){
				$ISBN=$_GET['id'];
				$prize=$_POST['costo'];
				$query="UPDATE libro SET costo='$prize' WHERE ISBN='$ISBN'";
				$res = mysqli_query($conn,$query);
				echo "Prezzo aggiornato."; 
				mysqli_close($conn);
				header('Location: allBooks.php');
				exit();
			}
			else {
				$ISBN=$_POST['ISBN'];
				$nome=trim($_POST['nome']);
				$autori=trim($_POST['autori']);
				$costo=$_POST['costo'];
				$data=$_POST['data'];
				$nome = mysqli_real_escape_string($conn,$nome);
				$autori = mysqli_real_escape_string($conn,$autori);
				$check_res = check_book($ISBN,$conn);
				if ($check_res == 0) {
					if (session_status() === PHP_SESSION_NONE) {
							session_start();
					}
					$_SESSION_["errore"]="ISBN inserito è già presente nel db";
					mysqli_close($conn);
					header("Location: updateBook.php");
					exit();
				}
				$query="INSERT INTO libro (ISBN,nome,autori,costo,data-pub,voto,num-rec) VALUES ('$ISBN','$nome','$autori','$costo','$data',0,0)"; 
				$result=mysqli_query($conn,$query);
				if (mysqli_affected_rows($conn)!=1) {
					if (session_status() === PHP_SESSION_NONE) {
						session_start();
					}
					$_SESSION_["errore"]="si è verificato un errore nell inserimento";
					mysqli_close($conn);
					header("Location: updateBook.php");
					exit();
				}
				mysqli_close($conn);
				header("Location: allBooks.php");
				exit();
			}
		}
?>