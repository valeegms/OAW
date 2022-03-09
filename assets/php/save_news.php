<?php

function save_news ($feed_urls)
{
    foreach ($feed_urls as $feed_url) {
        include("server_data.php");
        require_once('autoloader.php');


        setlocale(LC_TIME, "es_MX.UTF-8", "Spanish");
        date_default_timezone_set("America/Mexico_City");

        $feed = new SimplePie();
        $feed->set_feed_url($feed_url);
        $feed->enable_cache(true);
        $feed->set_cache_location('..\..\cache');
        $feed->set_cache_duration(120);
        $feed->init();
        $feed->handle_content_type();

        $conexion = mysqli_connect($servidor, $usuario, $contrasena, $basedatos);
        if (!$conexion) {
            die("Fallo: " . mysqli_connect_error());
        }

        foreach ($feed->get_items() as $feedItem) {
            $content = $feedItem->get_content();
            $itemPermalink = $feedItem->get_permalink();
            $itemTitle = $feedItem->get_title();
            $itemImageURL = returnScrapedImage($content);
            if ($itemImageURL === "") {
                $itemImageURL = $feedItem->get_feed()->get_image_url();
                if ($itemImageURL === null) {
                    $itemImageURL = "assets/icons/default-news-image.png";
                }
            }
            $itemText = returnText($content);

            $itemDate = $feedItem->get_local_date("%Y-%m-%d %H:%M:%S");

            $categoryLabel = "Sin categor&iacutea";
            if ($category = $feedItem->get_category()) {
                $categoryLabel = $category->get_label();
            }

            $sql = "INSERT INTO news(feed_url, news_title, image_url, category,text,date,link) 
			VALUES ('" . $feed_url . "','" . $itemTitle . "', '" . $itemImageURL . "', '" . $categoryLabel . "', '" . $itemText . "','" . $itemDate . "','" . $itemPermalink . "')";
            mysqli_query($conexion, $sql);
        }


        mysqli_close($conexion);

    }
    header("location: ../../index.html");
}
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
?>