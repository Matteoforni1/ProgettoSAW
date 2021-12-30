<?php
include "ProgettoSAW-main/DB_Connections/webuser_access.php";
$con=webuser_access();
$params=[];
$nome="L'ombra del vento";
$params[]=$nome;
$genere="Suspense";
$params[]=$genere;
$query="SELECT l.nome,l.ISBN,l.autori,l.costo,l.data_pub,l.voto FROM libro l WHERE (1 AND l.nome=? AND L.ISBN IN (SELECT gl.ISBN FROM genere_libro gl WHERE gl.id_genere IN (SELECT g.id FROM genere g WHERE g.nome=?)))";
$stmt=mysqli_stmt_init($con);
array_unshift($params,"ss");
//array_unshift($params,$stmt);
Mysqli_stmt_prepare($stmt,$query);
//$check = call_user_func_array("mysqli_stmt_bind_param",$params);
mysqli_stmt_bind_param($stmt, ...$params);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt)>0) {
	echo(1);
}
mysqli_stmt_bind_result($stmt,$nome,$ISBN,$autori,$costo,$data,$voto);
while(mysqli_stmt_fetch($stmt)){
	echo($stmt." ".$nome." ".$ISBN." ".$autori." ".$costo." ".$data." ".$voto);
}
	
