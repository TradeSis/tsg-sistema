<?php
//Lucas 04042023 criado
include_once('../header.php');
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
                <h2 class="ts-tituloPrincipal">Inserir Perfil</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="/sistema/configuracao/perfil.php" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/perfil.php?operacao=inserir" method="post" id="perfilForm">

            <div class="row mt-3">
                <div class="col-sm">
                    <label class='form-label ts-label'>Nome do Perfil</label>
                    <input type="text" name="nomePerfil" class="form-control ts-input" required>
                </div>
            </div>
            <div class="container-fluid mt-3">
                <div id="ts-tabs">
                    <div class="tab whiteborder" id="tab-sis">Sistema</div>
                    <div class="tab" id="tab-svc">Servicos</div>
                    <div class="tab" id="tab-cad">Cadastros</div>
                    <div class="tab" id="tab-imp">Impostos</div>
                    <div class="tab" id="tab-not">Notas</div>
                    <div class="tab" id="tab-fin">Financeiro</div>
                    <div class="tab" id="tab-adm">Admin</div>
                    <div class="tab" id="tab-ven">Vendas</div>
                    <div class="tab" id="tab-cre">Crediario</div>
                    <div class="tab" id="tab-rel">Relatorios</div>

                    <div class="line"></div>

                    <div class="tabContent"><div id='dadosSistema'></div></div>
                    <div class="tabContent"><div id='dadosServicos'></div></div>
                    <div class="tabContent"><div id='dadosCadastros'></div></div>
                    <div class="tabContent"><div id='dadosImpostos'></div></div>
                    <div class="tabContent"><div id='dadosNotas'></div></div>
                    <div class="tabContent"><div id='dadosFinanceiro'></div></div>
                    <div class="tabContent"><div id='dadosAdmin'></div></div>
                    <div class="tabContent"><div id='dadosVendas'></div></div>
                    <div class="tabContent"><div id='dadosCrediario'></div></div>
                    <div class="tabContent"><div id='dadosRelatorios'></div></div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Inserir</button>
            </div>
        </form>

    </div>



    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>

$(document).ready(function () {
            var apps = ["Sistema", "Servicos", "Cadastros", "Impostos", "Notas", "Financeiro", "Admin", "Vendas", "Crediario", "Relatorios"];

            function loadAllTabsData() {
                apps.forEach(function (appNome) {
                    var targetDiv = "#dados" + appNome;
                    $.ajax({
                        type: 'POST',
                        dataType: 'html',
                        url: '../database/aplicativo.php?operacao=buscarMenu',
                        data: {
                            nomeAplicativo: appNome
                        },
                        success: function (msg) {
                            var json = JSON.parse(msg);
                            var html = "";
                            var count = 0;
                            html += '<div class="row">';
                            html += '<div class="col">';
                            html += '<div class="row">';
                            html += '<div class="col"><label>Aplicativos:</label></div>';
                            html += '<div class="col"><input type="checkbox" id="checarTodos' + appNome + '" class="form-check-input"> <label for="checarTodos' + appNome + '">Marcar tudo</label></div>';
                            html += '</div>';
                            if (json.status === 400) {
                                html += 'Sem Menus cadastrados';
                            } else {
                                for (var i = 0; i < json.length; i++) {
                                    var object = json[i];
                                    if (count % 3 == 0) {
                                        if (count > 0) { html += '</div>'; }
                                        html += '<div class="row mt-2">';
                                    }
                                    html += '<div class="col-md-4">';
                                    html += '<input class="form-check-input menu-checkbox-' + appNome + '" type="checkbox" name="menus[]" id="inlineCheckbox' + (appNome + '-' + (i + 1)) + '" value="' + appNome + '.' + object.nomeMenu + '">';
                                    html += '<label for="inlineCheckbox' + (appNome + '-' + (i + 1)) + '">' + object.nomeMenu + '</label>';
                                    html += '</div>';
                                    count++;
                                }
                                if (count > 0) { html += '</div>'; }
                            }
                            html += '</div>';
                            html += '<div class="col border-start">';
                            html += '<div><label>Operações:</label></div>';
                            html += '<div class="row mt-2">';
                            html += '<div class="col-md">';
                            html += '<input class="form-check-input" type="checkbox" name="operacoes' + appNome + '[]" value="INS">';
                            html += '<label>Inserir</label>';
                            html += '</div>';
                            html += '<div class="col-md">';
                            html += '<input class="form-check-input" type="checkbox" name="operacoes' + appNome + '[]" value="ALT">';
                            html += '<label>Alterar</label>';
                            html += '</div>';
                            html += '<div class="col-md">';
                            html += '<input class="form-check-input" type="checkbox" name="operacoes' + appNome + '[]" value="EXC">';
                            html += '<label>Excluir</label>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            $(targetDiv).html(html);
                            $('#checarTodos' + appNome).on('change', function () {
                                $('.menu-checkbox-' + appNome).prop('checked', $(this).is(':checked'));
                            });
                            $('.menu-checkbox-' + appNome).on('change', function () {
                                var checkTodos = $('.menu-checkbox-' + appNome).length === $('.menu-checkbox-' + appNome + ':checked').length;
                                $('#checarTodos' + appNome).prop('checked', checkTodos);
                            });
                        }
                    });
                });
            }

            loadAllTabsData();

            $('#perfilForm').submit(function (e) {
                e.preventDefault();
                var aplicativos = [];
                var menus = {};
                var pEXC = [];
                var pALT = [];
                var pINS = [];
                apps.forEach(function (appNome) {
                    var appCheck = false;
                    menus[appNome] = [];
                    $('input[name="menus[]"]').each(function () {
                        var value = $(this).val();
                        if (value.startsWith(appNome) && $(this).is(':checked')) {
                            menus[appNome].push(value.split('.')[1]); 
                            appCheck = true;
                        }
                    });
                    if (appCheck) {
                        aplicativos.push(appNome);
                    }
                    if ($('input[name="operacoes' + appNome + '[]"][value="EXC"]').is(':checked')) {
                        pEXC.push(appNome);
                    }
                    if ($('input[name="operacoes' + appNome + '[]"][value="ALT"]').is(':checked')) {
                        pALT.push(appNome);
                    }
                    if ($('input[name="operacoes' + appNome + '[]"][value="INS"]').is(':checked')) {
                        pINS.push(appNome);
                    }
                    if (menus[appNome].length === 0) {
                        delete menus[appNome];
                    } else {
                        menus[appNome] = menus[appNome].join(',');
                    }
                });
                var menuString = JSON.stringify(menus);
                var apiEntrada = {
                    nomePerfil: $('input[name="nomePerfil"]').val(),
                    aplicativos: aplicativos.join(','),
                    menus: menuString,
                    pEXC: pEXC.join(','),
                    pALT: pALT.join(','),
                    pINS: pINS.join(',')
                };
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: apiEntrada,
                    success: function (response) {
                        console.log(response);
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