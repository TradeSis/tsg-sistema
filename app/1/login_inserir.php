<?php
// PROGRESS
// ALTERAR E INSERIR


//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "login_inserir";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "sistema_". date("dmY") . ".log", "a");
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

if (isset($jsonEntrada['dadosEntrada'])) {

    try {

        $progr = new chamaprogress();
        $retorno = $progr->executarprogress("sistema/app/1/login_inserir",json_encode($jsonEntrada));
        fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");
        $conteudoSaida = json_decode($retorno,true);
        if (isset($conteudoSaida["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
            $jsonSaida = $conteudoSaida["conteudoSaida"][0];
        } 
        
        $loginEntrada= array(
			"dadosEntrada" => array(
				array(
					'idLogin' => $jsonSaida['idLogin']
				)
			)
		);;
        $retornoLogin = $progr->executarprogress("sistema/app/1/login", json_encode($loginEntrada));
        $login = json_decode($retornoLogin, true);
        $login = $login["login"][0]; 
        
        $loginNome = "'". $login["loginNome"]."'";
        $email = "'". $login["email"]."'";
        $idLogin = $login["idLogin"];
        $statusUsuario = 1;
        
        $conexao = conectaMysql($jsonEntrada['dadosEntrada'][0]['idEmpresa']);
        fwrite($arquivo, $identificacao . "-APP_INICIAL->" . APP_INICIAL . "\n");
        if (APP_INICIAL == "servicos") {
            fwrite($arquivo, $identificacao . "-SERVICOS->" . APP_INICIAL . "\n");
            $sql = "INSERT INTO `usuario`( `nomeUsuario`, `email`, `idLogin`, `statusUsuario`) VALUES ($loginNome, $email, $idLogin, $statusUsuario)";
            $atualizar = mysqli_query($conexao, $sql);
        }

    } 
    catch (Exception $e) {
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



fclose($arquivo);

?>