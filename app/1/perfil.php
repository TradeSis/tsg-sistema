<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "perfil";
  if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 1) {
      $arquivo = fopen(defineCaminhoLog() . "perfil_" . date("dmY") . ".log", "a");
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

$perfil = array();


$progr = new chamaprogress();
$retorno = $progr->executarprogress("sistema/app/1/perfil", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$perfil = json_decode($retorno, true);
if (isset($perfil["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
  $perfil = $perfil["conteudoSaida"][0];
} else {

  $idPerfil = isset($jsonEntrada['dadosEntrada'][0]['idPerfil']) ? $jsonEntrada['dadosEntrada'][0]['idPerfil'] : null;

  if (!isset($perfil["perfil"][1]) && $idPerfil !== null) {  // Verifica se tem mais de 1 registro 
          $perfil = $perfil["perfil"][0];  // Retorno sem array
  } else {
      $perfil = $perfil["perfil"];  
  }

}


$jsonSaida = $perfil;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG

fclose($arquivo);



?>