let form = document.getElementById("add");

function verificarURL(url){
    let xhttp = new XMLHttpRequest();
    let flag;

    xhttp.onload = function() {
        if (this.readyState === 4 && this.status === 200) {
            if(this.responseText != "0"){
                flag = false;
            }else{
                flag= true;
            }
        }
    }
    xhttp.open("GET", "assets/php/verify_URL_repeated.php?url="+url,false);
    xhttp.send();
    return flag;
}
form.onsubmit = () => {
    let url = form.elements['url'].value;

    if(form.elements['url'].value == "") {
        form.elements['url'].focus();
        alert("Debe ingresar una URL")
        return false;
    }else{
        try {
            new URL(form.elements['url'].value);
        } catch (_) {
            alert("Ingrese una URL válida");
            form.elements['url'].focus();
            form.elements['url'].select();
            return false;
        }
    }

    if(form.elements['categoria'].value == "") {
        form.elements['categoria'].focus();
        return false;
    }

    if(!verificarURL(url)){
        alert("La URL ya ha sido registrada");
        form.elements['url'].focus();
        form.elements['url'].select();
        return false;
    }
}