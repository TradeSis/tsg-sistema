<?php
// Lucas 06102023 padrao novo
//Lucas 04042023 criado

include_once ('../header.php');
include_once ('../database/loginEstab.php');
include_once ('../database/login.php');

$login = buscaLogins($_GET['idLogin']);
$loginEstab = buscaLoginEstab($_GET['idLogin'], $_GET['etbcod'], $_GET['idEmpresa']);
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
                <h2 class="ts-tituloPrincipal">Alterar Estabelecimento</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i
                        class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-sm-6">
                <label class='form-label ts-label'>Usuário</label>
                <input type="text" class="form-control ts-input" name="loginNome"
                    value="<?php echo $login['loginNome'] ?>" readonly>
            </div>
            <div class="col-sm-5 mt-1">
                <label class='form-label ts-label'>Estabelecimento</label>
                <input type="text" class="form-control ts-input" name="etbcod" value="<?php echo $loginEstab[0]['etbcod'] ?>"
                    readonly>
            </div>
            <div class="col-sm-1 mt-4">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#zoomEstabModal" 
                data-idLogin="<?php echo $idLogin ?>"><i class="bi bi-search"></i></button>
            </div>
        </div>
        <div class="text-end mt-4">
            <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
        </div>
    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <?php include 'zoomEstab.php'; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

    <script>
        $(document).on('click', '.ts-click', function () {
            var idLogin = <?php echo $_GET['idLogin'] ?>;
            var etbcod = <?php echo $_GET['etbcod'] ?>;
            var idEmpresa = <?php echo $_GET['idEmpresa'] ?>;
            var vetbcod = $(this).attr("data-etbcod");
            $.ajax({
                url: "../database/loginEstab.php?operacao=alterar",
                type: 'POST',
                data: {
                    idLogin: idLogin,
                    etbcod: etbcod,
                    idEmpresa: idEmpresa,
                    vetbcod: vetbcod
                },
                success: function (msg) {
                    window.location.href = 'login_alterar.php?id=empresa&&idLogin=' + idLogin ;
                }
            });
        });
    </script>

</body>

</html>