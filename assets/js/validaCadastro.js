const cadForm = document.getElementById("form");
const user = cadForm.elements.username;
const email = cadForm.elements.email;
const password= cadForm.elements.password;
const confPass = cadForm.elements.confPass;

function validaEmail(email){
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validaPass(password){
    var regex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/;
    return regex.test(password);
}

function erroValida(type, msg){
    var formCorpo = type.parentElement;
    var formMsg = formCorpo.querySelector(".erroMsg");
    formCorpo.classList.remove("sucesso");
    formCorpo.classList.add("erro");
    formMsg.innerText = msg;
}

function sucessoValida(type){
    var formCorpo = type.parentElement;
    var formMsg = formCorpo.querySelector(".erroMsg");
    formCorpo.classList.remove("erro");
    formCorpo.classList.add("sucesso");
    formMsg.innerText = "";
}

function validaCad(){
    var valido = true;
    const userV = user.value.trim();
    const emailV = email.value.trim();
    const passwordV = password.value.trim();
    const confPassV = confPass.value.trim();
    if(userV === ""){
        erroValida(user, "Insira um nome de usuario");
    }else{
        sucessoValida(user);
    }

    if(emailV === ""){
        erroValida(email, "Insira um email");
        valido = false;
    }else if(!validaEmail(emailV)){
        erroValida(email, "Insira um email válido");
        valido = false;
    }else{
        sucessoValida(email);
    }

    if(passwordV === ""){
        erroValida(password, "Insira uma senha");
        valido = false;
    }else if(passwordV.length < 6){
        erroValida(password, "A senha deve conter no mínimo 6 dígitos");
        valido = false;
    }else if(!validaPass(passwordV)){
        erroValida(password, "Sua senha deve conter pelo menos um número e um caractere especial");
        valido = false;
    }else{
        sucessoValida(password);
    }

    if(confPassV === ""){
        erroValida(confPass, "Confirme sua senha");
        valido = false;
    }else if(passwordV !== confPassV){
        erroValida(confPass, "As senha digitadas são diferentes");
        valido = false;
    }else{
        sucessoValida(confPass);
    }

    return valido;
}

function cadastro(){
    const userV = user.value.trim();
    const emailV = email.value.trim();
    const passwordV = password.value.trim();
    const confPassV = confPass.value.trim();
    const request = {
        name: userV,
        email: emailV,
        password: passwordV,
        confPass: confPassV
    }
    
    fetch("assets/php/validaCadastro.php", {
        method: "POST", 
        body: JSON.stringify(request),
        headers:{
            "Content-type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data =>{
        if(data.return == "sucesso"){
            const successModal = document.querySelector(".modal");
            successModal.style.visibility = "visible";
            successModal.classList.add('animate');
            setTimeout(() => {
               window.location.href = data.redirect;''
            }, 2000);
        }else{
            if(data.return == "erro"){
                if(data.erroName){
                    erroValida(user, data.erroName);
                }else{
                    sucessoValida(user);
                }

                if(data.erroEmail){
                    erroValida(email, data.erroEmail);
                }else{
                    sucessoValida(email);
                }
            }

            if(data.erroPassword){
                erroValida(password, data.erroPassword);
            }else{
                sucessoValida(password);
            }

            if(data.erroConfPass){
                erroValida(confPass, data.erroConfPass);
            }else{
                sucessoValida(confPass);
            }
        }
    })
    .catch(error => console.error(error));
}

cadForm.addEventListener("submit", (e) =>{
    e.preventDefault();
    validaCad();
    cadastro();
});

