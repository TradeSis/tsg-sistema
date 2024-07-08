<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

// helio 01/11/2023 - banco *_site, empresa 0
$conexao = conectaMysql(0);

$secoes = array();

$sql = "SELECT * FROM secoes ";

if (isset($jsonEntrada["idSecao"])) {
  $sql = $sql . " where secoes.idSecao = " . $jsonEntrada["idSecao"];
} else {
  $sql = $sql . " ORDER BY tipoSecao";
}


$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($secoes, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idSecao"]) && $rows==1) {
  $secoes = $secoes[0];
}
$jsonSaida = $secoes;

//echo "-SAIDA->".json_encode(jsonSaida)."\n";



?>