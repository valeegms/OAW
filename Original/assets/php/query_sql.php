<?php
function ConsultarSQL ($servidor, $usuario, $contrasena, $basedatos, $sentenciaSQL){
    $conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
    if (!$conexion) {
        die("Fallo: " . mysqli_connect_error());
    }

    $resultados = mysqli_query($conexion, $sentenciaSQL);

    $registros = array();
    while ($row = mysqli_fetch_assoc($resultados)) {
        $registros[] = $row;
    }

    mysqli_close($conexion);

    return $registros;
}
function EjecutarSQL ($servidor, $usuario, $contrasena, $basedatos, $sentenciaSQL) {
    $conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
    if (!$conexion) {
        die("Fallo: " . mysqli_connect_error());
    }

    mysqli_query($conexion, $sentenciaSQL);
    mysqli_close($conexion);
}

?>