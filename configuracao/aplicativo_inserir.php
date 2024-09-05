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
                <h2 class="ts-tituloPrincipal">Inserir Aplicativo</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="/sistema/configuracao/aplicativo.php" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/aplicativo.php?operacao=inserir" method="post" enctype="multipart/form-data">

            <div class="row mt-3">
                <div class="col-sm">
                        <label class='form-label ts-label'>Nome do Aplicativo</label>
                        <input type="text" name="nomeAplicativo" class="form-control ts-input" required autocomplete="off">
                </div>
                <div class="col-sm">
                        <label class='form-label ts-label'>Caminho</label>
                        <input type="text" name="appLink" class="form-control ts-input" required autocomplete="off">
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Inserir</button>
            </div>
        </form>

    </div>
   
    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT. "/vendor/footer_js.php";?>

    <script>
        $(document).ready(function () {
            $("#form").submit(function () {
                var formData = new FormData(this);

                $.ajax({
                    url: "../database/aplicativo.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    success: refreshPage(),
                    cache: false,
                    contentType: false,
                    processData: false,

                });

            });

            function refreshPage() {
                window.location.reload();
            }
        });

    </script>
  
    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

    </body>

</html>