<?php
// lucas 11102023 novo padrao
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/aplicativo.php');
include_once(ROOT . '/cadastros/database/clientes.php');

$clientes = buscaClientes();
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">

        <div class="row ">
            <!-- <BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!--<BR><BR><BR>  BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-2 col-lg-1 order-lg-1">
                <button class="btn btn-outline-secondary ts-btnFiltros" type="button"><i class="bi bi-funnel"></i></button>
            </div>

            <div class="col-4 col-lg-3 order-lg-2">

                <h2 class="ts-tituloPrincipal">Aplicativo padrão</h2>
                <span>Filtro Aplicado</span>

            </div>
            <div class="col-6 col-lg-2 order-lg-3">
                <form class="text-end" action="" method="post">
                    <div class="input-group">
                        <select class="form-select ts-input" name="exemplo">
                            <option value="">exemplo1</option>
                            <option value="">exemplo2</option>
                            <option value="">exemplo3</option>
                        </select>
                        <button class="btn btn-warning" name="exemplo" type="submit">Botão</button>
                    </div>
                </form>
            </div>
            <div class="col-12 col-lg-6 order-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaContrato" placeholder="Buscar por id ou titulo">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <!-- MENUFILTROS -->
        <div class="ts-menuFiltros mt-2 px-3">
            <label>Filtrar por:</label>
            <div class="col-12">
                <select class="form-select" name="exemplo">
                    <option value="">exemplo1</option>
                    <option value="">exemplo2</option>
                    <option value="">exemplo3</option>
                </select>
            </div>

            <div class="col-sm text-end mt-2">
                <a onClick="limpar()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>ID</th>
                        <th>Aplicativo</th>
                        <th>Caminho</th>
                        <th>Imagem</th>
                        <th colspan="2">Ação</th>
                    </tr>
                    <tr class="ts-headerTabelaLinhaBaixo">
                        <th></th>
                        <th>
                            <form action="" method="post">
                                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idCliente" id="FiltroClientes">
                                    <option value="<?php echo null ?>">
                                        <?php echo "Selecione" ?>
                                    </option>
                                    <option value="">exemplo1</option>
                                    <option value="">exemplo2</option>
                                    <option value="">exemplo3</option>
                                </select>
                            </form>
                        </th>
                        <th></th>
                        <th>
                            <form action="" method="post">
                                <select class="form-select ts-input ts-selectFiltrosHeaderTabela" name="idCliente" id="FiltroClientes">
                                    <option value="<?php echo null ?>">
                                        <?php echo "Selecione" ?>
                                    </option>
                                    <option value="">exemplo1</option>
                                    <option value="">exemplo2</option>
                                    <option value="">exemplo3</option>
                                </select>
                            </form>
                        </th>
                        <th colspan="2"></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>


        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirModal" tabindex="-1" aria-labelledby="inserirModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Aplicativo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="inserirFormAplicativo">
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>Nome do Aplicativo</label>
                                    <input type="text" class="form-control ts-input" name="nomeAplicativo" autocomplete="off" required>
                                </div>
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>Caminho</label>
                                    <input type="text" class="form-control ts-input" name="appLink" autocomplete="off">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <label class="form-label ts-label">Imagem</label>
                                <label class="picture ml-4 mt-4" for="imgAplicativo" tabIndex="0">
                                    <span class="picture__image"></span>
                                </label>

                                <input type="file" name="imgAplicativo" id="imgAplicativo">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="alterarmodal" tabindex="-1" aria-labelledby="alterarmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Nota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="alterarFormAplicativo">
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>Nome do Aplicativo</label>
                                    <input type="text" class="form-control ts-input" name="nomeAplicativo" id="nomeAplicativo">
                                    <input type="hidden" class="form-control ts-input" name="idAplicativo" id="idAplicativo">
                                </div>
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>Caminho</label>
                                    <input type="text" class="form-control ts-input" name="appLink" id="appLink">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <label class="form-label ts-label">Imagem</label>
                                <label class="picture ml-4 mt-4" for="imgAplicativo" tabIndex="0">
                                    <span class="picture__image"></span>
                                </label>

                                <input type="file" name="imgAplicativo" id="imgAplicativo">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!--container-fluid-->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- script para menu de filtros -->
    <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>

    <script>
        buscar(null);

        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(buscaaplicativo) {
            //alert (buscaaplicativo);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/sistema/database/aplicativo.php?operacao=filtrar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    buscaaplicativo: buscaaplicativo
                },
                success: function(msg) {
                    //alert("segundo alert: " + msg);
                    var json = JSON.parse(msg);

                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];


                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.idAplicativo + "</td>";
                        linha = linha + "<td>" + object.nomeAplicativo + "</td>";
                        linha = linha + "<td>" + object.appLink + "</td>";
                        linha = linha + "<td>" + object.imgAplicativo + "</td>";

                        linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarmodal' data-idAplicativo='" + object.idAplicativo + "'><i class='bi bi-pencil-square'></i></button>"
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $("#buscar").click(function() {
            buscar($("#buscaaplicativo").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#buscaaplicativo").val());
            }
        });

        $(document).on('click', 'button[data-bs-target="#alterarmodal"]', function() {
            var idAplicativo = $(this).attr("data-idAplicativo");
            //alert(idAplicativo)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/sistema/database/aplicativo.php?operacao=buscar',
                data: {
                    idAplicativo: idAplicativo
                },
                success: function(data) {
                    $('#idAplicativo').val(data.idAplicativo);
                    $('#nomeAplicativo').val(data.nomeAplicativo);
                    $('#appLink').val(data.appLink);
                    $('#pathImg').val(data.pathImg);

                    /* alert(data) */
                    $('#alterarmodal').modal('show');
                }
            });
        });

        $(document).ready(function() {
            $("#inserirFormAplicativo").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/aplicativo.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#alterarFormAplicativo").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/aplicativo.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            function refreshPage() {
                window.location.reload();
            }
        });

        //Carregar a imagem na tela
        const inputFile = document.querySelector("#imgAplicativo");
        const pictureImage = document.querySelector(".picture__image");
        const pictureImageTxt = "Carregar imagem";
        pictureImage.innerHTML = pictureImageTxt;

        inputFile.addEventListener("change", function(e) {
            const inputTarget = e.target;
            const file = inputTarget.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener("load", function(e) {
                    const readerTarget = e.target;

                    const img = document.createElement("img");
                    img.src = readerTarget.result;
                    img.classList.add("picture__img");

                    pictureImage.innerHTML = "";
                    pictureImage.appendChild(img);
                });

                reader.readAsDataURL(file);
            } else {
                pictureImage.innerHTML = pictureImageTxt;
            }
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>