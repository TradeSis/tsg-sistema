<?php
// Lucas 06102023 padrao novo
// Lucas 29032023 - alterado link do botão voltar, para redirecionar para o index.php
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../header.php');
include_once('../database/login.php');
include_once('../database/aplicativo.php');
include_once('../database/loginAplicativo.php');

$idLogin = $_GET['idLogin'];
$aplicativos = buscaAplicativos();
$usuario = buscaLogins($idLogin);
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
                <h2 class="ts-tituloPrincipal">Alterar Usuário</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>


        <form action="../database/login.php?operacao=alterar" method="post">
            <div class="row mt-3">
                <div class="col-sm">
                    <label class="form-label ts-label">Nome</label>
                    <input type="text" class="form-control ts-input" name="loginNome" value="<?php echo $usuario['loginNome'] ?>" readonly>
                    <input type="hidden" class="form-control ts-input" name="idLogin" value="<?php echo $usuario['idLogin'] ?>">
                </div>
                <div class="col-sm">
                    <label class="form-label ts-label">E-mail</label>
                    <input type="text" class="form-control ts-input" name="email" value="<?php echo $usuario['email'] ?>">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm">
                    <label class="form-label ts-label">Cpf/Cnpj</label>
                    <input type="text" class="form-control ts-input" name="cpfCnpj" value="<?php echo $usuario['cpfCnpj'] ?>">
                </div>
                <div class="col-sm">
                    <label class="form-label ts-label">Pede Token</label>
                    <select class="form-select ts-input" name="pedeToken">
                        <option <?php if ($usuario['pedeToken'] == "1") {
                                    echo "selected";
                                } ?> value="1">Sim</option>
                        <option <?php if ($usuario['pedeToken'] == "0") {
                                    echo "selected";
                                } ?> value="0">Não</option>
                    </select>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>
        <button type="button" data-bs-toggle="modal" data-bs-target="#alterarSenhaModal" class="btn btn-sm btn-danger mb-3">Alterar Senha</button>

       

    </div>

    <div class="container-fluid mt-3">
            <div id="ts-tabs">
                <div class="tab whiteborder" id="tab-nfe">Aplicativo</div>
                <div class="tab" id="tab-empresa">Empresas</div>
                <div class="tab" id="tab-estab" hidden></div>
                
                <div class="line"></div>

                <div class="tabContent">
                    <div class="table mt-2 ts-divTabela">
                        <table class="table table-sm table-hover">
                            <thead class="ts-headertabelafixo">
                                <tr class="ts-headerTabelaLinhaCima">
                                    <th>Usuário</th>
                                    <th>Aplicativo</th>
                                    <th>Nível</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>

                            <tbody id='dadosAplicativo' class="fonteCorpo">

                            </tbody> 
                        </table>
                        <div class="py-3 px-3 text-end">
                            <a href="loginAplicativo_inserir.php?idLogin=<?php echo $idLogin ?>" role="button" class="btn btn-success"><i class="bi bi-plus-square"></i>&nbsp
                                Novo</a>
                        </div>
                    </div>
                </div>
                
                <div class="tabContent">
                    <div class="table mt-2 ts-divTabela">
                    <table class="table table-sm table-hover">
                        <thead class="ts-headertabelafixo">
                            <tr class="ts-headerTabelaLinhaCima">
                                <th>Usuário</th>
                                <th>ID</th>
                                <th>Empresa</th>
                                <th>Ação</th>
                            </tr>
                        </thead>

                        <tbody id='dadosEmpresa' class="fonteCorpo">

                        </tbody> 
                    </table>
                        <div class="py-3 px-3 text-end">
                            <a href="loginEmpresa_inserir.php?idLogin=<?php echo $idLogin ?>" role="button" class="btn btn-success"><i class="bi bi-plus-square"></i>&nbsp
                                Novo</a>
                        </div>
                    </div>
                </div>
                  
                <div class="tabContent">
                    <div class="table mt-2 ts-divTabela">
                        <table class="table table-sm table-hover">
                            <thead class="ts-headertabelafixo">
                                <tr class="ts-headerTabelaLinhaCima">
                                    <th>Usuário</th>
                                    <th>etbcod</th>
                                    <th colspan="2">Ação</th>
                                </tr>
                            </thead>

                            <tbody id='dadosEstab' class="fonteCorpo">

                            </tbody> 
                        </table>
                        <div class="py-3 px-3 text-end">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#zoomEstabModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

         <!--------- EXCLUIR --------->
        <div class="modal" id="excluirmodal" tabindex="-1" aria-labelledby="excluirmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Excluir Estabalecimento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="excluirForm">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label class="form-label ts-label">Usuário</label>
                                            <input type="text" class="form-control ts-input" name="loginNome" id="EXCloginNome" readonly>
                                            <input type="hidden" class="form-control ts-input" name="idLogin" id="EXCidLogin">
                                            <input type="hidden" class="form-control ts-input" name="idEmpresa" id="EXCidEmpresa">
                                        </div>
                                        <div class="col">
                                            <label class="form-label ts-label">etbcod</label>
                                            <input type="text" class="form-control ts-input" name="etbcod" id="EXCetbcod" readonly>
                                        </div>
                                    </div><!--fim row 1-->
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Excluir</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    
    <!-- LOCAL PARA COLOCAR OS JS -->
    
    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <?php include 'modalAlterarSenha.php'; ?>
    <?php include 'zoomEstab.php'; ?>
    <script>
        var vidEmpresa;
        var vnomeEmpresa;

        window.onload = function () {
            tabContent = document.getElementsByClassName('tabContent');
            tab = document.getElementsByClassName('tab');
            hideTabsContent(1);

            var urlParams = new URLSearchParams(window.location.search);
            var id = urlParams.get('id');
            if (id === 'empresa') {
                showTabsContent(1); 
            } else if (id === 'estab') {
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

        $(document).on('click', '.ts-click', function () {
            var etbcod = $(this).attr("data-etbcod");
            var idLogin = <?php echo $idLogin ?>;
            $.ajax({
                url: "../database/loginEstab.php?operacao=inserir",
                type: 'POST',
                data: {
                    etbcod: etbcod,
                    idEmpresa: vidEmpresa,
                    idLogin: idLogin
                },
                success: function (msg) {
                    buscaLoginEstab(idLogin, vidEmpresa, vnomeEmpresa);
                    $('#zoomEstabModal').modal('hide');
                }
            });
        });

        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '../database/loginAplicativo.php?operacao=buscaLoginAplicativo',
            beforeSend: function() {
                $("#dadosAplicativo").html("Carregando...");
            },
            data: {
                idLogin : <?php echo $idLogin ?>
            },
            success: function(msg) {
                //alert("segundo alert: " + msg);
                var json = JSON.parse(msg);

                var linha = "";
                for (var $i = 0; $i < json.length; $i++) {
                    var object = json[$i];

                    linha = linha + "<tr>";

                    linha = linha + "<td>" + object.loginNome + "</td>";
                    linha = linha + "<td>" + object.nomeAplicativo + "</td>";
                    linha = linha + "<td>" + object.nivelMenu + "</td>";
                    linha += "<td><a class='btn btn-warning btn-sm' href='loginAplicativo_alterar.php?idLogin=" + <?php echo $idLogin ?> + "&idAplicativo=" + object.idAplicativo + "&nomeAplicativo=" + object.nomeAplicativo + "' role='button'><i class='bi bi-pencil-square'></i></a></td> ";


                    linha = linha + "</tr>";
                }
                $("#dadosAplicativo").html(linha);
            }
        });

        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: '../database/login.php?operacao=buscaLoginEmpresa',
            beforeSend: function() {
                $("#dadosEmpresa").html("Carregando...");
            },
            data: {
                idLogin : <?php echo $idLogin ?>
            },
            success: function(msg) {
                //alert("segundo alert: " + msg);
                var json = JSON.parse(msg);

                var linha = "";
                for (var $i = 0; $i < json.length; $i++) {
                    var object = json[$i];

                    linha = linha + "<tr>";

                    linha = linha + "<td>" + object.loginNome + "</td>";
                    linha = linha + "<td>" + object.idEmpresa + "</td>";
                    linha = linha + "<td>" + object.nomeEmpresa + "</td>";
                    if (object.etbcodPadrao !== 0) {
                        linha = linha + "<td><a class='btn btn-warning btn-sm' role='button' data-idEmpresa='" + object.idEmpresa + "' data-nomeEmpresa='" + object.nomeEmpresa + "'><i class='bi bi-pencil-square'></i></a></td>";
                    }

                    linha = linha + "</tr>";
                }
                $("#dadosEmpresa").html(linha);
            }
        });

        $(document).on('click', 'a[data-nomeEmpresa]', function() {
            var idEmpresa = $(this).attr("data-idEmpresa");
            var nomeEmpresa = $(this).attr("data-nomeEmpresa");
            vidEmpresa = idEmpresa;
            vnomeEmpresa = nomeEmpresa;
            buscaLoginEstab(<?php echo $idLogin ?>, idEmpresa, vnomeEmpresa);
        });

        function buscaLoginEstab(idLogin, idEmpresa, nomeEmpresa) {
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/loginEstab.php?operacao=buscar',
                beforeSend: function() {
                    $("#dadosEstab").html("Carregando...");
                },
                data: {
                    idLogin: idLogin,
                    idEmpresa: idEmpresa
                },
                success: function(msg) {
                    var json = JSON.parse(msg);
                    var linha = "";

                    if (json.status === 400) {
                        $("#dadosEstab").html("Sem estabelecimento, utilizando padrao da empresa");
                    } else {
                        for (var i = 0; i < json.length; i++) {
                            var object = json[i];

                            linha = linha + "<tr>";
                            linha = linha + "<td>" + object.loginNome + "</td>";
                            linha = linha + "<td>" + object.etbcod + "</td>";
                            linha = linha + "<td><a class='btn btn-warning btn-sm' href='loginEstab_alterar.php?idLogin=" + idLogin + "&etbcod=" + object.etbcod + "&idEmpresa=" + idEmpresa + "' role='button'><i class='bi bi-pencil-square'></i></a>";
                            linha = linha + "&nbsp;";
                            linha = linha + "<a class='btn btn-danger btn-sm' data-bs-target='#excluirmodal' data-idLogin='" + idLogin + "' data-etbcod='" + object.etbcod + "' data-idEmpresa='" + idEmpresa + "' role='button'><i class='bi bi-trash3'></i></a></td>";
                            linha = linha + "</tr>";
                        }
                        $("#dadosEstab").html(linha);
                    }
                    document.getElementById('tab-estab').removeAttribute('hidden');
                    document.getElementById('tab-estab').textContent = nomeEmpresa + " Estabelecimentos";
                    showTabsContent(2); 
                }
            });
        }

        $(document).on('click', "a[data-bs-target='#excluirmodal']", function () {
            var idLogin = $(this).attr("data-idLogin");
            var etbcod = $(this).attr("data-etbcod");
            var idEmpresa = $(this).attr("data-idEmpresa");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/loginEstab.php?operacao=buscar',
                data: {
                    idLogin: idLogin,
                    etbcod: etbcod,
                    idEmpresa: idEmpresa
                },
                success: function (msg) {
                    var data = msg[0];
                    $('#EXCidLogin').val(data.idLogin);
                    $('#EXCloginNome').val(data.loginNome);
                    $('#EXCetbcod').val(data.etbcod);
                    $('#EXCidEmpresa').val(data.idEmpresa);
                    $('#excluirmodal').modal('show');
                }
            });
        });

        $("#excluirForm").submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/loginEstab.php?operacao=excluir",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    buscaLoginEstab(<?php echo $idLogin ?>, vidEmpresa, vnomeEmpresa);
                    $('#excluirmodal').modal('hide');
                }
            });
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>