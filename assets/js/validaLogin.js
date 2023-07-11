const loginForm = document.getElementById("loginForm");
const email = loginForm.elements.email;
const password= loginForm.elements.password;

function validaEmail(email){
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
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

function validaLogin(){
    let valido = true;
    const emailV = email.value.trim();
    const passwordV = password.value.trim();

    if(emailV === "" || !validaEmail(emailV)){
        erroValida(email, "Insira um email válido");
        valido = false;
    }else{
        sucessoValida(email);
    }
    
    if(passwordV === ""){
        erroValida(password, "Insira uma senha");
        valido = false;
    }else{
        sucessoValida(password);
    }

    return valido;
}

function login(){
    const emailV = email.value.trim();
    const passwordV = password.value.trim();
    const request = {
        email : emailV,
        password : passwordV
    }

    fetch("assets/php/validaLogin.php", {
        method: "POST",
        body: JSON.stringify(request),
        headers: {
            "Content-type": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.return === "sucesso"){
            if(data.redirect){
                window.location.href = data.redirect;
            }
        }else{
            if(data.return === "erro"){
                if(data.erroEmail){
                    erroValida(email, data.erroEmail);
                }else{
                    sucessoValida(email);
                }

                if(data.erroPassword){
                    erroValida(password, data.erroPassword);
                }else{
                    sucessoValida(password);
                }
            }
        }
    })
    .catch(erro => console.error(erro));
}

loginForm.addEventListener("submit", (e) =>{
    e.preventDefault();
    if(validaLogin()){
        login();
    }
});




