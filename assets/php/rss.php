<?php

require_once('autoloader.php');

setlocale(LC_TIME, "es_MX.UTF-8", "Spanish");
date_default_timezone_set("America/Mexico_City");

$feed = new SimplePie();

$json = file_get_contents('php://input');
$feedUrls = json_decode($json);

$feed->set_feed_url($feedUrls);
// cache
$feed->enable_cache(true);
$feed->set_cache_location('..\..\cache');
$feed->set_cache_duration(120);
 

$feed->init();
 

$feed->handle_content_type();

function returnScrapedImage ($text) {
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $pattern = "/<img[^>]+\>/i";
    preg_match($pattern, $text, $matches);
    if (empty($matches)) return "";
    else $text = $matches[0];
    $pattern = '/src=[\'"]?([^\'" >]+)[\'" >]/';
    preg_match($pattern, $text, $link);
    $link = $link[1];
    $link = urldecode($link);
    return $link;
}

function returnText ($text) {
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $pattern = "/<img[^>]+\>/i";
    preg_match_all($pattern, $text, $matches);
    foreach ($matches as $imgTag){
        $text = str_replace($imgTag,"",$text);
    }
    return $text;

}

foreach ($feed->get_items() as $feedItem) {
    $content = $feedItem->get_content();
    $itemFeedTitle = $feedItem->get_feed()->get_title();
    $itemPermalink = $feedItem->get_permalink();
    $itemTitle = $feedItem->get_title();
    $itemImageURL = returnScrapedImage($content);
    if ($itemImageURL === ""){
        $itemImageURL = $feedItem->get_feed()->get_image_url();
        if ($itemImageURL === null) {
            $itemImageURL = "assets/icons/default-news-image.png";
        }
    }
    $itemText = returnText($content);
    $itemDate = $feedItem->get_local_date("Publicado el %d de %B del %Y a las %H:%M");

    $categoryLabel = "Sin categor&iacutea";
    if ($category = $feedItem->get_category())
    {
        $categoryLabel = $category->get_label();
    }

    $format = '<div class="news d-flex justify-content-between align-items-center p-4 row w-100">
                    <div class="d-flex flex-column col-3 p-3 justify-content-center align-items-center" id="news-image-container">
                    <p>' . $itemFeedTitle . '</p>
                    <img class="news-image rounded rounded-circle" src="'. $itemImageURL . '" alt="Imagen">
                    </div>
        
                    <div class="info col-9">
                        <div class="header d-flex justify-content-between mb-4">
                            <h5 class="title">'. $itemTitle . '</h5>
                            <div class="categoria-label d-flex justify-content-center align-items-center p-2 h-50">
                                '.$categoryLabel.'
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
?>
