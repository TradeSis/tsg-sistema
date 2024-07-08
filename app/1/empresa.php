<?php
// helio 31012023 - ajustado a api para receber o jsonEntrada, e pegar parametro od idCliente
// helio 26012023 18:10 - Criacao primeira api - falta parametros para where
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
// helio 01/11/2023 - banco padrao, empresa null
$conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."empresa";
    if(isset($LOG_NIVEL)) {
        if ($LOG_NIVEL>=1) {
            $arquivo = fopen(defineCaminhoLog()."sistema_".date("dmY").".log","a");
        }
    }
    
}
if(isset($LOG_NIVEL)) {
    if ($LOG_NIVEL==1) {
        fwrite($arquivo,$identificacao."\n");
    }
    if ($LOG_NIVEL>=2) {
        fwrite($arquivo,$identificacao."-ENTRADA->".json_encode($jsonEntrada)."\n");
    }
}
//LOG

$empresa = array();

$sql = "SELECT * FROM empresa ";
if (isset($jsonEntrada["idEmpresa"])) {
  $sql = $sql . " where empresa.idEmpresa = " . $jsonEntrada["idEmpresa"];
}

//echo $sql;

//LOG
if(isset($LOG_NIVEL)) {
  if ($LOG_NIVEL>=3) {
      fwrite($arquivo,$identificacao."-SQL->".$sql."\n");
  }
}
//LOG

$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($empresa, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idEmpresa"]) && $rows==1) {
  $empresa = $empresa[0];
}
$jsonSaida = $empresa;


//LOG
if(isset($LOG_NIVEL)) {
  if ($LOG_NIVEL>=2) {
      fwrite($arquivo,$identificacao."-SAIDA->".json_encode($jsonSaida)."\n\n");
  }
}
//LOG
?>