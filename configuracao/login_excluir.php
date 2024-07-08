<?php
// lucas 10102023 novo padrao
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once('../header.php');
include_once('../database/login.php');

$idLogin = $_GET['idLogin'];
$login = buscaLogins($idLogin);

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
                <h2 class="ts-tituloPrincipal">Excluir Usuário</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="aplicativo.php" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/login.php?operacao=excluir" method="post">

            <div class="col-md-12">
                <label class='control-label'></label>
                <input type="text" class="form-control ts-input" name="loginNome" value="<?php echo $login['loginNome'] ?>">
                <input type="text" class="form-control ts-input" name="idLogin" value="<?php echo $login['idLogin'] ?>" style="display: none">
            </div>

            <div class="text-end">
                <button type="submit" id="botao" class="btn btn-sm btn-danger"><i class="bi bi-x-octagon"></i>&#32;Excluir</button>
            </div>
        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->


</body>

</html>