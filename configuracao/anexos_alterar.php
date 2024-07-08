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
                <h2 class="ts-tituloPrincipal">Alterar Empresa</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="/sistema/configuracao/anexos.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/anexos.php?operacao=alterar" method="post" enctype="multipart/form-data">
            <div class="row mt-4">
                <div class="col-md-8">
                    <label class='form-label ts-label'></label>
                        <input type="text" class="form-control ts-input" name="nomeAnexo" value="<?php echo $anexo['nomeAnexo'] ?>">
                        <input type="hidden" class="form-control ts-input" name="idAnexo" value="<?php echo $anexo['idAnexo'] ?>">
                    </div>

                <div class="col-sm-4">
                    <label class='form-label ts-label'>Anexo</label>
                    <label class="picture" for="anexo" tabIndex="0">
                        <img src="<?php echo $anexo["base64"] ?>" width="100%" height="100%" alt="">
                    </label>
                    <input type="file" name="base64" id="anexo">

                </div>

            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        //Carregar a anexo na tela
        const inputFile = document.querySelector("#anexo");
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