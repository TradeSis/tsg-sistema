<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "loginaplicativo";
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

$app = array();


$progr = new chamaprogress();
$retorno = $progr->executarprogress("sistema/app/1/loginaplicativo", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$app = json_decode($retorno, true);
if (isset($app["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
    $app = $app["conteudoSaida"][0];
} else {

    $nomeAplicativo = isset($jsonEntrada['dadosEntrada'][0]['nomeAplicativo']) ? $jsonEntrada['dadosEntrada'][0]['nomeAplicativo'] : null;

    if (!isset($app["loginaplicativo"][1]) && $nomeAplicativo !== null) {  // Verifica se tem mais de 1 registro
        $app = $app["loginaplicativo"][0]; // Retorno sem array
    } else {
        $app = $app["loginaplicativo"];
    }

}


$jsonSaida = $app;


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG

fclose($arquivo);

/* **antigo sql para referencia*
$sql = "SELECT loginaplicativo.*, login.loginNome, aplicativo.nomeAplicativo FROM loginaplicativo
        LEFT JOIN login on loginaplicativo.idLogin = login.idLogin
        LEFT JOIN aplicativo on loginaplicativo.idAplicativo = aplicativo.idAplicativo";
$where = " WHERE ";

if (isset($jsonEntrada["idLogin"])) {
  $sql = $sql . $where . " loginaplicativo.idLogin = " . $jsonEntrada["idLogin"];
  $where = " AND ";
} 
if (isset($jsonEntrada["nomeAplicativo"])) {
  $sql = $sql . $where . " aplicativo.nomeAplicativo = " . "'" . $jsonEntrada["nomeAplicativo"] . "'";
  $where = " AND ";
}

$sql = $sql . " ORDER BY idLogin"; */
?>