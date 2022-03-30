<?php

require_once('autoloader.php');
include("query_sql.php");
include("server_data.php");
include("print_news_function.php");


setlocale(LC_TIME, "es_MX.UTF-8", "Spanish");
date_default_timezone_set("America/Mexico_City");

$feedUrlToSearch = file_get_contents("php://input");
if ($feedUrlToSearch ==="all") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url;";

else $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url WHERE feed.feed_url = '".$feedUrlToSearch."';";
$newsArray = ConsultarSQL($servidor, $usuario, $contrasena, $basedatos, $sql);

printNews($newsArray);

    function getFeedTitle($url){
        $feed = new SimplePie();
        $feed->set_feed_url($url);
        $feed->enable_cache(true);
        $feed->set_cache_location('..\..\cache');
        $feed->set_cache_duration(120);
        $feed->init();
        $feed->handle_content_type();
        return $feed->get_title();
    }
?>
