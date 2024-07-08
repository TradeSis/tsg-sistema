<?php
// Lucas 06102023 padrao novo
// Lucas 29032023 - alterado link do botão voltar, para redirecionar para o index.php
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../header.php');
include_once('../database/login.php');

$idLogin = $_GET['idLogin'];
$usuario = buscaLogins($idLogin);

$_SESSION['ultimaulr'] = $_SERVER['HTTP_REFERER'];
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>

    <div class="container">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        <div class="row"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Alterar Usuário</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="#" onclick="history.back()" role="button" class="btn btn-primary"><i class="bi bi-arrow-left-square"></i></i>&#32;Voltar</a>
            </div>
        </div>
        
        <form action="../database/login.php?operacao=loginalterar" method="post">
            <div class="row mt-3">
                <div class="col-sm">
                    <label class="form-label ts-label">Nome</label>
                    <input type="text" class="form-control ts-input" name="loginNome" value="<?php echo $usuario['loginNome'] ?>" readonly>
                    <input type="hidden" class="form-control ts-input" name="idLogin" value="<?php echo $usuario['idLogin'] ?>">
                    <input type="hidden" class="form-control ts-input" name="ultimaulr" value="<?php echo $_SESSION['ultimaulr'] ?>">
                </div>
                <div class="col-sm">
                    <label class="form-label ts-label">E-mail</label>
                    <input type="text" class="form-control ts-input" name="email" value="<?php echo $usuario['email'] ?>">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm">
                    <label class="form-label ts-label">Cpf/Cnpj</label>
                    <input type="text" class="form-control ts-input" name="cpfCnpj" value="<?php echo $usuario['cpfCnpj'] ?>">
                </div>
                <div class="col-sm">
                    <label class="form-label ts-label">Pede Token</label>
                    <select class="form-select ts-input" name="pedeToken">
                        <option <?php if ($usuario['pedeToken'] == "1") {
                                    echo "selected";
                                } ?> value="1">Sim</option>
                        <option <?php if ($usuario['pedeToken'] == "0") {
                                    echo "selected";
                                } ?> value="0">Não</option>
                    </select>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn  btn-success"><i class="bi bi-sd-card-fill"></i>&#32;Salvar</button>
            </div>
        </form>
        <button type="button" data-bs-toggle="modal" data-bs-target="#alterarSenhaModal" class="btn btn-sm btn-danger mb-3">Alterar Senha</button>

    </div>
    
    
    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <?php include 'modalAlterarSenha.php'; ?>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>