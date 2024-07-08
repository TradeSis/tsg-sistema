<?php
//Lucas 29022024 - id862 Empresa Administradora
// helio 31012023 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
// helio 01/11/2023 - banco padrao, empresa null
$conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "empresa_alterar";
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

if (isset($jsonEntrada['idEmpresa'])) {
    $idEmpresa = $jsonEntrada['idEmpresa'];
    $nomeEmpresa = $jsonEntrada['nomeEmpresa'];
    $timeSessao = $jsonEntrada['timeSessao'];
    $menu = isset($jsonEntrada['menu']) && $jsonEntrada['menu'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['menu']) . "'" : "NULL";
    $idPessoa = isset($jsonEntrada['idPessoa']) && $jsonEntrada['idPessoa'] !== "" ? "'" . mysqli_real_escape_string($conexao, $jsonEntrada['idPessoa']) . "'" : "NULL";
    //Lucas 29022024 - id862 adiconado campo administradora
    $administradora = $jsonEntrada['administradora'];

    $sql = "UPDATE empresa SET nomeEmpresa='$nomeEmpresa', timeSessao=$timeSessao, menu=$menu, idPessoa=$idPessoa, administradora=$administradora WHERE idEmpresa = $idEmpresa";

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } catch (Exception $e) {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => $e->getMessage()
        );
        if ($LOG_NIVEL >= 1) {
            fwrite($arquivo, $identificacao . "-ERRO->" . $e->getMessage() . "\n");
        }
    } finally {
        // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
    }
    //TRY-CATCH
} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );
}

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG
