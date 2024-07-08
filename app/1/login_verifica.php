<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

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
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "login_verifica";
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

    if (!isset($login["login"][1])) {  // Verifica se tem mais de 1 registro
        $login = $login["login"][0]; // Retorno sem array
    } else {
        $login = $login["login"];
    }

}


$jsonSaida = $login;

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