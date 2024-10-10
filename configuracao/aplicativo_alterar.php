<?php
//Lucas 04042023 criado
include_once('../header.php');
include_once('../database/aplicativo.php');
$aplicativo = buscaAplicativos($_GET['idAplicativo']);
$menus = buscaMenus($_GET['idAplicativo']);
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
                <a href="aplicativo.php" role="button" class="btn btn-primary"><i
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
                            value="<?php echo $aplicativo['idAplicativo'] ?>">
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
                                    <input type="text" class="form-control ts-input" name="idMenu">
                                    <input type="hidden" class="form-control ts-input" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?>">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Menu Superior</label>
                                    <select class="form-select ts-input" name="idMenuSuperior">
                                        <option value="<?php echo null ?>">Nenhum</option>
                                        <?php if (isset($menus[0]['idMenu'])) { 
                                        foreach ($menus as $menu) { ?>
                                            <option value="<?php echo $menu['idMenu']; ?>">
                                                <?php echo $menu['idMenu']; ?>
                                            </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">Tab</label>
                                    <input type="text" class="form-control ts-input" name="tabMenu">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Caminho</label>
                                    <input type="text" class="form-control ts-input" name="srcMenu">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Titulo</label>
                                    <input type="text" class="form-control ts-input" name="titleMenu">
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
                                    <input type="text" class="form-control ts-input" name="idMenu" id="idMenu">
                                    <input type="hidden" class="form-control ts-input" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?>">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Menu Superior</label>
                                    <select class="form-select ts-input" name="idMenuSuperior" id="idMenuSuperior">
                                        <option value="<?php echo null ?>">Nenhum</option>
                                        <?php if (isset($menus[0]['idMenu'])) { 
                                        foreach ($menus as $menu) { ?>
                                            <option value="<?php echo $menu['idMenu']; ?>">
                                                <?php echo $menu['idMenu']; ?>
                                            </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">Tab</label>
                                    <input type="text" class="form-control ts-input" name="tabMenu" id="tabMenu">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Caminho</label>
                                    <input type="text" class="form-control ts-input" name="srcMenu" id="srcMenu">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Titulo</label>
                                    <input type="text" class="form-control ts-input" name="titleMenu" id="titleMenu">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md">
                                    <label class="form-label ts-label">Adicionar Operacoes</label>
                                    <input type="text" class="form-control ts-input" name="addOP" id="addOP">
                                </div>
                                <div class="col-md">
                                    <div class="form-group col">
                                        <label>Selecione Operações</label>
                                        <select class="form-control" name="operacoes[]" id="operacoes" multiple style="height: 90px; overflow-y: hidden;">
                                        </select>
                                    </div>
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
                    idAplicativo: '<?php echo $aplicativo['idAplicativo'] ?>'
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
                            linha = linha + "<td>" + object.nomeAplicativo + "</td>";
                            linha = linha + "<td>" + object.idMenu + "</td>";
                            linha = linha + "<td>" + object.idMenuSuperior + "</td>";
                            linha = linha + "<td><a class='btn btn-warning btn-sm' data-bs-target='#alterarmodal'  data-idMenu='" + object.idMenu + "' role='button'><i class='bi bi-pencil-square'></i></a></td>";
                            linha = linha + "</tr>";
                        }
                        $("#dadosMenu").html(linha);
                    }
                }
            });
        }

        $(document).ready(function() {
            $('#addOP').on('keypress', function(e) {
                if (e.which == 13) {  
                    e.preventDefault();
                    var newOp = $(this).val().trim();
                    if (newOp) {
                        $('#operacoes').append('<option value="' + newOp + '" selected>' + newOp + '</option>');
                        $(this).val('');  
                    }
                }
            });

            window.onmousedown = function(e) {
                var el = e.target;
                if (el.tagName.toLowerCase() == 'option' && el.parentNode.hasAttribute('multiple')) {
                    e.preventDefault();

                    if (el.hasAttribute('selected')) el.removeAttribute('selected');
                    else el.setAttribute('selected', '');

                    var select = el.parentNode.cloneNode(true);
                    el.parentNode.parentNode.replaceChild(select, el.parentNode);
                }
            };

            $(document).on('click', "a[data-bs-target='#alterarmodal']", function () {
                var idMenu = $(this).attr("data-idMenu");
                $('#operacoes').empty();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '../database/aplicativo.php?operacao=buscarMenu',
                    data: {
                        idAplicativo: '<?php echo $aplicativo["idAplicativo"] ?>',
                        idMenu: idMenu
                    },
                    success: function (msg) {
                        $('#idMenu').val(msg.idMenu);
                        $('#idMenuSuperior').val(msg.idMenuSuperior);
                        $('#menuOp').val(msg.menuOp);
                        $('#tabMenu').val(msg.tabMenu);
                        $('#srcMenu').val(msg.srcMenu);
                        $('#titleMenu').val(msg.titleMenu);

                        if (msg.menuOp) {
                            var ops = msg.menuOp.split(',');  
                            ops.forEach(function(op) {
                                op = op.trim(); 
                                if (op && !$('#operacoes option[value="' + op + '"]').length) {
                                    $('#operacoes').append('<option value="' + op + '" selected>' + op + '</option>');
                                }
                            });
                        }
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
                        $("input[name='idMenu']").val("");
                    }
                });
            });
            $("#alterarForm").submit(function (event) {
                event.preventDefault();
                var formData = new FormData(this);
                var selectedOperacoes = $('#operacoes option:selected').map(function() {
                    return this.value;
                }).get().join(',');

                formData.set('operacoes', selectedOperacoes);
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
        });
        

       
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>