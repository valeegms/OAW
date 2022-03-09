<?php
    include("server_data.php");
	include("rss.php");
	include("save_news.php");
    
	$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
	if (!$conexion) {
		die("Fallo: " . mysqli_connect_error());
	}

	$sql = "INSERT INTO feed(url, category, feed_title) VALUES ('" . $_REQUEST["url"] . "', '" . $_REQUEST["categoria"] . "', '" . getFeedTitle($_REQUEST["url"]) . "')";
	$resultado = mysqli_query($conexion, $sql);
	$sql = "SELECT id FROM feed WHERE url = '" . $_REQUEST["url"] . "'";
	$resultado = mysqli_query($conexion, $sql);
	$id = $resultado -> fetch_assoc();
	save_news($_REQUEST["url"], $id['id']);
    //echo $id['id'];
	mysqli_close($conexion);

    header("location: ../../index.html");
?>