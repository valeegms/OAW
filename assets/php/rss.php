<?php

$url = '';
$category;

if(isset($_POST['url'])) {
    $url = $_POST['url'];
}

if(isset($_POST['category'])) {
    $category = $_POST['category'];
}

echo $url;

require_once('autoloader.php');

setlocale(LC_TIME, "es_MX.UTF-8", "Spanish");
date_default_timezone_set("America/Mexico_City");

$feed = new SimplePie();
 

$feed->set_feed_url($url);

// cache
$feed->enable_cache(true);
$feed->set_cache_location('../../cache');
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

$itemArray = array();

foreach ($feed->get_items() as $feedItem) {
    $content = $feedItem->get_content();

    $itemPermalink = $feedItem->get_permalink();
    $itemTitle = $feedItem->get_title();
    $itemImageURL = returnScrapedImage($content);
    $itemText = returnText($content);
    $itemDate = $feedItem->get_local_date("Publicado el %d de %B del %Y a las %H:%M");

    $item = array();
    array_push($item, $itemPermalink, $itemTitle, $itemImageURL, $itemText, $itemDate);

    $itemArray[] = $item;
}

echo json_encode($itemArray);



