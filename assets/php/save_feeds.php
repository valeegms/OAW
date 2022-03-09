<?php
    include("server_data.php");
	include("get_news.php");
	include("save_news.php");
    
	$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
	if (!$conexion) {
		die("Fallo: " . mysqli_connect_error());
	}

	$sql = "INSERT INTO feed(feed_url, category, feed_title) VALUES ('" . $_REQUEST["url"] . "', '" . $_REQUEST["categoria"] . "', '" . getFeedTitle($_REQUEST["url"]) . "')";
	$resultado = mysqli_query($conexion, $sql);
	save_news(explode(",",$_REQUEST["url"]));
    //echo $id['id'];
	mysqli_close($conexion);

    header("location: ../../index.html");
?>