function toggleMobileMenu(iconSelector, menuSelector){
    const menuIcon = document.querySelector(iconSelector);
    const mobileMenu = document.querySelector(menuSelector);

    menuIcon.addEventListener("click", function(){
        const isOpen = mobileMenu.classList.constains("open");
        mobileMenu.classList.toggle("open");
        const iconSrc = isOpen ? "assets/img/menu_white_360dp.svg" : "assets/img/close_white_360dp.svg";
        menuIcon.src = iconSrc;
    });
}

toggleMobileMenu(".icon", ".mobile-menu");

function updateTable(select, mes){
    const mesReference = document.querySelector(".ref-mes");
    fetch(`assets/php/crudes/leituras.php?month=${mes}`)
    .then(response => response.text())
    .then(data =>{
        const tableCorpo = document.getElementById("table-corpo");
        tableCorpo.innerHTML = data;
        addViewIconClick();
        addDeleteClick();
        addUpdateClick();
        mesReference.textContent = select.options[select.selectedIndex].text;
    })
    .catch(erro => console.error(erro));
}
function updateCards(mes){
    fetch(`assets/php/cards.php?month=${mes}`)
    .then(res => res.json())
    .then(data =>{
        const despesas = data.despesas;
        const renda = data.renda;
        const lucro = data.lucro;

        document.querySelector(".despesas").innerHTML = despesas;
        document.querySelector(".renda").innerHTML = renda;
        document.querySelector(".lucro").innerHTML = lucro;
    })
    .catch(erro => console.error(erro));
}

function getFormattedCurrentMonth() {
    const today = new Date();
    const year = today.getFullYear();
    const month = today.getMonth() + 1;
    return `${year}-${month < 10 ? "0" : ""}${month}`;
  }

function monthChange(){
    const select = document.getElementById("mes");
    const mes = select.value;
    localStorage.setItem("selectedMonth", mes);
    const mesReference = document.querySelector(".ref-mes");
    if(mes !== "00"){
        updateTable(select, mes);
        updateCards(mes);
        mesReference.textContent = select.options[select.selectedIndex].text;
    }
}

const mesFiltro = document.querySelector("#mes");
mesFiltro.addEventListener("change", monthChange);

document.addEventListener("DOMContentLoaded", () => {
    const select = mesFiltro;
    const meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    const today = new Date();
    for (let i = 0; i < 12; i++) {
      const date = new Date(today.getFullYear(), today.getMonth() - i, 1);
      const year = date.getFullYear();
      const month = date.getMonth() + 1;
      const option = document.createElement("option");
      option.value = `${year}-${month < 10 ? "0" : ""}${month}`;
      option.text = `${meses[date.getMonth()]} ${year}`;
      select.appendChild(option);
    }
  
    const currentMonth = getFormattedCurrentMonth();
    select.value = currentMonth;
  
    monthChange();
  });

function searchTable(searchInput, tabelaInfo, resumo){
    searchInput.addEventListener("keyup", () =>{
        resumo.style.display = "none";
        let searchInputValue = searchInput.value.toLowerCase();
        let tableValues = tabelaInfo.getElementsByTagName("tr");
        for(let posicao in tableValues){
            if(true === isNaN(posicao)){
                continue;
            }
            let contentLine = tableValues[posicao].innerHTML.toLowerCase();
            if(true === contentLine.includes(searchInputValue)){
                tableValues[posicao].style.display = "";
            }else{
                tableValues[posicao].style.display = "none";
            }
        }
    })
    searchInput.addEventListener("blur", () =>{
        resumo.style.display = "";
    })
}

const searchInput = document.querySelector(".busca-input");
const tabelaInfo = document.querySelector(".table-info");
const valores = document.querySelector(".valores");
searchTable(searchInput, tabelaInfo, valores);

const modalCorpo = document.querySelector(".modal-container");
const mostrarModal = document.querySelector(".btn-open");
const closeModal = document.querySelectorAll(".close-modal");

function openModal(){
    modalCorpo.classList.add("active");
}

function closeModalCorpo(){
    modalCorpo.classList.remove("active");
}

mostrarModal.addEventListener("click", openModal);

for(let i = 0; i <closeModal.length; i++){
    closeModal[i].addEventListener("click", closeModalCorpo);
}


const dateInput = document.querySelector("#dataInput");

