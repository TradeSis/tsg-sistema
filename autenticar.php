<?php
// lucas 120320204 id884 bootstrap local - alterado head
include_once __DIR__ . "/../config.php";
include_once 'conexao.php';


if (isset($_POST['token'])) {
    $dados = array();
    $apiEntrada = $_GET['apiEntrada'];
    $apiEntrada['dadosEntrada'][0]['token'] = $_POST['token'];
    $dados = chamaAPI(null, '/sistema/login/token', json_encode($apiEntrada), 'GET');

    if (isset($dados['idLogin'])) {

        $user = $dados['loginNome'];
        $idLogin = $dados['idLogin'];
        $email = $dados['email'];

        session_start();

        $_SESSION['START'] = time();
        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['usuario'] = $user;
        $_SESSION['idLogin'] = $idLogin;
        $_SESSION['email'] = $email;

        setcookie('User', $apiEntrada['dadosEntrada'][0]['login'], strtotime("+1 year"), "/", "", false, true);
        setcookie('password', $apiEntrada['dadosEntrada'][0]['password'], strtotime("+1 year"), "/", "", false, true);

        header('Location: loginEmpresa.php?empresa=' . urlencode(json_encode($dados['empresa'])));

    } else {
        $mensagem = $dados['retorno'];
        header('Location: ' . URLROOT . '/sistema/login.php?mensagem=' . $mensagem);
    }
    die();
}
?>



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
                            <p class="text-lead text">Por favor faça login.</p>
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
                            <form method="post">
                                <h5 class="text-center">Informe o token</h5>
                                <input type="text" name="token" class="form-control" required autocomplete="off">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Autenticar</button>
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