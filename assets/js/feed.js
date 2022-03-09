window.addEventListener("DOMContentLoaded", () => {

    let allBtn = document.getElementById("all");
    allBtn.onclick = load_all_news;

    load_sidebar();
    load_all_news();
}) ;

function load_all_news(){
    let json;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState===XMLHttpRequest.DONE) {
            json = JSON.parse(xhttp.responseText);
            let urls = [];
            for (let i = 0; i < json.length; i++) {
                const url = json[i].url;
                urls.push(url);
            }
            let xhttp2 = new XMLHttpRequest();
            xhttp2.onload = function() {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("news").innerHTML = this.response;
                }
            }
            show_loader();
            xhttp2.open("POST", "assets/php/rss.php");
            xhttp2.setRequestHeader("Content-Type", "application/json");
            xhttp2.send(JSON.stringify(urls));

            //Para boton de actualizar
            let refresh = document.getElementById("refresh");
            refresh.onclick = (e) => {
                e.stopImmediatePropagation();
                load_all_news(json);
            }
        }
    }
    xhttp.open("GET", "assets/php/read_db.php");
    xhttp.send();
}

function load_news_from_feed(url) {
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("news").innerHTML = this.response;
            //Para boton de actualizar
            let refresh = document.getElementById("refresh");
            refresh.onclick = (e) => {
                e.stopImmediatePropagation();
                load_news_from_feed(url);
            }
        }
    }
    show_loader();
    xhttp.open("POST", "assets/php/rss.php");
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(url));
}

function load_sidebar() {
    let json;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState === XMLHttpRequest.DONE) {
            json = JSON.parse(xhttp.responseText);
            let sidebar = document.getElementById("source-container");
            sidebar.innerHTML = '';
            for (let i = 0; i < json.length; i++) {
                const url = json[i].url;
                sidebar.innerHTML += sidebar_format(url);
            }
        }
    }
    xhttp.open("GET", "assets/php/read_db.php");
    xhttp.send();
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
            load_sidebar();
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

function show_loader(){
    let newsContainer = document.getElementById("news");
    newsContainer.innerHTML = "<img class='img-fluid p-4' src='assets/icons/loading.gif' alt='Loading' width='200px' height='200px'>"
    newsContainer.innerHTML += "<h2 class ='p-4'>Cargando noticias</h2>";
}

