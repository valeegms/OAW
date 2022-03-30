

window.addEventListener("DOMContentLoaded", () => {

    let allBtn = document.getElementById("all");
    allBtn.onclick = ()=> {
        categoryBtn.classList.add("inactive");
        allBtn.classList.remove("inactive");
        document.getElementById("sorting-options").style.display = "revert";
        load_news("all");
    };

    let categoryBtn = document.getElementById("categories");
    categoryBtn.onclick = ()=> {
        allBtn.classList.add("inactive");
        categoryBtn.classList.remove("inactive");
        document.getElementById("sorting-options").style.display = "none";
        load_categories();
    };

    let sortBy = $("sort-by");


    sortBy.onchange = () => {
        load_news_by_order(sortBy.value);
    }


    load_sidebar();
    load_news("all");
}) ;

function $(id){
    return document.getElementById(id);
}

function load_news_by_order(order){

    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("news").innerHTML = this.response;


            let refresh = document.getElementById("refresh");
            refresh.style.cursor = "pointer";
            refresh.onclick = (e) => {
                e.stopImmediatePropagation();
                refresh_all_news("all");
            }
        }
    }
    show_loader();
    xhttp.open("POST", "assets/php/get_news_by_order.php");
    xhttp.setRequestHeader("Content-Type", "text/plain");
    xhttp.send(order);
}
function load_news_by_category(category){
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("news").innerHTML = this.response;

            let refresh = document.getElementById("refresh");
            refresh.style.cursor = "pointer";
            refresh.onclick = (e) => {
                e.stopImmediatePropagation();
                load_categories();
            }
        }
    }
    show_loader();
    xhttp.open("POST", "assets/php/get_news_by_category.php");
    xhttp.setRequestHeader("Content-Type", "text/plain");
    xhttp.send(category);
}

function load_categories(){
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = () => {
        if (xhttp.readyState === 4 && xhttp.status === 200) {
            document.getElementById("news").innerHTML = xhttp.response;
            for (let elem of document.getElementsByClassName("categoria-label")){
                elem.style.cursor = "pointer";
                elem.onclick = () => {
                    load_news_by_category(elem.innerText);
                }
            }
        }
    }

    xhttp.open("POST", "assets/php/get_categories.php");
    xhttp.send();

    let refresh = document.getElementById("refresh");
    refresh.style.cursor = "pointer";
    refresh.onclick = (e) => {
        e.stopImmediatePropagation();
        load_categories();
    }

}
function refresh_all_news(url) {
    let json;
    let xhttp = new XMLHttpRequest();
    let urls = [];
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState === XMLHttpRequest.DONE) {
            json = JSON.parse(xhttp.responseText);

            for (let i = 0; i < json.length; i++) {
                urls.push(json[i]["feed_url"]);
            }
            urls = urls.join(",");

            let xhttp2 = new XMLHttpRequest();
            xhttp2.onreadystatechange = () => {
                if (xhttp2.readyState === XMLHttpRequest.DONE) {
                    load_news(url);
                }
            }

            xhttp2.open("POST", "assets/php/refresh_all_news.php");
            xhttp2.setRequestHeader("Content-Type", "text/plain");
            xhttp2.send(urls);
        }
    }
    show_loader();
    xhttp.open("GET", "assets/php/read_db.php");
    xhttp.send();


}
function refresh_news(url){
    if (url ==="all") refresh_all_news(url);
    else {
        let xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            if (this.readyState === 4 && this.status === 200) {
                load_news(url);
            }
        }
        show_loader();
        xhttp.open("POST", "assets/php/refresh_news.php");
        xhttp.setRequestHeader("Content-Type", "text/plain");
        xhttp.send(url);
    }
}

function load_news(url) {
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("news").innerHTML = this.response;

            let refresh = document.getElementById("refresh");
            refresh.style.cursor = "pointer";
            refresh.onclick = (e) => {
                e.stopImmediatePropagation();
                refresh_news(url);
            }
        }
    }
    show_loader();
    xhttp.open("POST", "assets/php/get_news.php");
    xhttp.setRequestHeader("Content-Type", "text/plain");
    xhttp.send(url);
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
                const url = json[i]["feed_url"];
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
    let load_news_call = "load_news('"+ url + "')";
    let delete_call = "delete_feed('"+ url + "')"
    let format = '';
    format += '<div class="d-flex align-items-center justify-content-between py-2">';
    format += '<div class="feed-source rounded-5 w-75 d-flex align-items-center justify-content-center m-0" onclick="('+ load_news_call +')">';
    format += '<img src="http://www.google.com/s2/favicons?domain=' + get_url(url) + '" alt="">';
    format +=  '<p>' + get_url(url) + '</p>';
    format += '</div>';
    format += '<div id="delete" class="bg-delete" onclick="('+ delete_call +')"></div>'
    format += '</div>';

    return format;
}

function show_loader(){
    let refresh = $("refresh");
    refresh.onclick = null;
    refresh.style.cursor = "wait";
    let newsContainer = document.getElementById("news");
    newsContainer.innerHTML = "<img class='img-fluid p-4' src='assets/icons/loading.gif' alt='Loading' width='200px' height='200px'>"
    newsContainer.innerHTML += "<h2 class ='p-4'>Cargando noticias</h2>";
}

