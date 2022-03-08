<?php
include("server_data.php");
include("query_sql.php");

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);

if (!$conexion) {
    die("Fallo: " . mysqli_connect_error());
}
$url=$_REQUEST["url"];
$sql = "SELECT * from feed where url='".$url."';";
$resultado = ConsultarSQL($servidor, $usuario, $contrasena, $basedatos, $sql);
$numeroURLS = count($resultado);
echo  $numeroURLS;
?>