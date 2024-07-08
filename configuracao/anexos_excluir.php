<?php
// Lucas 06102023 padrao novo
include_once('../header.php');
include_once('../database/anexos.php');

$anexo = buscaAnexos($_GET['idAnexo']);

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
                <h2 class="ts-tituloPrincipal">Excluir Empresa</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="/sistema/configuracao/anexos.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/anexos.php?operacao=excluir" method="post" enctype="multipart/form-data">
            <div class="col-md-12 form-group mb-4">

                <label class='form-label ts-label'></label>
                    <input type="text" class="form-control ts-input" name="nomeAnexo" value="<?php echo $anexo['nomeAnexo'] ?>">
                    <input type="hidden" class="form-control ts-input" name="idAnexo" value="<?php echo $anexo['idAnexo'] ?>">
            </div>

            <div class="text-end mt-4">
                <button type="submit" id="botao" class="btn btn-sm btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
            </div>
        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>