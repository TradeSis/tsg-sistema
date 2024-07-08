<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

require_once '../vendor/autoload.php';

$google2fa = new \PragmaRX\Google2FA\Google2FA();

function removePasswords($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if ($key === 'password') {
                unset($data[$key]);
            } else if (is_array($value)) {
                $data[$key] = removePasswords($value);
            }
        }
    }
    return $data;
}

$logJsonEntrada = removePasswords($jsonEntrada);

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
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($logJsonEntrada) . "\n");
    }
}
//LOG

$login = array();


$progr = new chamaprogress();
$retorno = $progr->executarprogress("sistema/app/1/login_verifica", json_encode($jsonEntrada));
$logRetorno = json_encode(removePasswords(json_decode($retorno, true)));
fwrite($arquivo, $identificacao . "-RETORNO->" . $logRetorno . "\n");
$login = json_decode($retorno, true);
if (isset($login["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
    $login = $login["conteudoSaida"][0];
} else {
    $login = $login["login"][0]; // Retorno sem array
}

if ($google2fa->verifyKey($login['secret'], $jsonEntrada['dadosEntrada'][0]['token'])) {
    $jsonSaida = $login;
} else {
    $jsonSaida = array(
        "status" => 401,
        "retorno" => "Token incorreto"
    );
}



$logJsonSaida = removePasswords($jsonSaida);

// LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($logJsonSaida) . "\n\n");
    }
}
// LOG

fclose($arquivo);

?>