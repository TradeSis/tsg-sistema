<?php
//Lucas 05042023 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
// helio 01/11/2023 - banco padrao, empresa null
$conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."loginaplicativo";
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


$app = array();

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

$sql = $sql . " ORDER BY idLogin";

//echo "-SQL->" . $sql . "\n";

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
  array_push($app, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["nomeAplicativo"]) && $rows == 1) {
  $app = $app[0];
}
$jsonSaida = $app;
//echo "-SAIDA->".json_encode($usuarioaplicativo)."\n";

//LOG
if(isset($LOG_NIVEL)) {
  if ($LOG_NIVEL>=2) {
      fwrite($arquivo,$identificacao."-SAIDA->".json_encode($jsonSaida)."\n\n");
  }
}
//LOG
?>
