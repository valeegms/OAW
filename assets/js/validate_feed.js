let form = document.getElementById("add");
form.onsubmit = () => {
    if(form.elements['url'].value == "") {
        form.elements['url'].focus();
        return false;
    }
    if (new URL(form.elements['url'].value)==null){
        alert("Ingrese una URL v&aacutelida");
        return false;
    }

    if(form.elements['categoria'].value == "") {
        form.elements['categoria'].focus();
        return false;
    }
}