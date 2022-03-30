<?php

require_once('autoloader.php');
include("query_sql.php");
include("server_data.php");
include("print_news_function.php");

setlocale(LC_TIME, "es_MX.UTF-8", "Spanish");
date_default_timezone_set("America/Mexico_City");

$order = file_get_contents("php://input");
if ($order === "Más reciente") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url ORDER BY news.date DESC;";
else if ($order === "Más antiguo") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url ORDER BY news.date ASC;";
else if ($order === "A-Z") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url ORDER BY news.news_title ASC;";
else if ($order === "Z-A") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url ORDER BY news.news_title DESC;";

$newsArray = ConsultarSQL($servidor, $usuario, $contrasena, $basedatos, $sql);

printNews($newsArray);