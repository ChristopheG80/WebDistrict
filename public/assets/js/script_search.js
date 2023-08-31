let searchbar = document.getElementById('searchbar');

searchbar.addEventListener("onkeydown", (e) => {
    let keyCode = e.which ? e.which : e.keyCode;
    let touche = String.fromCharCode(keyCode);
    console.log(touche);
});