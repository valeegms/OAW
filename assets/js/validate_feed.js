let form = document.getElementById("add");

form.onsubmit = () => {

    if(form.elements['url'].value == "") {
        form.elements['url'].focus();
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
}