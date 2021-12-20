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
		header('Location:login.php');
		exit();
	}
	else{
		$lastactivity=$_SESSION["last_activity"];
		$lastactivity= time() - $lastactivity;
		if($lastactivity > 1800) {
			session_unset();
			session_destroy();
			header('Location:login.php');
			exit();
		}
		else {
			$_SESSION["last_activity"]=time();
			require('DB_connections/webadmin_access.php');
			$conn=webadmin_access();
			if (isset($_GET['id'])){
				$ISBN=trim($_GET['id']);
				$ISBN= mysqli_real_escape_string($conn,$ISBN);
				$prize= mysqli_real_escape_string($conn,$_POST['costo']);
				$pattern="/^([0-9]{3})[-][0-9][-]([0-9]{2})[-]([0-9]{6})[-][0-9]$/";
				if (preg_match($pattern, $ISBN)) {
					$query="UPDATE libro SET costo='$prize' WHERE ISBN='$ISBN'";
					$res = mysqli_query($conn,$query);
					mysqli_close($conn);
					header('Location: allBooks.php');
					exit();
				}
				else {
					if (session_status() !== PHP_SESSION_ACTIVE) {
								session_start();
						}
					$_SESSION["errore"]="vi è stato un errore nel caricamento, ripetere l operazione";
					mysqli_close($conn);
					header("Location: allBooks.php");
					exit();
				}
			}
			else {
				$ISBN=trim($_POST['ISBN']);
				$nome=trim($_POST['nome']);
				$autori=trim($_POST['autori']);
				$gen=($_POST['genere']);
				$imm= trim($_POST['immagine']);
				$ISBN = mysqli_real_escape_string($conn,$ISBN);
				$costo=mysqli_real_escape_string($conn,$_POST['costo']);
				$data=mysqli_real_escape_string($conn,$_POST['data']);
				$nome = mysqli_real_escape_string($conn,$nome);
				$autori = mysqli_real_escape_string($conn,$autori);
				$imm=mysqli_real_escape_string($conn,$imm);
				$pattern1="/^([0-9]{3})[-][0-9][-]([0-9]{2})[-]([0-9]{6})[-][0-9]$/";
				$pattern2="/^(\w{1,30})((.jpg)|(.png))$/";
				if (preg_match($pattern1,$ISBN)) {
					$check_res = check_book($ISBN,$conn);
					if ($check_res == 0) {
						if (session_status() !== PHP_SESSION_ACTIVE) {
								session_start();
						}
						$_SESSION["errore"]="ISBN inserito è già presente nel db";
						mysqli_close($conn);
						header("Location: insertBook.php");
						exit();
					}
					if (preg_match($pattern2,$imm)) {
						$query1="INSERT INTO libro (ISBN,nome,autori,costo,data_pub,immagine) VALUES ('$ISBN','$nome','$autori','$costo','$data','$imm')"; 
						$result1=mysqli_query($conn,$query1);
						if (mysqli_affected_rows($conn)!=1) {
							if (session_status() !== PHP_SESSION_ACTIVE) {
								session_start();
							}
							$_SESSION["errore"]="si è verificato un errore nell inserimento";
							mysqli_close($conn);
							header("Location: insertBook.php");
							exit();
						}
						$gen=mysqli_real_escape_string($conn,$gen);
						$query2="INSERT INTO genere_libro (id_genere,ISBN) VALUES ('$gen','$ISBN')"; 
						$result2=mysqli_query($conn,$query2);
						if (mysqli_affected_rows($conn)!=1) {
							if (session_status() !== PHP_SESSION_ACTIVE) {
								session_start();
							}
							$_SESSION["errore"]="si è verificato un errore nell inserimento del genere";
							mysqli_close($conn);
							header("Location: insertBook.php");
							exit();
						}
						mysqli_close($conn);
						header("Location: allBooks.php");
						exit();
					}
					else {
						if (session_status() !== PHP_SESSION_ACTIVE) {
							session_start();
						}
						$_SESSION["errore"]="imagesrc non corretto";
						mysqli_close($conn);
						header("Location: insertBook.php");
						exit();
					}	
				}
				else {
					if (session_status() !== PHP_SESSION_ACTIVE) {
							session_start();
						}
					$_SESSION["errore"]="ISBN non corretto";
					mysqli_close($conn);
					header("Location: insertBook.php");
					exit();
				}
			}
		}
	}
	
?>
