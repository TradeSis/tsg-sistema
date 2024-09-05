<?php
// gabriel 30042024 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "menu";
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

$menu = array();


$progr = new chamaprogress();
$retorno = $progr->executarprogress("sistema/app/1/menu", json_encode($jsonEntrada));
fwrite($arquivo, $identificacao . "-RETORNO->" . $retorno . "\n");
$menu = json_decode($retorno, true);
if (isset($menu["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
  $menu = $menu["conteudoSaida"][0];
} else {

  $idMenu = isset($jsonEntrada['dadosEntrada'][0]['idMenu']) ? $jsonEntrada['dadosEntrada'][0]['idMenu'] : null;

  if (!isset($menu["menu"][1]) && $idMenu !== null) {  // Verifica se tem mais de 1 registro 
          $menu = $menu["menu"][0];  // Retorno sem array
  } else {
      $menu = $menu["menu"];  
  }

}


$jsonSaida = $menu;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG

fclose($arquivo);



?>