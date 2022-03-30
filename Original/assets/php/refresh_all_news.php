<?php
include("save_news.php");
include("server_data.php");
include("query_sql.php");
$urls = file_get_contents("php://input");
$sql = "DELETE FROM news";
EjecutarSQL ($servidor, $usuario, $contrasena, $basedatos, $sql);
$urls = explode(",",$urls);
save_news($urls);
