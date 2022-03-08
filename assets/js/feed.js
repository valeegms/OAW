window.addEventListener("DOMContentLoaded", () => {
load_feeds();
}) ;

function load_feeds(){
    let feed_json;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState==XMLHttpRequest.DONE) {
            feed_json = JSON.parse(xhttp.responseText);
            load_sidebar(feed_json);
        }
    }
    xhttp.open("GET", "assets/php/load.php");
    xhttp.send();
}

function load_news_from_feed(url) {
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("news").innerHTML = this.response;
        }
    }
    xhttp.open("GET", "assets/php/rss.php?url="+url);
    xhttp.send();
}

function load_sidebar(json) {
    let sidebar = document.getElementById("source-container");
    sidebar.innerHTML = '';
    for (let i = 0; i < json.length; i++) {
        const url = json[i].url;
        sidebar.innerHTML += sidebar_format(url);
    }
    
}

function get_url(url) {
    let domain = (new URL(url));
    domain = domain.hostname.replace('www.','');
    return domain;
}

function delete_feed(url){
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            load_feeds();
        }
    }
    xhttp.open("GET", "assets/php/delete_feed.php?url="+url);
    xhttp.send();
}

function sidebar_format(url) {
    let load_news_call = "load_news_from_feed('"+ url + "')";
    let delete_call = "delete_feed('"+ url + "')"
    let format = '';
    format += '<div class="feed-source w-100 rounded-5 d-flex align-items-center justify-content-between" onclick="('+ load_news_call +')">';
    format += '<img src="http://www.google.com/s2/favicons?domain=' + get_url(url) + '" alt="">';
    format +=  '<p>' + get_url(url) + '</p>';
    format += '<img src="assets/icons/delete.png" height="50px" width="50px" onclick="('+ delete_call +')">'
    format += '</div>';

    return format;
}
