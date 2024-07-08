<?php
// helio 01/11/2023 - banco *_site, empresa 0
$conexao = conectaMysql(0);
$anexos = array();

$sql = "SELECT * FROM anexo ";
if (isset($jsonEntrada["idAnexo"])) {
  $sql = $sql . " where anexo.idAnexo = " . $jsonEntrada["idAnexo"];
}

//echo $sql;
$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
  array_push($anexos, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idAnexo"]) && $rows==1) {
  $anexos = $anexos[0];
}
$jsonSaida = $anexos;



?>