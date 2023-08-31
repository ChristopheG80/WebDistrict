let quant=document.getElementById('quantite');
let prix=document.getElementById('prix');
let prixQte = document.getElementById('prixQte');

quant.addEventListener('click', function(){
    multiplie();
});

quant.addEventListener('blur', function(){
    multiplie();
});

quant.addEventListener('keydown', function(){
    multiplie();
});

function multiplie(){
    let quanti=parseInt(quant.value);
    prixQte.value=(Number(prix.innerHTML) * Number(quanti));
}
