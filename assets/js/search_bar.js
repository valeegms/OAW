let search = document.getElementById("search-input");
search.addEventListener("input", function() {
    let input = search.value;
    let titles = document.getElementsByClassName("title");
    let news = document.getElementsByClassName("news");

    for (let i = 0; i < news.length; i++) {
        news[i].style.setProperty("display","none","important")
    }

    for (let i = 1; i < titles.length;i++) {
        if (titles[i].innerHTML.toLowerCase().includes(input.toLowerCase())) {
            news[i-1].style.removeProperty("display");
        }
    }
})

