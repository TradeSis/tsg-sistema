<?php
// Lucas 06102023 padrao novo
//Lucas 04042023 criado
include_once('../header.php');
include_once('../database/login.php');
include_once('../database/empresa.php');

$login = buscaLogins($_GET['idLogin']);
$empresas = buscaEmpresas();

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
                <h2 class="ts-tituloPrincipal">Inserir Usuario/Empresa</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>

        <form action="../database/login.php?operacao=empresaInserir" method="post" enctype="multipart/form-data">

            <div class="row mt-3">
                <div class="col-sm">
                    <label class='form-label ts-label'>Usuário</label>
                    <input type="text" class="form-control ts-input" name="loginNome" value="<?php echo $login['loginNome'] ?>" readonly>
                    <input type="hidden" class="form-control ts-input" name="idLogin" value="<?php echo $login['idLogin'] ?>">
                </div>
                <div class="col-sm mt-1">
                    <label class='form-label ts-label'>Empresa</label>
                    <select class="form-select ts-input" name="idEmpresa">
                        <?php
                        foreach ($empresas as $empresa) {
                        ?>
                            <option value="<?php echo $empresa['idEmpresa'] ?>"><?php echo $empresa['nomeEmpresa']  ?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Cadastrar</button>
            </div>
        </form>

    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>