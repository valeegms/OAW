<?php

function printNews($newsArray){
    foreach ($newsArray as $feedItem) {
        $itemFeedTitle = $feedItem["feed_title"];
        $itemPermalink = $feedItem["link"];
        $itemTitle = $feedItem["news_title"];
        $itemImageURL = $feedItem["image_url"];
        $itemText = $feedItem["text"];
        $itemDate = strftime("Publicado el %d del %B del %Y a las %H:%M",strtotime($feedItem["date"]));

        $categoryLabel = $feedItem["category"];

        $format = '<div class="news d-flex justify-content-between align-items-center p-4 row w-100">
                    <div class="d-flex flex-column col-3 p-3 justify-content-center align-items-center" id="news-image-container">
                    <p>' . $itemFeedTitle . '</p>
                    <img class="news-image rounded rounded-circle" src="'. $itemImageURL . '" alt="Imagen">
                    </div>
        
                    <div class="info col-9">
                        <div class="header d-flex justify-content-between mb-4">
                            <p class="title h5">'. $itemTitle . '</p>
                            <div class="categoria-label d-flex justify-content-center align-items-center p-2 h-50">
                                '.$categoryLabel.'
                            </div>
                        </div>
                
                        <p>' . $itemText . '</p>
                        <div class="footer d-flex justify-content-between mt-5 ">
                            <p class="fecha">' . $itemDate . '</p>
                            <div class="visitar d-flex">
                                <a class="m-0 px-2" href="' . $itemPermalink . '">Visitar sitio</a>
                                <div id="visitar-btn" class="bg-link" alt="visitar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        echo $format;
    }
}

