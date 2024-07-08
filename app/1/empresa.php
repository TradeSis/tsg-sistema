<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "empresa";
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

$empresa = array();


$progr = new chamaprogress();
$retorno = $progr->executarprogress("sistema/app/1/empresa", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$empresa = json_decode($retorno, true);
if (isset($empresa["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
    $empresa = $empresa["conteudoSaida"][0];
} else {

    if (!isset($empresa["empresa"][1]) && ($jsonEntrada['idEmpresa'] != null)) {  // Verifica se tem mais de 1 registro
        $empresa = $empresa["empresa"][0]; // Retorno sem array
    } else {
        $empresa = $empresa["empresa"];
    }

}


$jsonSaida = $empresa;


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG

fclose($arquivo);

?>