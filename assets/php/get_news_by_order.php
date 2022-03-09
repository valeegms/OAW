<?php

require_once('autoloader.php');
include("query_sql.php");
include("server_data.php");
setlocale(LC_TIME, "es_MX.UTF-8", "Spanish");
date_default_timezone_set("America/Mexico_City");

$order = file_get_contents("php://input");
if ($order === "Más reciente") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url ORDER BY news.date DESC;";
else if ($order === "Más antiguo") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url ORDER BY news.date ASC;";
else if ($order === "A-Z") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url ORDER BY news.news_title ASC;";
else if ($order === "Z-A") $sql = "SELECT feed.feed_title, news.* FROM feed INNER JOIN news ON feed.feed_url=news.feed_url ORDER BY news.news_title DESC;";

$newsArray = ConsultarSQL($servidor, $usuario, $contrasena, $basedatos, $sql);

foreach ($newsArray as $feedItem) {
    $itemFeedTitle = $feedItem["feed_title"];
    $itemPermalink = $feedItem["link"];
    $itemTitle = $feedItem["news_title"];
    $itemImageURL = $feedItem["image_url"];
    $itemText = $feedItem["text"];
    $itemDate = strftime("Publicado el %d del %B del %Y a las %H:%M", strtotime($feedItem["date"]));

    $categoryLabel = $feedItem["category"];

    $format = '<div class="news d-flex justify-content-between align-items-center p-4 row w-100">
                    <div class="d-flex flex-column col-3 p-3 justify-content-center align-items-center" id="news-image-container">
                    <p>' . $itemFeedTitle . '</p>
                    <img class="news-image rounded rounded-circle" src="' . $itemImageURL . '" alt="Imagen">
                    </div>
        
                    <div class="info col-9">
                        <div class="header d-flex justify-content-between mb-4">
                            <h5 class="title">' . $itemTitle . '</h5>
                            <div class="categoria-label d-flex justify-content-center align-items-center p-2 h-50">
                                ' . $categoryLabel . '
                            </div>
                        </div>
                
                        <p>' . $itemText . '</p>
                        <div class="footer d-flex justify-content-between mt-5 ">
                            <p class="fecha">' . $itemDate . '</p>
                            <div class="visitar d-flex">
                                <a class="m-0 px-2" href="' . $itemPermalink . '">Visitar sitio</a>
                                <img id="visitar-btn" src="assets/icons/link.svg" alt="visitar">
                            </div>
                        </div>
                    </div>
                </div>';
    echo $format;
}