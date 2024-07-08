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
                <h2 class="ts-tituloPrincipal">Excluir Usuario/Aplicativo</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/loginAplicativo.php?operacao=excluir" method="post">
            <div class="row t-3">
                <div class="col-sm">
                    <label class='form-label ts-label'>Usuário</label>
                    <input type="text" class="form-control ts-input" name="loginNome" value="<?php echo $login['loginNome'] ?>" readonly>
                    <input type="hidden" class="form-control ts-input" name="idLogin" value="<?php echo $login['idLogin'] ?>">
                    </select>
                </div>
                <div class="col-sm">
                    <label class='form-label ts-label'>Aplicativo</label>
                    <input type="text" class="form-control ts-input" name="nomeAplicativo" value="<?php echo $aplicativo['nomeAplicativo'] ?>" readonly>
                    <input type="hidden" class="form-control ts-input" name="idAplicativo" value="<?php echo $aplicativo['idAplicativo'] ?>">
                </div>
            </div>
            <div class="text-end mt-4">
                <button type="submit" id="botao" class="btn btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
            </div>

        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>