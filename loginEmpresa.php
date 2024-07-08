<?php
// lucas 120320204 id884 bootstrap local - alterado head
include_once __DIR__ . "/../config.php";
include_once 'conexao.php';


$idLogin = null;
if (isset($_SESSION['idLogin'])) {
    $idLogin = $_SESSION['idLogin'];
}
$apiEntrada =
    array(
        "dadosEntrada" => array(
            array(
                'idLogin' => $idLogin,
            )
        )
    );
$empresas = chamaAPI(null, '/sistema/login/empresa', json_encode($apiEntrada), 'GET');

if (isset($_POST['idEmpresa'])) {

    $_SESSION['idEmpresa'] = $_POST['idEmpresa'];
    foreach ($empresas as $empresa) {
        if ($empresa['idEmpresa'] == $_POST['idEmpresa']) {
            $_SESSION['nomeEmpresa'] = $empresa['nomeEmpresa'];
            $_SESSION['timeSessao'] = $empresa['timeSessao'];
            $_SESSION['administradora'] = $empresa['administradora'];
            $_SESSION['etbcod'] = $empresa['etbcodPadrao'];
        }
    }

    if ($_SESSION['etbcod'] !== 0) {
        header('Location: loginEstab.php');
    } else {
        header('Location: ' . URLROOT . '/' . APP_INICIAL);
    }
}


if (isset($empresas["retorno"])) {
    $mensagem = "Usuario sem empresa";
    header('Location: login.php?mensagem=' . $mensagem);
}
if (count($empresas) == 1) {

    $_SESSION['idEmpresa'] = $empresas[0]['idEmpresa'];
    $_SESSION['nomeEmpresa'] = $empresas[0]['nomeEmpresa'];
    $_SESSION['timeSessao'] = $empresas[0]['timeSessao'];
    $_SESSION['administradora'] = $empresas[0]['administradora'];
    $_SESSION['etbcod'] = $empresas[0]['etbcodPadrao'];


    if ($_SESSION['etbcod'] !== 0) {
        header('Location: loginEstab.php');
    } else {
        header('Location: ' . URLROOT . '/' . APP_INICIAL);
    }

} else { ?>

    <!doctype html>
    <html lang="pt-BR">

    <head>
        <?php include_once ROOT . "/vendor/head_css.php"; ?>
    </head>

    <body class="bg-default mt-5">
        <div>
            <!-- Header -->
            <div class="header">
                <div class="container">
                    <div class="header-body text-center mb-2">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-7">
                                <p class="text-lead text">Por favor escolha a empresa.</p>
                            </div>
                            <div class="container">
                                <a class="brand">
                                    <img src="<?php echo URLROOT ?>/img/logo.png">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page content -->
            <div class="container pb-5">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">
                        <div class="card bg-gray-200 shadow border-1">
                            <div class="card-body px-lg-4 py-lg-6">
                                <form role="form" action="loginEmpresa.php" method="post">
                                    <label class="form-label ts-label">Empresa</label>
                                    <select class="form-select ts-input" name="idEmpresa" autocomplete="off">
                                        <?php foreach ($empresas as $empresa) { ?>
                                            <option value="<?php echo $empresa['idEmpresa']; ?>">
                                                <?php echo $empresa['nomeEmpresa']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary my-4">Entrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- LOCAL PARA COLOCAR OS JS -->
        <?php include_once ROOT . "/vendor/footer_js.php"; ?>
        <!-- LOCAL PARA COLOCAR OS JS -FIM -->
    </body>

    </html>

<?php } ?>