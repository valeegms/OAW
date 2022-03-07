<?php
	include("server_data.php");
    
	$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
	if (!$conexion) {
		die("Fallo: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM feed";
	$resultado = mysqli_query($conexion, $sql);

	while($row = mysqli_fetch_array($resultado)) { 
		$id=$row['id'];
		$url=$row['url'];
		$category=$row['category'];

		$feeds[] = array('id'=> $id, 'url'=> $url, 'category'=> $category);
	}
    
	mysqli_close($conexion);

    if (isset($feeds)){
        $json_string = json_encode($feeds);
        echo $json_string;
    }
    else echo json_encode (json_decode ("{}"));

?>