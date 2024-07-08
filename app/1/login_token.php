<?php
// Lucas 20042023 adicionado no if "email"
//gabriel 220323 11:10 envio de idcliente
//Lucas 08032023
//echo "-ENTRADA->" . json_encode($jsonEntrada) . "\n";
// helio 01/11/2023 - banco padrao, empresa null
$conexao = conectaMysql(null);

require_once '../vendor/autoload.php';

$google2fa = new \PragmaRX\Google2FA\Google2FA();


//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "login_token";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "sistema_" . date("dmY") . ".log", "a");
        }
    }

}
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL == 1) {
        fwrite($arquivo, $identificacao . "\n");
    }
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
    }
}
//LOG

if (!isset($jsonEntrada["loginNome"]) || !isset($jsonEntrada["nomeEmpresa"]) || !isset($jsonEntrada["token"]) || $jsonEntrada["loginNome"] == "" || $jsonEntrada["nomeEmpresa"] == "" || $jsonEntrada["token"] == "") {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltou dados de login"
    );
} else {
    $nomeEmpresa = $jsonEntrada["nomeEmpresa"];
    $loginNome = $jsonEntrada["loginNome"];
    $token = $jsonEntrada["token"];

    
    $loginNomes = array();

    $sql = "SELECT login.*, empresa.nomeEmpresa, empresa.timeSessao, empresa.administradora FROM login
                LEFT JOIN empresa on empresa.idEmpresa = login.idEmpresa 
                WHERE nomeEmpresa='$nomeEmpresa' AND (email = '$loginNome' OR loginNome = '$loginNome' OR cpfCnpj = '$loginNome')";
    //echo $sql;

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    $buscar = mysqli_query($conexao, $sql);
    $rows = mysqli_num_rows($buscar);


    if ($rows == 0) {
        $jsonSaida = array(
            "status" => 401,
            "retorno" => "Empresa ou usuario incorreto"
        );
    } else {

        $loginNomes = mysqli_fetch_assoc($buscar);
        if ($loginNomes["loginNome"] == $loginNome || $loginNomes["email"] == $loginNome || $loginNomes["cpfCnpj"] == $loginNome) {
            if ($google2fa->verifyKey($loginNomes["secret"], $jsonEntrada['token'])) {

                $jsonSaida = array(
                    "idLogin" => $loginNomes["idLogin"],
                    "loginNome" => $loginNomes["loginNome"],
                    "nomeEmpresa" => $loginNomes["nomeEmpresa"],
                    "idEmpresa" => $loginNomes["idEmpresa"],
                    "timeSessao" => $loginNomes["timeSessao"],
                    "statusLogin" => $loginNomes["statusLogin"],
                    "email" => $loginNomes["email"],
                    "cpfCnpj" => $loginNomes["cpfCnpj"],
                    "pedeToken" => $loginNomes["pedeToken"],
                    "token" => "true",
                    //Lucas 29022024 - adicionado campo administradora
                    "administradora" => $loginNomes["administradora"],
                    "status" => 200,
                    "retorno" => ""
                );
            } else {
                $jsonSaida = array(
                    "status" => 401,
                    "retorno" => "Token incorreto"
                );
            }
        }
    }
}

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG
?>