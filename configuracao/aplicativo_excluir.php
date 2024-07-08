<?php
//Lucas 04042023 criado

include_once('../header.php');
include_once('../database/aplicativo.php');

$aplicativo = buscaAplicativos($_GET['idAplicativo']);

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
                <h2 class="ts-tituloPrincipal">Excluir Aplicativo</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="/sistema/configuracao/aplicativo.php" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/aplicativo.php?operacao=excluir" method="post">
            <label class='form-label ts-label'></label>
                <input type="text" class="form-control ts-input" name="nomeAplicativo" value="<?php echo $aplicativo['nomeAplicativo'] ?>">
                <input type="hidden" class="form-control ts-input" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?>">
            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-danger"><i class="bi bi-sd-card-fill"></i>&#32;Excluir</button>
            </div>

        </form>


    </div>
   <!-- LOCAL PARA COLOCAR OS JS -->

   <?php include_once ROOT. "/vendor/footer_js.php";?>

     <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>