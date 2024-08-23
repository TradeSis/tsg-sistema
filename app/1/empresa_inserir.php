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
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "empresa_inserir";
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

if (isset($jsonEntrada['nomeEmpresa'])) {
    $nomeEmpresa = isset($jsonEntrada['nomeEmpresa']) && $jsonEntrada['nomeEmpresa'] !== "" ? "'" . $jsonEntrada['nomeEmpresa'] . "'" : "NULL";
    $host = isset($jsonEntrada['host']) && $jsonEntrada['host'] !== "" ? "'" . $jsonEntrada['host'] . "'" : "''";
    $base = isset($jsonEntrada['base']) && $jsonEntrada['base'] !== "" ? "'" . $jsonEntrada['base'] . "'" : "''";
    $usuario = isset($jsonEntrada['usuario']) && $jsonEntrada['usuario'] !== "" ? "'" . $jsonEntrada['usuario'] . "'" : "''";
    $senhadb = isset($jsonEntrada['senhadb']) && $jsonEntrada['senhadb'] !== "" ? "'" . $jsonEntrada['senhadb'] . "'" : "''";
    $timeSessao = isset($jsonEntrada['timeSessao']) && $jsonEntrada['timeSessao'] !== "" ?  $jsonEntrada['timeSessao']  : "NULL";
    $menu = isset($jsonEntrada['menu']) && $jsonEntrada['menu'] !== "" ? "'" . $jsonEntrada['menu'] . "'" : "NULL";
    //Lucas 29022024 - id862 adiconado campo administradora
    $administradora = isset($jsonEntrada['administradora']) && $jsonEntrada['administradora'] !== "" ?  $jsonEntrada['administradora']  : "NULL";
    $cnpj = isset($jsonEntrada['cnpj']) && $jsonEntrada['cnpj'] !== "" ? "'" . $jsonEntrada['cnpj'] . "'" : "NULL";
    $progressdb = isset($jsonEntrada['progressdb']) && $jsonEntrada['progressdb'] !== "" ? "'" . $jsonEntrada['progressdb'] . "'" : "NULL";
    $progressld = isset($jsonEntrada['progressld']) && $jsonEntrada['progressld'] !== "" ? "'" . $jsonEntrada['progressld'] . "'" : "NULL";
    $etbcodPadrao = isset($jsonEntrada['etbcodPadrao']) && $jsonEntrada['etbcodPadrao'] !== "" ? "'" . $jsonEntrada['etbcodPadrao'] . "'" : "NULL";

    $sql = "INSERT INTO empresa (nomeEmpresa, host, base, usuario, senhadb, timeSessao, menu, administradora, cnpj, progressdb, progressld, etbcodPadrao) 
    values ($nomeEmpresa, $host, $base, $usuario, $senhadb, $timeSessao, $menu, $administradora, $cnpj, $progressdb, $progressld, $etbcodPadrao) ";
    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {
        $progEntrada = array(
			'nomeEmpresa' => $jsonEntrada['nomeEmpresa'],
			'host' => $jsonEntrada['host'],
			'base' => $jsonEntrada['base'],
			'usuario' => $jsonEntrada['usuario'],
			'senhadb' => $jsonEntrada['senhadb'],
			'timeSessao' => $jsonEntrada['timeSessao'],
			'menu' => $jsonEntrada['menu'],
			'administradora' => $jsonEntrada['administradora'],
			'cnpj' => $jsonEntrada['cnpj'],
			'progressdb' => $jsonEntrada['progressdb'],
			'progressld' => $jsonEntrada['progressld'],
			'etbcodPadrao' => $jsonEntrada['etbcodPadrao']
		);
        $progr = new chamaprogress();
        $retorno = $progr->executarprogress("sistema/app/1/empresa_inserir",json_encode($progEntrada));
        fwrite($arquivo,$identificacao."-RETORNO-PROGRESS>".$retorno."\n"); 

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
