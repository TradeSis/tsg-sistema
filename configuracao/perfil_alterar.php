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
                    <button type="button" class="btn btn-sm btn-success mb-1" id="modalBtn"><i class="bi bi-plus-square"></i></button>

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
                                <!-- Operacoes checkboxes will be dynamically added here -->
                            </div>
                        </div>
                    </div> <!-- Close modal-body -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--------- ADICIONAR APLICATIVOS --------->
    <div class="modal" id="inserirappmodal" tabindex="-1" aria-labelledby="inserirappmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Aplicativos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="inserirappForm">
                        <div class="row">
                            <div class="row">
                                <div class="col"><label>Aplicativos:</label></div>
                                <div class="col"><input type="checkbox" id="checarTodos"
                                        class="form-check-input"> <label for="checarTodos">Marcar tudo</label>
                                </div>
                            </div>
                            <div class="row mt-2" id="aplicativosContainer">
                            </div>
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
        var apiEntradaList = []; 
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
        var checkedAplicativos = [];

        function buscaMenus() {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/perfil.php?operacao=buscarPerfilMenuAlterar',
                data: {
                    idPerfil: '<?php echo $perfil['idPerfil']; ?>'
                },
                success: function (response) {
                    var perfil = response.perfil[0];
                    var aplicativos = perfil.aplicativos;
                    
                    aplicativos.forEach(function (aplicativo) {
                        checkedAplicativos.push(aplicativo.idAplicativo);
                        var aplicativoNome = aplicativo.nomeAplicativo;
                        var aplicativoID = aplicativo.idAplicativo;
                        var htmldiv = "#dados" + aplicativoNome;
                        var html = "";
                        var count = 0;

                        if (tabs[aplicativoNome]) {
                            var tabId = tabs[aplicativoNome];
                            
                            $('#' + tabId).removeAttr('hidden');  
                        } 

                        html += '<div class="row">';
                        html += '<div class="col">';
                        html += '<div class="row">';
                        html += '<div class="col"><label>Aplicativos:</label></div>';
                        html += '</div>';

                        if (aplicativo.menus && Array.isArray(aplicativo.menus) && aplicativo.menus.length > 0) {
                            var mainmenus = aplicativo.menus.filter(menu => menu.idMenuSuperior === "");
                            var submenus = aplicativo.menus.filter(menu => menu.idMenuSuperior !== "");

                            if (mainmenus.length === 0 && submenus.length === 0) {
                                html += 'Sem Menus cadastrados';
                            } else {
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
                        } else {
                            html += 'Sem Menus cadastrados';
                        }

                        html += '</div>';
                        html += '</div>';
                        html += '</div>';

                        $(htmldiv).html(html);

                        if (aplicativo.menus && Array.isArray(aplicativo.menus)) {
                            aplicativo.menus.forEach(function (menu) {
                                var menuID = menu.idMenu.replace(/\s+/g, '_');
                                var menuSelector = 'input.menu-checkbox-' + aplicativoNome + '[value="' + menu.idMenu + '"]';
                                if (menu.perfilmenu && menu.perfilmenu.length > 0) {
                                    $(menuSelector).prop('checked', true);
                                    $('#operacoes-menu-' + aplicativoNome + '-' + menuID).removeAttr('hidden');
                                    menu.perfilmenu.forEach(function (perfilmenu) {
                                        apiEntradaList.push({
                                            idPerfil: perfilmenu.idPerfil,
                                            idAplicativo: perfilmenu.idAplicativo,
                                            idMenu: perfilmenu.idMenu,
                                            operacoes: perfilmenu.operacoes
                                        });
                                    });
                                }
                            });
                        }

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
                            var aplicativos = response.perfil[0].aplicativos;

                            var aplicativo = aplicativos.find(app => app.idAplicativo == idAplicativo);
                            var menu = aplicativo.menus.find(menu => menu.idMenu == idMenu);

                            $('#operacoesCheckboxContainer').empty();
                            $('#operacoesmodal input[type="checkbox"]').prop('checked', false);
                            $('#operacoesmodal .modal-title').text('Operações ' + idMenu);

                            var operacoesArray = menu.menuOp.split(',');
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

                            var perfilMenu;
                            if (menu.perfilmenu && Array.isArray(menu.perfilmenu)) {
                                perfilMenu = menu.perfilmenu.find(perfil => perfil.idPerfil == '<?php echo $perfil['idPerfil'] ?>');
                            }

                            if (perfilMenu && perfilMenu.operacoes) {
                                var checkedOperacoes = perfilMenu.operacoes.split(',');
                                checkedOperacoes.forEach(function (operacao) {
                                    var selector = '#operacoesmodal input[type="checkbox"][value="' + operacao.trim() + '"]';
                                    $(selector).prop('checked', true);
                                });
                            }
                            $('#operacoesmodal').modal('show');
                        });
                    });
                }
            });
        }

        buscaMenus();

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
        });

        $('#perfilForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../database/perfil.php?operacao=inserirPerfilMenu',
                data: {
                    apiEntrada: apiEntradaList
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        });

        $('#inserirappForm').submit(function (e) {
            e.preventDefault();
            var aplicativos = [];
            $('.menu-checkbox:checked').each(function () { aplicativos.push($(this).next('label').text().trim()); });
            var apiEntrada = {
                idPerfil: '<?php echo $perfil['idPerfil']; ?>',
                aplicativos: aplicativos.join(',')
            };
            $.ajax({
                type: 'POST',
                url: "../database/perfil.php?operacao=alterar",
                data: apiEntrada, 
                success: function (msg) {
                    window.location.reload();
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

        $('#modalBtn').on('click', function () {
            $('body').css('cursor', 'wait');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/aplicativo.php?operacao=buscar',
                data: {
                    idAplicativo: null
                },
                success: function (data) {
                    var apphtml = '';
                    var counter = 0;
                    data.forEach(function (aplicativo) {
                        if (counter % 3 === 0) {
                            if (counter > 0) { apphtml += '</div>'; }
                            apphtml += '<div class="row mt-2">';
                        }
                        var isChecked = checkedAplicativos.includes(aplicativo.idAplicativo) ? 'checked' : '';
                        apphtml += `
                            <div class="col-md-4">
                                <input class="form-check-input menu-checkbox" type="checkbox" value="${aplicativo.idAplicativo}" ${isChecked}>
                                <label>&nbsp;${aplicativo.nomeAplicativo}</label>
                            </div>`;
                        counter++;
                    });

                    if (counter % 3 !== 0) {
                        apphtml += '</div>';
                    }
                    $('#aplicativosContainer').html(apphtml);
                    $('#inserirappmodal').modal('show');
                    $('body').css('cursor', 'default');
                }
            });
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