<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
// helio 01/11/2023 - banco *_site, empresa 0
$conexao = conectaMysql(0);

if (isset($jsonEntrada['tituloSecao'])) {

	$tituloSecao = $jsonEntrada['tituloSecao'];
	$arquivoFonte = $jsonEntrada['arquivoFonte'];
    $tipoSecao = $jsonEntrada['tipoSecao'];
    
    $sql = "INSERT INTO `secoes`(`tituloSecao`, `arquivoFonte`, `tipoSecao`) VALUES ('$tituloSecao','$arquivoFonte','$tipoSecao')";
    if ($atualizar = mysqli_query($conexao, $sql)) {
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } else {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => "erro no mysql"
        );
    }
} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );

}

?>