dateInput.addEventListener("input", function(){
    const dateSelected = new Date(dateInput.value);
    const currentDate = new Date();
    const small = document.querySelector(".msgErro");
    if(isNaN(dateSelected)){
        small.innerText = "Digite uma data válida";
        small.style.visibility = "visible";
        small.style.color = "#DB5A5A";
        return;
    }
    if(dateSelected.getTime() > currentDate.getTime()){
        small.innerText = "Digite uma data anterior ou igual à data atual";
        small.style.visibility = "visible";
        small.style.color = "#DB5A5A";
        dateInput.value = "";
    }else{
        small.style.visibility = "hidden";
    }
});

$(document).ready(function(){
    $("#valor").mask("#.##0,00", {reverse: true});
});

function createTransaction(event){
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    fetch("assets/php/crudes/registro.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data =>{
        if(data.return === "sucesso"){
            const sucessoModal = document.querySelector(".sucesso-registro");
            sucessoModal.style.visibility = "visible";
            sucessoModal.classList.add("animate");
            setTimeout(() =>{
                sucessoModal.style.visibility = "hidden";
                form.reset();
                modalCorpo.classList.remove("active");
                location.reload();
            }, 1500);
        }
    })
    .catch(erro =>{
        console.error(erro);
    });
}

document.getElementById("formReg").addEventListener("submit", createTransaction);

function addViewIconClick(){
    const verIcons = document.querySelectorAll(".view-icon");
    verIcons.forEach(verIcon =>{
        verIcon.addEventListener("click", async () =>{
            const lancID = verIcon.dataset.id;
            console.log(lancID);
            const modal = document.getElementById("ler-modal");
            const modalContent = modal.querySelector(".long-description");
            try{
                const response = await fetch(`assets/php/crudes/leituras.php?lanc_id=${lancID}`);
                const data = await response.text();
                modalContent.innerHTML = data || "Você não adicionou nenhum descrição extra nesse lançamento";
                modal.style.display	= "block";
            }catch (erro){
                console.erro("Erro ao recuperar long_description:", erro);
            }
            });
    })
}

function addUpdateClick(){
    const updateIcons = document.querySelectorAll(".update-icon");
    updateIcons.forEach(updateIcon =>{
        updateIcon.addEventListener("click", async() =>{
            const lancID = updateIcon.dataset.id;
            const modalUpdate = document.querySelector("#modal-update");
            modalUpdate.style.display = "block";
            await retrievePostingData(lancID);
            const formUpdate = document.querySelector("#form-update");
            formUpdate.addEventListener("submit", async (event) =>{
                event.preventDefault();
                const formData = new FormData(formUpdate);
                formData.append("lanc_id", lancID);
                try{
                    const response = await fetch("assets/php/crudes/update.php", {
                        method: "POST",
                        body: formData  
                    });
                    const data = await response.json();
                    if(data.return === "sucesso"){
                        const sucessoModal = document.querySelector(".sucesso-update");
                        sucessoModal.style.visibility = "visible";
                        sucessoModal.classList.add("animate");
                        setTimeout(() =>{
                            sucessoModal.style.visibility = "hidden";
                            location.reload();
                        }, 1500);
                    }else{
                        console.log(data);
                    }
                }catch (erro){
                    console.error(erro);
                }
            });
        });
    });
}

async function retrievePostingData(lancID){
    try{
        const response = await fetch(`assets/php/datas.php?id=${lancID}`);
        const data = await response.json();
        document.querySelector("#dateInput-update").value = data.datetime;
        document.querySelector("#type").value = data.type;
        document.querySelector("#subtype").value = data.subtype;
        document.querySelector("#desc-update").value = data.description;
        document.querySelector("#long-desc-update").value = data.long_description;
        document.querySelector("#valor-update").value = data.valores;
    }catch(erro){
        console.error(erro);
    }
}

function addDeleteClick(){
    const deleteIcons = document.querySelectorAll(".delete-icon");
    deleteIcons.forEach(deleteIcon =>{
        deleteIcon.addEventListener("click", () =>{
            const lancID = deleteIcon.dataset.id;
            const modalDelete = document.querySelector("#modal-delete");
            modalDelete.style.display = "block";
            const confButton = document.querySelector(".btn-delete-conf");
            confButton.addEventListener("click", async () =>{
                try{
                    const response = await fetch(`assets/php/crudes/delete.php?lanc_id=${lancID}`);
                    const data = await response.text();
                    location.reload();
                }catch(erro){
                    console.error("Erro ao excluir registro", erro);
                }
            });
        });
    });
}

