<?php
// helio 01/11/2023 - tabela anexos, banco *_site, empresa 0
$conexao = conectaMysql(0);

if (isset($jsonEntrada['nomeAnexo'])) {
    $nomeAnexo = $jsonEntrada['nomeAnexo'];
    $base64 = $jsonEntrada['base64'];
    $sql = "INSERT INTO anexo (nomeAnexo, base64) values ('$nomeAnexo', '$base64')";
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