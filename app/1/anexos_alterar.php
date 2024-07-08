<?php
// helio 01/11/2023 - tabela anexos, banco *_site, empresa 0
$conexao = conectaMysql(0);

if (isset($jsonEntrada['idAnexo'])) {
    $idAnexo = $jsonEntrada['idAnexo'];
    $nomeAnexo = $jsonEntrada['nomeAnexo'];
    $base64 = $jsonEntrada['base64'];

    if($base64 == ''){
        $sql = "UPDATE anexo SET nomeAnexo='$nomeAnexo' WHERE idAnexo = $idAnexo";
    }else{
        $sql = "UPDATE anexo SET nomeAnexo='$nomeAnexo', base64='$base64' WHERE idAnexo = $idAnexo";
    }
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