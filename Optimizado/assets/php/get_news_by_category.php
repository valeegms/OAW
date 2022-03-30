<?php
require_once('autoloader.php');
include("query_sql.php");
include("server_data.php");
include("print_news_function.php");
setlocale(LC_TIME, "es_MX.UTF-8", "Spanish");
date_default_timezone_set("America/Mexico_City");

$category = file_get_contents("php://input");
$sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url WHERE news.category='".$category."'";
$newsArray = ConsultarSQL($servidor, $usuario, $contrasena, $basedatos, $sql);

printNews($newsArray);