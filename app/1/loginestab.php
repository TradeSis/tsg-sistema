<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "login_estab";
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

$estab = array();


$progr = new chamaprogress();
// PASSANDO idEmpresa PARA PROGRESS
if (isset($jsonEntrada['dadosEntrada'][0]['idEmpresaLogado'])) {
    $progr->setempresa($jsonEntrada['dadosEntrada'][0]['idEmpresaLogado']);
 }
$retorno = $progr->executarprogress("sistema/app/1/loginestab", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$estab = json_decode($retorno, true);
if (isset($estab["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
    $estab = $estab["conteudoSaida"][0];
} else {

    $estab = $estab["loginestab"];

}


$jsonSaida = $estab;


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG

fclose($arquivo);

?>