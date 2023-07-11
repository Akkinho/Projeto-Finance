<?php 
    include_once("assets/php/includes/session.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/painel.css">
    <link rel="stylesheet" href="assets/css/painel-respon.css">
    <link rel="shortcut icon" href="assets/img/Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Gestão de Finanças</title>
</head>
<body>
    <header class="header">
        <nav class="menu">
            <div class="logo">
                <a href="#">
                    <img src="assets/img/Logo.png">
                    <h1>FINANCE</h1>
                </a>
            </div>
            <div class="links">
                <span>
                    <?php echo $_SESSION["usuario"] ?>
                </span>
                <div class="nav-item">
                    <a href="#">
                        <img src="assets/img/usuario_icon.png">
                    </a>
                    <div class="drop_menu">
                        <a href="assets/php/logout.php" class="logout">Sair</a>
                    </div>
                </div>
                <div class="mobile-menu-icon">
                    <button><img class="icon" src="assets/img/menu_white_36dp.svg" alt=""></button>
                </div>
            </div>
        </nav>
        <div class="mobile-menu">
            <div class="nav-item">
                <a href="assets/php/logout.php" class="logout links">Sair</a>
            </div>
        </div>
    </header>

    <div class="corpo">
        <div class="options">
            <div class="ref-mes"></div>
            <div class="cont-form">
                <div class="select-control">
                    <select name="select" id="mes" required name="month">
                        <option value="00" disabled selected>Mês para filtro</option>
                    </select>
                </div>
            </div>
            <div class="busca">
                <i class="bi bi-search" aria-hidden="true"></i>
                <input type="text" placeholder="Filtrar Registros" autocomplete="off" class="busca-input">
            </div>
            <button class="btn-open">+ Novo Registro</button>
        </div>
        <div class="modal-container">
            <div class="modal-corpo">
                <div class="header-modal">
                    <h2>Registro </h2>
                    <span class="close-modal">x</span>
                </div>
                <hr>
                <div class="modal-content">
                    <form action="assets/php/crudes/registro.php" method="post" id="formReg">
                        <div class="form-corpo">
                            <label class="form-label" for="dateInput">Data do lançamento</label>
                            <input type="date" name="data" id="dataInput" required>
                            <small class="msgErro"></small>
                        </div>
                        <div class="form-corpo">
                            <label for="select">Tipo</label>
                            <div class="select-control">
                                <select name="select" required>
                                    <option value="" disabled selected>Selecione</option>
                                    <option value="renda">Renda</option>
                                    <option value="despesa">Despesa</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-corpo">
                            <label for="sub-tipo">Sub Tipo</label>
                            <div class="select-control">
                                <select name="select-sub" required>
                                    <option value="" disabled selected>Selecione</option>
                                    <option value="previsto">Previsto</option>
                                    <option value="extra">extra</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-corpo-selects">
                            <label class="form-label" for="desc">Descrição Breve</label>
                            <input type="text" name="desc" placeholder="Um título para o registro" id="desc" required>
                        </div>
                        <div class="form-corpo">
                            <label class="form-label" for="longDesc">Descrição Longa</label>
                            <input type="text" name="desc-long" placeholder="Descrição detelhada [opcional]" id="long-desc">
                        </div>
                        <div class="form-corpo">
                            <label class="form-label" for="valor">Valor</label>
                            <input type="text" id="valor" name="valor" placeholder="Digite um valor R$" max="9" required>
                        </div>
                        <div class="sucesso-registro">
                            <div class="sucesso-registro-content">
                                <p class="popup">Registro adicionado</p>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="btns">
                    <button id="button-close" class="close-modal">Cancelar</button>
                    <button id="button-ok" form="formReg">Salvar</button>
                </div>
            </div>
        </div>
        <div class="valores">
            <div class="valores-cards">
                <p class="header-valores">Despesas</p>
                <div class="valores-corpo">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>&nbsp;R$</span>
                    <p class="despesas">0,00</p>
                </div>
            </div>
            <div class="valores-cards">
                <p class="header-valores">Lucro</p>
                <div class="valores-corpo">
                    <i class="bi bi-coin"></i>
                    <span>&nbsp;R$</span>
                    <p class="renda">0,00</p>
                </div>
            </div>
            <div class="valores-cards">
                <p class="header-valores">Balanço</p>
                <div class="valores-corpo">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    <span>&nbsp;R$</span>
                    <p class="lucro">0,00</p>
                </div>
            </div>
        </div>
        <div class="tabela" style="overflow-x:auto;">
            <table class="tabela-registros">
                <thead>
                    <tr>
                        <th>DATA DE LANÇAMENTO</th>
                        <th>TIPO</th>
                        <th>SUBTIPO</th>
                        <th>DESCRIÇÃO</th>
                        <th>VALOR DE LANÇAMENTO</th>
                    </tr>
                </thead>
                <tbody class="table-info" id="table-corpo">
                    <?php 
                        include_once("assets/php/crudes/leituras.php");
                    ?>
                    <button id="btn-detalhe" class="btn-mais">Ver Detalhamento</button>
                </tbody>
                <div id="ler-modal" class="ler-modal modal-icones">
                    <div class="modal-content-ler">
                        <div class="header-modal-table">
                            <h2>Detalhes dos Lançamentos</h2>
                            <span class="close-modal-ler">&times;</span>
                        </div>
                        <div class="modal-ler-corpo">
                            <p class="long-description"></p>
                        </div>
                        <div class="modal-ler-footer">
                            <button class="btn-cancel close-modal-ler">OK</button>
                        </div>
                    </div> 
                </div>

                <div id="modal-update" class="modal-update modal-icones">
                    <div class="modal-content-update">
                        <div class="header-modal-table">
                            <h2>Alterar Lançamento</h2>
                            <span class="close-modal-update">&times;</span>
                        </div>
                        <hr>
                        <div class="modal-update-corpo">
                            <form id="form-update">
                                <div class="form-corpo-selects">
                                    <label class="form-label" for="date-update">Data do lançamento</label>
                                    <input type="date" name="date-update" id="dateInput-update" required>
                                    <small class="msgErro-update">Erro</small>
                                </div>
                                <div class="form-corpo">
                                    <label for="select-update">Tipo</label>
                                    <div class="select-control">
                                        <select name="select-update" id="type" required>
                                            <option value="" disabled selected>Selecione</option>
                                            <option value="renda">Renda</option>
                                            <option value="despesa">Despesa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-corpo">
                                    <label for="subtype-update">Sub Tipo</label>
                                    <div class="select-control">
                                        <select name="subtype-update" id="subtype" required>
                                            <option value="" disabled selected>Selecione</option>
                                            <option value="previsto">Previsto</option>
                                            <option value="extra">Extra</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-corpo">
                                    <label for="desc-update">Descrição Breve</label>
                                    <input type="text" name="desc-update" placeholder="Descrição breve do registro" id="desc-update" required>
                                </div>
                                <div class="form-corpo">
                                    <label class="form-label" for="longDesc-update">Descrição Longa</label>
                                    <input type="text" name="desc-detalhada-update" id="long-desc-update" placeholder="Descrição detalhada do registro [opcional]">
                                </div>
                                <div class="form-corpo">
                                    <label class="form-label" for="valor-update">Valor</label>
                                    <input type="text" id="valor-update" name="valor-update" placeholder="Digite o valor R$" max="9">
                                </div>
                                <div class="sucesso-update">
                                    <div class="sucesso-update-content">
                                        <p class="succs-update">Registro Alterado</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <div class="btns btns-footer">
                            <button id="button-close" class="btn-cancel close-modal-delete">Cancelar</button>
                            <button id="button-ok" class="btn-update-conf" form="form-update">Salvar</button>
                        </div>
                    </div>
                </div>

                <div id="modal-delete" class="modal-delete modal-icones">
                    <div class="modal-content-delete">
                        <div class="header-modal-table">
                            <h2>Excluir Lançamento</h2>
                            <span class="close-modal-delete">&times;</span>
                        </div>
                        <div class="modal-delete-corpo">
                            <p>Tem certeza que dejesa deletar este lançamento?</p>
                        </div>
                        <div class="modal-delete-footer">
                            <button class="btn-delete-conf">SIM</button>
                            <button class="btn-cancel close-modal-delete">NÃO</button>
                        </div>
                    </div>
                </div>
            </table>
        </div>
        <div class="modal-detalhe">
            <div class="modal-content-detalhe">
                <div class="header-modal-detalhe">
                    <h2>Detalhamento dos Lançamentos</h2>
                    <span class="close-modal-detalhe">&times;</span>
                </div>
                <div class="modal-detalhe-corpo">
                    <div class="grafico">
                        <canvas id="detalhamento"></canvas>
                    </div>
                    <div class="valores-detalhes">
                        <div class="detalhes-header">Total</div>
                        <div class="cards-detalhes">
                            <p class="header-cards-detalhes">Despesas</p>
                            <div class="valores-cards-detalhes">
                                <span>R$</span>
                                <p class="desepesa-detalhes">0,00</p>
                            </div>
                        </div>
                        <div class="cards-detalhes">
                            <p class="header-cards-detalhes">Lucro</p>
                            <div class="valores-cards-detalhes">
                                <span>R$</span>
                                <p class="lucro-detalhes">0,00</p>
                            </div>
                        </div>
                        <div class="cards-detalhes">
                            <p class="header-cards-detalhes">Balanço</p>
                            <div class="valores-cards-detalhes">
                                <span>R$</span>
                                <p class="balance-detalhes">0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-detalhe-footer">
                    <button class="close-modal-detalhe btn-detalhe">FECHAR</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/6abdafcf4c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/index.js"></script>
    <script src="assets/js/valida_formUpdate.js"></script>
</body>
</html>