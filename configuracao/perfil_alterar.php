<?php
//Lucas 04042023 criado
include_once('../header.php');
include_once('../database/perfil.php');
$perfil = buscaPerfil($_GET['idPerfil']);
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>

    <div class="container-fluid">


        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Alterar Perfil</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="../configuracao/perfil.php" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/perfil.php?operacao=alterar" method="post" id="perfilForm">

            <div class="row mt-3">
                <div class="col-sm">
                    <label class='form-label ts-label'>Nome do Perfil</label>
                    <input type="text" value="<?php echo $perfil['idPerfil'] ?>" name="idPerfil"
                        class="form-control ts-input" disabled>
                </div>
            </div>
            <div class="container-fluid mt-3">
                <div id="ts-tabs">
                    <div class="tab whiteborder" id="tab-sis" hidden>Sistema</div>
                    <div class="tab" id="tab-svc" hidden>Servicos</div>
                    <div class="tab" id="tab-cad" hidden>Cadastros</div>
                    <div class="tab" id="tab-imp" hidden>Impostos</div>
                    <div class="tab" id="tab-not" hidden>Notas</div>
                    <div class="tab" id="tab-fin" hidden>Financeiro</div>
                    <div class="tab" id="tab-adm" hidden>Admin</div>
                    <div class="tab" id="tab-ven" hidden>Vendas</div>
                    <div class="tab" id="tab-cre" hidden>Crediario</div>
                    <div class="tab" id="tab-rel" hidden>Relatorios</div>

                    <div class="line"></div>

                    <div class="tabContent">
                        <div id='dadosSistema'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosServicos'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosCadastros'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosImpostos'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosNotas'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosFinanceiro'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosAdmin'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosVendas'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosCrediario'></div>
                    </div>
                    <div class="tabContent">
                        <div id='dadosRelatorios'></div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>

    </div>


    <!--------- OPERACOES --------->
    <div class="modal" id="operacoesmodal" tabindex="-1" aria-labelledby="operacoesmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="operacoesForm">
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="row">
                                <div class="col"><label>Operacões:</label></div>
                                <div class="col">
                                    <input type="checkbox" id="checarTodos" class="form-check-input">
                                    <label for="checarTodos">Marcar tudo</label>
                                </div>
                            </div>
                            <div class="row mt-3 mb-3" id="operacoesCheckboxContainer">
                            </div>
                        </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>

        $(document).ready(function () {
            var aplicativos = [];
            var apiEntradaList = []; 

            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/aplicativo.php?operacao=buscar',
                data: {
                    idAplicativo: null
                },
                success: function (msg) {
                    var json = JSON.parse(msg);
                    var perfilAplicativos = "<?php echo $perfil['aplicativos'] ?>".split(',');
                    var tabs = {
                        "Sistema": "tab-sis",
                        "Servicos": "tab-svc",
                        "Cadastros": "tab-cad",
                        "Impostos": "tab-imp",
                        "Notas": "tab-not",
                        "Financeiro": "tab-fin",
                        "Admin": "tab-adm",
                        "Vendas": "tab-ven",
                        "Crediario": "tab-cre",
                        "Relatorios": "tab-rel"
                    };

                    json.forEach(function (aplicativo) {
                        var aplicativoNome = aplicativo.nomeAplicativo;
                        var aplicativoID = aplicativo.idAplicativo;

                        if (perfilAplicativos.includes(aplicativoNome)) {
                            aplicativos.push({ nome: aplicativoNome, id: aplicativoID });

                            if (tabs[aplicativoNome]) {
                                $("#" + tabs[aplicativoNome]).removeAttr('hidden');
                            }
                        }
                    });

                    var visibleApps = aplicativos.filter(function (aplicativo) {
                        return !$("#" + tabs[aplicativo.nome]).is(':hidden');
                    });

                    buscaMenus(visibleApps);
                }
            });

            function buscaMenus(visibleApps) {
                $('body').css('cursor', 'wait');
                visibleApps.forEach(function (aplicativo, index, array) {
                    var aplicativoNome = aplicativo.nome;
                    var aplicativoID = aplicativo.id;
                    var htmldiv = "#dados" + aplicativoNome;

                    $.ajax({
                        type: 'POST',
                        dataType: 'html',
                        url: '../database/aplicativo.php?operacao=buscarMenu',
                        beforeSend: function() {
                            $(htmldiv).html("Carregando...");
                        },
                        data: {
                            idAplicativo: aplicativoID,
                            idMenu: null
                        },
                        success: function (msg) {
                            var json = JSON.parse(msg);
                            var html = "";
                            var count = 0;

                            html += '<div class="row">';
                            html += '<div class="col">';
                            html += '<div class="row">';
                            html += '<div class="col"><label>Aplicativos:</label></div>';
                            html += '</div>';

                            if (json.status === 400) {
                                html += 'Sem Menus cadastrados';
                            } else {
                                var mainmenus = json.filter(menu => menu.idMenuSuperior === "");
                                var submenus = json.filter(menu => menu.idMenuSuperior !== "");

                                mainmenus.forEach(function (menu) {
                                    var menuID = menu.idMenu.replace(/\s+/g, '_'); 
                                    if (count % 4 == 0) {
                                        if (count > 0) { html += '</div>'; }
                                        html += '<div class="row mt-2">';
                                    }
                                    html += '<div class="col-md-3">';
                                    html += '<input class="form-check-input menu-checkbox-' + aplicativoNome + '" type="checkbox" name="menus[]" id="inlineCheckbox' + (aplicativoNome + '-' + (count + 1)) + '" value="' + menu.idMenu + '" data-appid="' + aplicativoID + '">';
                                    html += '<label for="inlineCheckbox' + (aplicativoNome + '-' + (count + 1)) + '">&nbsp;' + menu.idMenu + '&nbsp;&nbsp;</label>';
                                    html += '<a class="btn btn-primary btn-sm p-1" id="operacoes-menu-' + aplicativoNome + '-' + menuID + '" role="button" value="' + menu.idMenu + '" data-appid="' + aplicativoID + '" style="font-size: 0.5rem;" hidden><i class="bi bi-eye-fill"></i></a>';
                                    html += '</div>';
                                    count++;
                                });

                                submenus.forEach(function (submenu) {
                                    var submenuID = submenu.idMenu.replace(/\s+/g, '_');
                                    if (count % 4 == 0) {
                                        if (count > 0) { html += '</div>'; }
                                        html += '<div class="row mt-2">';
                                    }
                                    html += '<div class="col-md-3">';
                                    html += '<input class="form-check-input menu-checkbox-' + aplicativoNome + '" type="checkbox" name="menus[]" id="inlineCheckbox' + (aplicativoNome + '-' + (count + 1)) + '" value="' + submenu.idMenu + '" data-appid="' + aplicativoID + '">';
                                    html += '<label for="inlineCheckbox' + (aplicativoNome + '-' + (count + 1)) + '">&nbsp;' + submenu.idMenuSuperior + ' &gt; ' + submenu.idMenu + '&nbsp;&nbsp;</label>';
                                    html += '<a class="btn btn-primary btn-sm p-1" id="operacoes-menu-' + aplicativoNome + '-' + submenuID + '" role="button" value="' + submenu.idMenu + '" data-appid="' + aplicativoID + '" style="font-size: 0.5rem;" hidden><i class="bi bi-eye-fill"></i></a>';
                                    html += '</div>';
                                    count++;
                                });

                                if (count > 0) { html += '</div>'; }
                            }

                            html += '</div>';
                            html += '</div>';
                            html += '</div>';

                            $(htmldiv).html(html);

                            $.ajax({
                                type: 'POST',
                                dataType: 'json',
                                url: '../database/perfil.php?operacao=buscarPerfilMenu',
                                data: {
                                    idPerfil: '<?php echo $perfil['idPerfil']; ?>',
                                    idAplicativo: aplicativoID
                                },
                                success: function (msg) {
                                    if (msg.status !== 400) {
                                        var menusCadastrados = msg;
                                        menusCadastrados.forEach(function (menu) {
                                            var menuID = menu.idMenu.replace(/\s+/g, '_'); 
                                            var menuSelector = 'input.menu-checkbox-' + aplicativoNome + '[value="' + menu.idMenu + '"]';
                                            $(menuSelector).prop('checked', true);

                                            $('#operacoes-menu-' + aplicativoNome + '-' + menuID).removeAttr('hidden')

                                            apiEntradaList.push({
                                                idPerfil: menu.idPerfil,
                                                idAplicativo: menu.idAplicativo,
                                                idMenu: menu.idMenu,
                                                operacoes: menu.operacoes
                                            });
                                        });
                                    }
                                }
                            });

                            $('.menu-checkbox-' + aplicativoNome).on('change', function () {
                                var isChecked = $(this).is(':checked');
                                var idMenu = $(this).val();
                                var idAplicativo = $(this).data('appid');
                                var menuID = idMenu.replace(/\s+/g, '_'); 
                                if (isChecked) {
                                    $('#operacoes-menu-' + aplicativoNome + '-' + menuID).removeAttr('hidden');
                                    apiEntradaList.push({
                                        idPerfil: '<?php echo $perfil['idPerfil']; ?>',
                                        idAplicativo: idAplicativo,
                                        idMenu: idMenu,
                                        operacoes: '' 
                                    });
                                } else {
                                    $('#operacoes-menu-' + aplicativoNome + '-' + menuID).attr('hidden', true);
                                    apiEntradaList = apiEntradaList.filter(function (entry) {
                                        return !(entry.idMenu === idMenu && entry.idAplicativo === idAplicativo);
                                    });
                                }
                            });
                            $('[id^="operacoes-menu-' + aplicativoNome + '"]').on('click', function () {
                                var idMenu = $(this).attr('value');  
                                var idAplicativo = $(this).data('appid');
                                    $('body').css('cursor', 'wait');
                                    $('#operacoesCheckboxContainer').empty();
                                    $('#operacoesmodal input[type="checkbox"]').prop('checked', false);
                                    $('#operacoesmodal .modal-title').text('Operações ' + idMenu);
                                    $.ajax({
                                        type: 'POST',
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $("#operacoesCheckboxContainer").html("Carregando...");
                                        },
                                        url: '../database/aplicativo.php?operacao=buscarMenu',
                                        data: {
                                            idAplicativo: idAplicativo,
                                            idMenu: idMenu
                                        },
                                        success: function (msg) {
                                            var operacoesArray = msg.menuOp.split(',');
                                            var checkboxHtml = ''; 
                                            operacoesArray.forEach(function (operacao) {
                                                operacao = operacao.trim();
                                                if (operacao) {
                                                    checkboxHtml += `<div class="col-md-3">`;
                                                    checkboxHtml += `<input class="form-check-input operacao-checkbox" type="checkbox" value="${operacao}">`;
                                                    checkboxHtml += `<label>&nbsp;${operacao}</label>`;
                                                    checkboxHtml += `</div>`;
                                                }
                                            });
                                            $('#operacoesCheckboxContainer').html(checkboxHtml);
                                        },
                                    });
                                    $.ajax({
                                        type: 'POST',
                                        dataType: 'json',
                                        url: '../database/perfil.php?operacao=buscarPerfilMenu',
                                        data: {
                                            idPerfil: '<?php echo $perfil['idPerfil']; ?>',
                                            idAplicativo: idAplicativo,
                                            idMenu: idMenu
                                        },
                                        success: function (msg) {
                                            if (msg.operacoes) {
                                                var operacoesArray = msg.operacoes.split(',');
                                                operacoesArray.forEach(function (operacao) {
                                                    var selector = '#operacoesmodal input[type="checkbox"][value="' + operacao.trim() + '"]';
                                                    $(selector).prop('checked', true);
                                                });
                                            }
                                            $('body').css('cursor', 'default');
                                        },
                                        error: function () {
                                            $('body').css('cursor', 'default');
                                        }
                                    });
                                    $('#operacoesmodal').modal('show');
                                    
                            });
                        },
                        complete: function () {
                            if (index === array.length - 1) {
                                $('body').css('cursor', 'default');
                            }
                        }
                    });
                });
            }

            $('#operacoesForm').submit(function (e) {
                e.preventDefault();
                var idMenu = $('#operacoesmodal .modal-title').text().replace('Operações ', '');
                var operacoes = [];
                $('#operacoesmodal input[type="checkbox"]:checked').each(function () {
                    var val = $(this).val();
                    if (val && val !== "on") {
                        operacoes.push(val);
                    }
                });
                var existingEntry = apiEntradaList.find(function (entry) {
                    return entry.idMenu === idMenu;
                });
                if (existingEntry) {
                    existingEntry.operacoes = operacoes.join(',');
                } else {
                    apiEntradaList.push({
                        idPerfil: '<?php echo $perfil['idPerfil']; ?>',
                        idAplicativo: existingEntry.idAplicativo,
                        idMenu: idMenu,
                        operacoes: operacoes.join(',')
                    });
                }
                $('#operacoesmodal').modal('hide');
                console.log(apiEntradaList);
            });

            $('#perfilForm').submit(function (e) {
                e.preventDefault(); 
                $.ajax({
                    type: 'POST',
                    url: '../database/perfil.php?operacao=inserirPerfilMenu',
                    data: {
                        apiEntrada : apiEntradaList
                    },
                    success: function (response) {
                        window.location.href = '../configuracao/perfil.php';
                    }
                });
            });

            $('#checarTodos').on('change', function () {
                $('.operacao-checkbox').prop('checked', $(this).is(':checked'));
            });
            $('.operacao-checkbox').on('change', function () {
                var allChecked = $('.operacao-checkbox').length === $('.operacao-checkbox:checked').length;
                $('#checarTodos').prop('checked', allChecked);
            });
        });


        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'sis') {
                showTabsContent(0);
            }
            if (id === 'svc') {
                showTabsContent(1);
            }
            if (id === 'cad') {
                showTabsContent(2);
            }
            if (id === 'imp') {
                showTabsContent(2);
            }
            if (id === 'not') {
                showTabsContent(2);
            }
            if (id === 'fin') {
                showTabsContent(2);
            }
            if (id === 'adm') {
                showTabsContent(2);
            }
            if (id === 'ven') {
                showTabsContent(2);
            }
            if (id === 'cre') {
                showTabsContent(2);
            }
            if (id === 'rel') {
                showTabsContent(2);
            } else {
                showTabsContent(0);
            }
        }

        document.getElementById('ts-tabs').onclick = function (event) {
            var target = event.target;
            if (target.className.includes('tab')) {
                for (var i = 0; i < tab.length; i++) {
                    if (target == tab[i]) {
                        showTabsContent(i);
                        break;
                    }
                }
            }
        }

        function hideTabsContent(startIndex) {
            for (var i = startIndex; i < tabContent.length; i++) {
                tabContent[i].classList.remove('show');
                tabContent[i].classList.add("hide");
                tab[i].classList.remove('whiteborder');
            }
        }

        function showTabsContent(index) {
            if (tabContent[index].classList.contains('hide')) {
                hideTabsContent(0);
                tab[index].classList.add('whiteborder');
                tabContent[index].classList.remove('hide');
                tabContent[index].classList.add('show');
            }
        }
    </script>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>