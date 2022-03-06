<?php
	include("server_data.php");
    
	$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
	if (!$conexion) {
		die("Fallo: " . mysqli_connect_error());
	}

	$sql = "SELECT url FROM feed WHERE id = 1";

	$resultado = mysqli_query($conexion, $sql);
    
	mysqli_close($conexion);

    $row = mysqli_fetch_array($resultado);
    echo $row[0];
    return $row[0];
    
?>