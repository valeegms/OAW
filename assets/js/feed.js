var url;
window.onload = () => {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = () => {
        if (xhttp.readyState==XMLHttpRequest.DONE) {
            url = xhttp.responseText;
            load();
        }
    }
    xhttp.open("GET", "assets/php/load.php");
    xhttp.send();    
}

function load () {
    console.log(url);
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            let itemArray = JSON.parse(this.response);
            for (let i in itemArray){
                let itemPermalink = itemArray[i][0];
                let itemTitle = itemArray[i][1];
                let itemImgUrl = itemArray[i][2];
                let itemText = itemArray[i][3];
                let itemDate = itemArray[i][4];

                let itemDiv = document.createElement("div");
                itemDiv.classList.add("container");
                itemDiv.classList.add("p-5");
                itemDiv.classList.add("text-black");
                itemDiv.classList.add("border");
                itemDiv.classList.add("border-4");
                itemDiv.classList.add("d-flex","justify-content-center","align-items-center", "flex-column");

                let itemTitleNode =  document.createElement("a");
                itemTitleNode.innerText = itemTitle;
                itemDiv.appendChild(itemTitleNode);
                itemTitleNode.setAttribute("href",itemPermalink);
                let itemTextNode =  document.createElement("div");
                itemTextNode.innerHTML = itemText;
                itemDiv.appendChild(itemTextNode);
                let itemDateNode =  document.createElement("p");
                itemDateNode.innerText = itemDate;
                itemDiv.appendChild(itemDateNode);

                if (itemImgUrl !== ""){
                    let itemImgNode =  document.createElement("img");
                    itemImgNode.setAttribute("src", itemImgUrl);
                    itemImgNode.classList.add("img-fluid");
                    itemImgNode.classList.add("border");
                    itemImgNode.classList.add("border-primary");

                    itemDiv.appendChild(itemImgNode);
                }
                document.getElementById("news").appendChild(itemDiv);
            }
        }
    }
    xhttp.open("GET", "assets/php/rss.php?url="+url);
    xhttp.send();
}

