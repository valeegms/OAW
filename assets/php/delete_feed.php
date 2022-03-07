<?php
include("server_data.php");

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
if (!$conexion) {
    die("Fallo: " . mysqli_connect_error());
}
$url = $_REQUEST["url"];
$sql = "DELETE FROM feed WHERE feed.url = '$url'";

$resultado = mysqli_query($conexion, $sql);

mysqli_close($conexion);


?>

<?php