function closePopUp(){
    document.querySelectorAll(".close-modal-ler, .close-modal-update, .close-modal-delete").forEach(closeButton =>{
        closeButton.addEventListener("click", () =>{
            closeButton.closest(".modal-icones").style.display = "none";
        });
    });
}
closePopUp();

const logoutBtns = document.querySelectorAll(".logout");

Array.from(logoutBtns).forEach(btn => {
    btn.addEventListener("click", () => {
      if (localStorage.getItem("selectedMonth")) {
        localStorage.removeItem("selectedMonth");
      }
    });
});

function fetchGrafico() {
    fetch("assets/php/detalhamento.php")
      .then(response => response.json())
      .then(data => {
        const ctx = document.getElementById("detalhamento").getContext("2d");
        const labels = data.map(item => `${item.mes}/${item.ano}`);
        const lucro = data.map(item => parseFloat(item.lucro.replace(".","").replace(",",".")));
        const renda = data.map(item => parseFloat(item.renda.replace(".","").replace(",",".")));
        const despesas = data.map(item => parseFloat(item.despesas.replace(".","").replace(",",".")));
        new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                label: "Balanço",
                data: lucro,
                fill: false,
                backgroundColor: "rgb(231, 195, 49)",
                borderColor: "rgb(252, 213, 53)",
                borderWidth: 1
                },
                {
                    label: "Lucro",
                    data: renda,
                    fill: false,
                    backgroundColor: "#199b4f",
                    borderColor: "#13aa52",
                    borderWidth: 1
                },
                {
                    label: "Despesas",
                    data: despesas,
                    fill: false,
                    backgroundColor: "rgb(255, 0, 0)",
                    borderColor: "rgb(209, 10, 10)",
                    borderWidth: 1
                }]
            },
            options:{
                responsive: true,
                plugins:{
                    legend:{
                        labels:{
                            color: "#fff"
                        }
                    }
                },
                scales:{
                    x:{
                        ticks: {
                            color: '#fff',
                        }
                    },
                    y:{
                        ticks: {
                            color: '#fff',
                        }
                    }
                }
            }
        });
      })
      .catch(error => {
        console.error("Erro ao buscar o JSON:", error);
      });
}
fetchGrafico();

const modalDetalhe = document.querySelector(".modal-detalhe");
const btnMais = document.querySelector(".btn-mais");
const closeDetalheModal = document.querySelectorAll(".close-modal-detalhe");

function openDetalhe(){
    modalDetalhe.style.display = "block";
    document.querySelectorAll(".options, .modal-container, .valores, .tabela").forEach(function(opacidade){
        opacidade.style.opacity = "0.5";
    });
}

function closeDetalhe(){
    modalDetalhe.style.display = "none";
    document.querySelectorAll(".options, .modal-container, .valores, .tabela").forEach(function(opacidade){
        opacidade.style.opacity = "1";
    });
}

btnMais.addEventListener("click", openDetalhe);

for(let i = 0; i < closeDetalheModal.length; i++){
    closeDetalheModal[i].addEventListener("click", closeDetalhe);
}

function updateCardsDetalhamento(){
    fetch("assets/php/detalhamento.php")
    .then(response => response.json())
    .then(data =>{
        const lucro = data.map(item => parseFloat(item.lucro.replace(".","").replace(',', '.')));
        const renda = data.map(item => parseFloat(item.renda.replace(".","").replace(',', '.')));
        const despesas = data.map(item => parseFloat(item.despesas.replace(".","").replace(',', '.')));
        let sumL = 0;
        let sumR = 0;
        let sumD = 0;
        for(let i = 0; i <lucro.length; i++){
            sumL += lucro[i];
        }
        for(let i = 0; i <renda.length; i++){
            sumR += renda[i];
            console.log(sumR);
        }
        for(let i = 0; i <despesas.length; i++){
            sumD += despesas[i];
        }

        let sumDespesas = sumD.toFixed(2);
        let sumLucro = sumL.toFixed(2);
        let sumRenda = sumR.toFixed(2);

        document.querySelector(".desepesa-detalhes").innerHTML = sumDespesas.toString();
        document.querySelector(".lucro-detalhes").innerHTML = sumRenda.toString();
        document.querySelector(".balance-detalhes").innerHTML = sumLucro.toString();

    })
    .catch(erro => console.error(erro));
}
updateCardsDetalhamento();

