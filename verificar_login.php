<?php
//Lucas 29022024 - id862 Empresa Administradora
//Lucas 10/04/2023 modificado a header para ser redirecionado para painel.php
//gabriel 220323 11:19 adicionado idcliente
// helio 26012023 16:16

include_once 'conexao.php';
$login = $_POST['login'];
$vpassword = $_POST['password'];

$apiEntrada =
    array(
        "dadosEntrada" => array(
            array(
                'login' => $login,
                'password' => $vpassword
            )
        )
    );

$dados = chamaAPI(null, '/sistema/login/verifica', json_encode($apiEntrada), 'GET');


if (isset($dados["pedeToken"])) {
    if ($dados['pedeToken'] == 1) {
        if ($dados['statusLogin'] == 0) {
            header('Location: auth.php?idLogin=' . $dados['idLogin'] . '&email=' . $dados['email']);
        } else {
            header('Location: autenticar.php?' . http_build_query(['apiEntrada' => $apiEntrada]));
        }
    } else {
        $user = $dados['loginNome'];
        $idLogin = $dados['idLogin'];
        $email = $dados['email'];

        session_start();

        $_SESSION['START'] = time();
        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['usuario'] = $user;
        $_SESSION['idLogin'] = $idLogin;
        $_SESSION['email'] = $email;


        setcookie('User', $login, strtotime("+1 year"), "/", "", false, true);
        setcookie('password', "", strtotime("+1 year"), "/", "", false, true);

        header('Location: loginEmpresa.php?empresa=' . urlencode(json_encode($dados['empresa'])));

    }
} else {

    if (isset($dados['retorno'])) {
        $mensagem = $dados['retorno'];
    } else {
        $mensagem = "Erro ao conectar";
    }

    header('Location: login.php?mensagem=' . $mensagem);
}
?>