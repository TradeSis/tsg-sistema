<?php
// Lucas 06102023 padrao novo
//Lucas 04042023 criado

include_once('../header.php');
include_once('../database/loginAplicativo.php');
include_once('../database/login.php');
include_once('../database/aplicativo.php');

$login = buscaLogins($_GET['idLogin']);
$aplicativo = buscaAplicativos($_GET['idAplicativo']);
$usuarioaplicativo = buscaLoginAplicativo($_GET['idLogin'], $_GET['nomeAplicativo']);
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
                <h2 class="ts-tituloPrincipal">Alterar Usuario/Aplicativo</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/loginAplicativo.php?operacao=alterar" method="post" enctype="multipart/form-data">

            <div class="row mt-3">
                <div class="col-sm">
                    <label class='form-label ts-label'>Usuário</label>
                    <input type="text" class="form-control ts-input" name="loginNome" value="<?php echo $login['loginNome'] ?>" readonly>
                    <input type="hidden" class="form-control ts-input" name="idLogin" value="<?php echo $login['idLogin'] ?>">
                </div>
                <div class="col-sm">
                    <label class='form-label ts-label'>Aplicativo</label>
                    <input type="text" class="form-control ts-input" name="nomeAplicativo" value="<?php echo $aplicativo['nomeAplicativo'] ?>" readonly>
                    <input type="hidden" class="form-control ts-input" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?>">
                </div>
                <div class="col-sm">
                    <label class='form-label ts-label'>Nivel</label>
                    <select class="form-select ts-input" name="nivelMenu">
                        <option <?php if ($usuarioaplicativo['nivelMenu'] == "1") {
                                    echo "selected";
                                } ?> value="1">1</option>
                        <option <?php if ($usuarioaplicativo['nivelMenu'] == "2") {
                                    echo "selected";
                                } ?> value="2">2</option>
                        <option <?php if ($usuarioaplicativo['nivelMenu'] == "3") {
                                    echo "selected";
                                } ?> value="3">3</option>
                        <option <?php if ($usuarioaplicativo['nivelMenu'] == "4") {
                                    echo "selected";
                                } ?> value="4">4</option>
                        <option <?php if ($usuarioaplicativo['nivelMenu'] == "5") {
                                    echo "selected";
                                } ?> value="5">5</option>
                    </select>
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
        //Carregar a imagem na tela
        const inputFile = document.querySelector("#imgAplicativo");
        const pictureImage = document.querySelector(".picture__image");
        const pictureImageTxt = "Carregar imagem";
        pictureImage.innerHTML = "<img src='<?php echo $usuarioaplicativo['pathImg']; ?>'>";

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
                pictureImage.innerHTML = "";
            }
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>