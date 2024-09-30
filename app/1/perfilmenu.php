<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "perfilmenu";
  if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 1) {
      $arquivo = fopen(defineCaminhoLog() . "perfilmenu_" . date("dmY") . ".log", "a");
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

$perfilmenu = array();


$progr = new chamaprogress();
$retorno = $progr->executarprogress("sistema/app/1/perfilmenu", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$perfilmenu = json_decode($retorno, true);
if (isset($perfilmenu["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
  $perfilmenu = $perfilmenu["conteudoSaida"][0];
} else {

  $idPerfil = isset($jsonEntrada['dadosEntrada'][0]['idMenu']) ? $jsonEntrada['dadosEntrada'][0]['idMenu'] : null;

  if (!isset($perfilmenu["perfilmenu"][1]) && $idPerfil !== null) {  // Verifica se tem mais de 1 registro 
          $perfilmenu = $perfilmenu["perfilmenu"][0];  // Retorno sem array
  } else {
      $perfilmenu = $perfilmenu["perfilmenu"];  
  }

}


$jsonSaida = $perfilmenu;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG

fclose($arquivo);



?>