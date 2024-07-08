<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "aplicativo";
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
$retorno = $progr->executarprogress("sistema/app/1/aplicativo", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$app = json_decode($retorno, true);
if (isset($app["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
  $app = $app["conteudoSaida"][0];
} else {

  $idAplicativo = isset($jsonEntrada['dadosEntrada'][0]['idAplicativo']) ? $jsonEntrada['dadosEntrada'][0]['idAplicativo'] : null;

  if (!isset($app["aplicativo"][1]) && $idAplicativo !== null) {  // Verifica se tem mais de 1 registro 
          $app = $app["aplicativo"][0];  // Retorno sem array
  } else {
      $app = $app["aplicativo"];  
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
  if (isset($jsonEntrada["idLogin"])) {
  $sql = "SELECT aplicativo.*, loginaplicativo.idLogin FROM aplicativo
          LEFT JOIN loginaplicativo on aplicativo.idAplicativo = loginaplicativo.idAplicativo";

  if (isset($jsonEntrada["idLogin"])) {
    $sql = $sql . " where loginaplicativo.idLogin = " . $jsonEntrada["idLogin"];
  }
} else {
  $sql = $sql = "SELECT aplicativo.* FROM aplicativo";

  if (isset($jsonEntrada["idAplicativo"])) {
    $sql = $sql . " where aplicativo.idAplicativo = " . $jsonEntrada["idAplicativo"];
  } else {
    $where = " where ";
    if (isset($jsonEntrada["buscaaplicativo"])) {
      $sql = $sql . $where . " aplicativo.nomeAplicativo like " . "'%" . $jsonEntrada["buscaaplicativo"] . "%'";
      $where = " and ";
    }
  }
} */

?>