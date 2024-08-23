<?php
//Lucas 29022024 - id862 Empresa Administradora
// Lucas 20042023 adicionado no if "email"
//gabriel 220323 11:10 envio de idcliente
//Lucas 08032023
//echo "-ENTRADA->" . json_encode($jsonEntrada) . "\n";
// helio 01/11/2023 - banco padrao, empresa null
$conexao = conectaMysql(null);


//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."login_verifica";
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

if (!isset($jsonEntrada["login"])||!isset($jsonEntrada["nomeEmpresa"])||!isset($jsonEntrada["vpassword"])||$jsonEntrada["login"]==""||$jsonEntrada["nomeEmpresa"]==""||$jsonEntrada["vpassword"]=="") {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltou dados de login"
    );
} else {
    $nomeEmpresa = $jsonEntrada["nomeEmpresa"];
    $login = $jsonEntrada["login"];
    $password = md5($jsonEntrada["vpassword"]);

    $logins = array();

    //Lucas 29022024 - adicionado campo administradora
    $sql = "SELECT login.*, empresa.nomeEmpresa, empresa.timeSessao, empresa.administradora FROM login
                LEFT JOIN empresa on empresa.idEmpresa = login.idEmpresa 
                WHERE nomeEmpresa='$nomeEmpresa' AND (email = '$login' OR login = '$login' OR cpfCnpj = '$login')";
    //echo $sql;

    //LOG
    if(isset($LOG_NIVEL)) {
        if ($LOG_NIVEL>=3) {
            fwrite($arquivo,$identificacao."-SQL->".$sql."\n");
        }
    }
    //LOG
    $buscar = mysqli_query($conexao, $sql);
    $rows = mysqli_num_rows($buscar);


    if ($rows == 0) {
        $jsonSaida = array(
            "status" => 401,
            "retorno" => "Empresa ou usuario incorreto"
        );
    } else {

        $logins = mysqli_fetch_assoc($buscar);
        if ($logins["email"] == $login || $logins["cpfCnpj"] == $login) {
            if ($logins["password"] == $password) {

                $jsonSaida = array(
                    "idLogin" => $logins["idLogin"],
                    "login" => $logins["login"],
                    "nomeEmpresa" => $logins["nomeEmpresa"],
                    "idEmpresa" => $logins["idEmpresa"],
                    "timeSessao" => $logins["timeSessao"],
                    "statusLogin" => $logins["statusLogin"],
                    "email" => $logins["email"],
                    "cpfCnpj" => $logins["cpfCnpj"],
                    "pedeToken" => $logins["pedeToken"],
                    //Lucas 29022024 - adicionado campo administradora
                    "administradora" => $logins["administradora"],
                    "status" => 200,
                    "retorno" => ""
                );
            } else {
                $jsonSaida = array(
                    "status" => 401,
                    "retorno" => "Senha incorreta"
                );
            }
        }
    }
}

//LOG
if(isset($LOG_NIVEL)) {
    if ($LOG_NIVEL>=2) {
        fwrite($arquivo,$identificacao."-SAIDA->".json_encode($jsonSaida)."\n\n");
    }
}
//LOG
?>