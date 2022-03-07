window.onload = () => {
    let feed_json;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState==XMLHttpRequest.DONE) {
            feed_json = JSON.parse(xhttp.responseText);
            // load(feed_json[0].url);
            load_sidebar(feed_json);
        }
    }
    xhttp.open("GET", "assets/php/load.php");
    xhttp.send();    
}

function load(url) {
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

function sidebar_format(url) {
    let function_call = "load('"+ url + "')";
    let format = '';
    format += '<div class="feed-source w-100 rounded-5 d-flex align-items-center" onclick="('+ function_call +')">';
    format += '<img src="http://www.google.com/s2/favicons?domain=' + get_url(url) + '" alt="">';
    format +=  '<p>' + get_url(url) + '</p>';
    format += '</div>';

    return format;
}
