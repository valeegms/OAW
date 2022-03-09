<?php
include("save_news.php");
include("server_data.php");
include("query_sql.php");
$url = file_get_contents("php://input");


$sql = "DELETE FROM news WHERE news.feed_url = '$url'";

EjecutarSQL ($servidor, $usuario, $contrasena, $basedatos, $sql);
save_news(explode(",",$url));