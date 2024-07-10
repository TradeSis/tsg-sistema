<?php
include_once __DIR__ . "/../config.php";
session_start();

$estabJson = urldecode($_GET['estab']);
$estabs = json_decode($estabJson, true);

if (isset($_POST['etbcod'])) {

    $_SESSION['etbcod'] = $_POST['etbcod'];
    foreach ($estabs as $estab) {
        if ($estab['etbcod'] == $_POST['etbcod']) {
            $_SESSION['etbnom'] = $estab['etbnom'];
        }
    }

    header('Location: ' . URLROOT . '/' . APP_INICIAL);
}


if (!isset($_GET['estab'])) {

    $estabEntrada =
    array(
        'etbcod' => $_SESSION['etbcod'],
        'idEmpresa' => $_SESSION['idEmpresa']
    );
    $estabPadrao = chamaAPI(null, '/cadastros/estab', json_encode($estabEntrada), 'GET');

    $_SESSION['etbnom'] = $estabPadrao[0]['etbnom'];
    header('Location: ' . URLROOT . '/' . APP_INICIAL);
}
if (count($estabs) == 1) {

    $_SESSION['etbcod'] = $estabs[0]['etbcod'];
    $_SESSION['etbnom'] = $estabs[0]['etbnom'];

    header('Location: ' . URLROOT . '/' . APP_INICIAL);

} else { ?>

    <!doctype html>
    <html lang="pt-BR">

    <head>

        <?php include_once ROOT . "/vendor/head_css.php"; ?>

    </head>

    <body class="bg-default mt-5">
        <div>
            <!-- Header -->
            <div class="header ">
                <div class="container">
                    <div class="header-body text-center mb-2">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-7">
                                <p class="text-lead text">Por favor selecione a estabelecimento desejado.</p>
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
                                <form role="form" action="loginEstab.php?estab=<?php echo urlencode(json_encode($estabs)) ?>" method="post">
                                    <label class="form-label ts-label">Estabelecimento</label>
                                    <select class="form-select ts-input" name="etbcod" autocomplete="off">
                                        <?php foreach ($estabs as $estab) { ?>
                                            <option value="<?php echo $estab['etbcod']; ?>">
                                                <?php echo $estab['etbnom']; ?>
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