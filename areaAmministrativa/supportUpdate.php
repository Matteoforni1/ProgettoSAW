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
	if (!isset($_SESSION["adminid"])){
		header('Location: adiminLogin.php');
		exit();
	}
	else{
		$lastactivity=$_SESSION["last_activity"];
		$lastactivity= time() - $lastactivity;
		if($lastactivity > 1800) {
			session_destroy();
			header('Location:login.php');
			exit();
		}
		else {
			$_SESSION["last_activity"]=time();
			require('../comuni/header.php');    
		    require('../comuni/nav.php');
			require('../DB_connections/webadmin_access.php');
			$conn=webadmin_access();
			if (isset($_GET['id'])){
				$ISBN=trim($_GET['id']);
				$ISBN= mysqli_real_escape_string($conn,$ISBN);
				$prize= mysqli_real_escape_string($conn,$_POST['costo']);
				$pattern="/^([0-9]{3})[-][0-9][-]([0-9]{2})[-]([0-9]{6})[-][0-9]$/";
				if (preg_match($pattern, $ISBN)) {
					$query="UPDATE libro SET costo='$prize' WHERE ISBN='$ISBN'";
					$res = mysqli_query($conn,$query);
					echo "Prezzo aggiornato."; 
					mysqli_close($conn);
					header('Location: allBooks.php');
					exit();
				}
				else {
					$_SESSION_["errore"]="vi è stato un errore nel caricamento, ripetere l operazione";
					mysqli_close($conn);
					header("Location: updateBook.php");
					exit();
				}
			}
			else {
				$ISBN=trim($_POST['ISBN']);
				$nome=trim($_POST['nome']);
				$autori=trim($_POST['autori']);
				$costo=mysqli_real_escape_string($conn,$_POST['costo']);
				$data=mysqli_real_escape_string($conn,$_POST['data']);
				$nome = mysqli_real_escape_string($conn,$nome);
				$autori = mysqli_real_escape_string($conn,$autori);
				$pattern="/^([0-9]{3})[-][0-9][-]([0-9]{2})[-]([0-9]{6})[-][0-9]$/";
				if (preg_match($pattern,$ISBN) {
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
					$query="INSERT INTO libro (ISBN,nome,autori,costo,data-pub) VALUES ('$ISBN','$nome','$autori','$costo','$data')"; 
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
				else {
					$_SESSION_["errore"]="ISBN non corretto";
						mysqli_close($conn);
						header("Location: updateBook.php");
						exit();
				}
			}
		}
	}
?>
