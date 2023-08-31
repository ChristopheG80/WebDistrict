let signupF = document.getElementById('firstnameSignUp');
let signupL = document.getElementById('lastnameSignUp');
let signupI = document.getElementById('IdentiSignUp');
let signupP = document.getElementById('PwsSignUp');
let signup = document.getElementById('signupg');
let bool = true;

signupF.addEventListener("change", function(e){
    if(signupF.value=='')bool=false;
});

signupL.addEventListener("change", function(e){
    if(signupL.value=='')bool=false;
});

signupI.addEventListener("change", function(e){
    if(signupI.value=='')bool=false;
});

signupP.addEventListener("change", function(e){
    if(signupP.value=='')bool=false;
});

signup.addEventListener("click", function(e){
    if(signupF.value=='')bool=false;
    if(signupL.value=='')bool=false;
    if(signupI.value=='')bool=false;
    if(signupP.value=='')bool=false;
    if(!bool)e.preventDefault();
});


