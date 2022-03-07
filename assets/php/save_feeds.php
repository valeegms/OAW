<?php
    include("server_data.php");
    
	$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
	if (!$conexion) {
		die("Fallo: " . mysqli_connect_error());
	}

	$sql = "INSERT INTO feed(url, category) VALUES ('" . $_REQUEST["url"] . "', '" . $_REQUEST["categoria"] . "')";

	$resultado = mysqli_query($conexion, $sql);
    
	mysqli_close($conexion);

    header("location: ../../index.html");
?>