const dateInputUpdate = document.querySelector("#dateInput-update");

dateInputUpdate.onchange = function(){
    const dataSelect = new Date(dateInputUpdate.value);
    const current = new Date();
    if(dataSelect > currentDate){
        const small = document.querySelector(".msgErro-update");
        small.innerText - "digite uma data válida";
        small.style.visibility = "visible";
        small.style.display = "block";
        small.style.color = "#DB5A5A";
        dataSelect.value = "";
    }else{
        const small = document.querySelector(".msgErro-update");
        small.style.visibility = "hidden";
    }
}

$(document).ready(function(){
    $("#valor, #valor-update").mask("#.##0,00", {
        reverse: true});
})