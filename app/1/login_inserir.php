<?php

// helio 01/11/2023 - banco padrao, empresa null
$conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "login_inserir";
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

if (isset($jsonEntrada['loginNome'])) {
    $loginNome = $jsonEntrada['loginNome'];
    $idEmpresa = $jsonEntrada['idEmpresa'];
    $email = $jsonEntrada['email'];
    $cpfCnpj = $jsonEntrada['cpfCnpj'];
    $pedeToken = $jsonEntrada['pedeToken'];
    $password = md5($jsonEntrada['password']);

    $statusLogin = 0;
    $statusUsuario = 1;
    if ($cpfCnpj == "") {
        $cpfCnpj = "NULL";
    }

    if ($email === "") {
        $sql = "INSERT INTO login( `loginNome`, `idEmpresa`, `cpfCnpj`, `pedeToken`, `password`, `statusLogin`) VALUES ('$loginNome', $idEmpresa, $cpfCnpj, $pedeToken, '$password', $statusLogin)";
    } else {
        $sql = "INSERT INTO login( `loginNome`, `idEmpresa`, `email`, `cpfCnpj`, `pedeToken`, `password`, `statusLogin`) VALUES ('$loginNome', $idEmpresa, '$email', $cpfCnpj, $pedeToken, '$password', $statusLogin)";
    }
    //echo "-SQL->".$sql."\n";

      //LOG
      if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG
    $atualizar = mysqli_query($conexao, $sql);
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

    // busca dados idLogin    
    $sql2 = "SELECT * FROM login WHERE loginNome = '$loginNome'";
    $buscar2 = mysqli_query($conexao, $sql2);
    $row = mysqli_fetch_array($buscar2, MYSQLI_ASSOC);
    $idLogin = $row["idLogin"];
    //echo "-SQL2->".$sql2."\n";

    $conexao2 = conectaMysql($idEmpresa);
    $sql3 = "INSERT INTO `usuario`( `nomeUsuario`, `email`, `idLogin`, `statusUsuario`) VALUES ('$loginNome', '$email', $idLogin, $statusUsuario)";
    //echo "-SQL3->".$sql3."\n";
    $atualizar3 = mysqli_query($conexao2, $sql3);

     //TRY-CATCH
     try {

        $atualizar3 = mysqli_query($conexao, $sql);
        if (!$atualizar3)
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
        "retorno" => "Faltaram parâmetros"
    );
}

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG
