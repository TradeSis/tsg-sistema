<?php
//Lucas 04042023 criado
include_once('../header.php');
include_once('../database/aplicativo.php');
$aplicativo = buscaAplicativos($_GET['idAplicativo']);
$menus = buscaMenus($aplicativo['nomeAplicativo']);
//echo json_encode($aplicativo);
?>
<!doctype html>
<html lang="pt-BR">
<head>
    
    <?php include_once ROOT. "/vendor/head_css.php";?>

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
                <h2 class="ts-tituloPrincipal">Alterar Aplicativo</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="/sistema/configuracao/aplicativo.php" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/aplicativo.php?operacao=alterar" method="post" enctype="multipart/form-data">

            <div class="row mt-3">
                <div class="col-sm">
                    <label class='form-label ts-label'>Nome do
                            Aplicativo</label>
                        <input type="text" name="nomeAplicativo" class="form-control ts-input"
                            value="<?php echo $aplicativo['nomeAplicativo'] ?>">
                        <input type="hidden" class="form-control ts-input" name="idAplicativo"
                            value="<?php echo $aplicativo['idAplicativo'] ?> ">
                </div>
                <div class="col-sm">
                    <label class='form-label ts-label'>Caminho</label>
                    <input type="text" name="appLink" class="form-control ts-input"
                        value="<?php echo $aplicativo['appLink'] ?>">
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Alterar</button>
            </div>
        </form>

    </div>

    <div class="container-fluid mt-3">
            <div id="ts-tabs">
                <div class="tab whiteborder" id="tab-menu">Menus</div>
                
                <div class="line"></div>

                <div class="tabContent">
                    <div class="table mt-2 ts-divTabela">
                        <table class="table table-sm table-hover">
                            <thead class="ts-headertabelafixo">
                                <tr class="ts-headerTabelaLinhaCima">
                                    <th>Aplicativo</th>
                                    <th>Menu</th>
                                    <th>Superior</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>

                            <tbody id='dadosMenu' class="fonteCorpo">

                            </tbody> 
                        </table>
                        <div class="py-3 px-3 text-end">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#inserirmodal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!--------- INSERIR --------->
        <div class="modal" id="inserirmodal" tabindex="-1" aria-labelledby="inserirmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Inserir Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="inserirForm">
                            <div class="row">
                                <div class="col-md">
                                    <label class="form-label ts-label">Nome Menu</label>
                                    <input type="text" class="form-control ts-input" name="nomeMenu">
                                    <input type="hidden" class="form-control ts-input" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?>">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Menu Superior</label>
                                    <select class="form-select ts-input" name="idMenuSuperior">
                                        <option value="<?php echo null ?>">Nenhum</option>
                                        <?php foreach ($menus as $menu) { ?>
                                            <option value="<?php echo $menu['idMenu']; ?>">
                                                <?php echo $menu['nomeMenu']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal" id="alterarmodal" tabindex="-1" aria-labelledby="alterarmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="alterarForm">
                            <div class="row">
                                <div class="col-md">
                                    <label class="form-label ts-label">Nome Menu</label>
                                    <input type="text" class="form-control ts-input" name="nomeMenu" id="nomeMenu">
                                    <input type="hidden" class="form-control ts-input" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?>">
                                    <input type="hidden" class="form-control ts-input" name="idMenu" id="idMenu">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Menu Superior</label>
                                    <select class="form-select ts-input" name="idMenuSuperior" id="idMenuSuperior">
                                        <option value="<?php echo null ?>">Nenhum</option>
                                        <?php foreach ($menus as $menu) { ?>
                                            <option value="<?php echo $menu['idMenu']; ?>">
                                                <?php echo $menu['nomeMenu']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
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

    <?php include_once ROOT. "/vendor/footer_js.php";?>

    <script>
        buscaMenu();

        function buscaMenu() {
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '../database/aplicativo.php?operacao=buscarMenu',
                beforeSend: function() {
                    $("#dadosMenu").html("Carregando...");
                },
                data: {
                    nomeAplicativo: '<?php echo $aplicativo['nomeAplicativo'] ?>'
                },
                success: function(msg) {
                    var json = JSON.parse(msg);
                    var linha = "";

                    if (json.status === 400) {
                        $("#dadosMenu").html("Sem Menus cadastrados");
                    } else {
                        for (var i = 0; i < json.length; i++) {
                            var object = json[i];

                            linha = linha + "<tr>";
                            linha = linha + "<td><?php echo $aplicativo['nomeAplicativo'] ?></td>";
                            linha = linha + "<td>" + object.nomeMenu + "</td>";
                            linha = linha + "<td>" + object.nomeMenuSuperior + "</td>";
                            linha = linha + "<td><a class='btn btn-warning btn-sm' data-bs-target='#alterarmodal'  data-idMenu='" + object.idMenu + "' role='button'><i class='bi bi-pencil-square'></i></a></td>";
                            linha = linha + "</tr>";
                        }
                        $("#dadosMenu").html(linha);
                    }
                }
            });
        }

        $(document).on('click', "a[data-bs-target='#alterarmodal']", function () {
            var idMenu = $(this).attr("data-idMenu");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/aplicativo.php?operacao=buscarMenu',
                data: {
                    nomeAplicativo: '<?php echo $aplicativo['nomeAplicativo'] ?>',
                    idMenu: idMenu
                },
                success: function (msg) {
                    $('#idMenu').val(msg.idMenu);
                    $('#nomeMenu').val(msg.nomeMenu);
                    $('#idMenuSuperior').val(msg.idMenuSuperior);
                    $('#alterarmodal').modal('show');
                }
            });
        });

        $("#inserirForm").submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/aplicativo.php?operacao=inserirMenu",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    buscaMenu();
                    $('#inserirmodal').modal('hide');
                    $("input[name='nomeMenu']").val("");
                }
            });
        });
        $("#alterarForm").submit(function (event) {
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "../database/aplicativo.php?operacao=alterarMenu",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    buscaMenu();
                    $('#alterarmodal').modal('hide');
                }
            });
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>