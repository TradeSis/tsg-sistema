<?php
//Lucas 29022024 - id862 Empresa Administradora
// Lucas 06102023 padrao novo
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../header.php');
include_once('../database/empresa.php');
include_once(ROOT . '/cadastros/database/pessoas.php');
$empresa = buscaEmpresas($_GET['idEmpresa']);
$pessoas = buscarPessoa();
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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
                <h2 class="ts-tituloPrincipal">Alterar Empresa</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="/sistema/configuracao/empresa.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/empresa.php?operacao=alterar" method="post">
            <div class="row mt-3">
                <div class="col-md-8">
                    <label class='form-label ts-label'></label>
                    <input type="text" class="form-control ts-input" name="nomeEmpresa" value="<?php echo $empresa['nomeEmpresa'] ?>">
                    <input type="hidden" class="form-control ts-input" name="idEmpresa" value="<?php echo $empresa['idEmpresa'] ?>">
                </div>
                <div class="col-md-2">
                    <label class='form-label ts-label'>Tempo Sessão</label>
                    <input type="number" min="1" value="<?php echo $empresa['timeSessao'] ?>" class="form-control ts-input" name="timeSessao" autocomplete="off" required>
                </div>

                <!-- Lucas 29022024 - id862 adicionado Select para administradora -->
                <div class="col-md-2">
                    <label class="form-label ts-label">Administradora</label>
                    <select class="form-select ts-input" name="administradora">
                        <option <?php if ($empresa['administradora'] == "1") {
                                    echo "selected";
                                } ?> value="1">Sim</option>
                        <option <?php if ($empresa['administradora'] == "0") {
                                    echo "selected";
                                } ?> value="0">Não</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label class="form-label ts-label">Pessoa</label>
                    <select class="form-select ts-input" name="idPessoa">
                        <option value="<?php echo null ?>"></option>
                        <?php
                        foreach ($pessoas as $pessoa) {
                            ?>
                            <option <?php if ($pessoa['idPessoa']  == $empresa['idPessoa'] ) {
                                    echo "selected";
                                } ?> value="<?php echo $pessoa['idPessoa'] ?>">
                                <?php echo $pessoa['nomePessoa'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-9">
                    <div class="container-fluid p-0">
                        <div class="col">
                            <span class="tituloEditor">Menu</span>
                        </div>
                        <div class="quill-menu" style="height:20vh !important"></div>
                        <textarea style="display: none" id="quill-menu" name="menu"><?php echo $empresa['menu']; ?></textarea>
                    </div>
                </div>
            </div>    

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- QUILL editor -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <script>
        var menu = new Quill('.quill-menu', {
            theme: 'snow'
        });

        var initialContent = document.getElementById('quill-menu').value;
        menu.clipboard.dangerouslyPasteHTML(0, initialContent);

        menu.on('text-change', function(delta, oldDelta, source) {
            $('#quill-menu').val(menu.container.firstChild.innerHTML);
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>