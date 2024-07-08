<?php

//echo "metodo=".$metodo."\n";
//echo "funcao=".$funcao."\n";
//echo "parametro=".$parametro."\n";

if ($metodo == "GET") {

  if ($funcao == "login" && $parametro == "verifica") {
    $funcao = "login/verifica";
    $parametro = null;
  }
  if ($funcao == "login" && $parametro == "empresa") {
    $funcao = "login/empresa";
    $parametro = null;
  }
  if ($funcao == "login" && $parametro == "token") {
    $funcao = "login/token";
    $parametro = null;
  }

  switch ($funcao) {

    case "secoes":
      include 'secoes.php';
      break;

    case "empresa":
      include 'empresa.php';
      break;

    case "login":
      include 'login.php';
      break;

    case "login/verifica":
      include 'login_verifica.php';
      break;

    case "login/empresa":
      include 'login_empresa.php';
      break;

    case "login/token":
      include 'login_token.php';
      break;

    case "aplicativo":
      include 'aplicativo.php';
      break;

    case "loginaplicativo":
      include 'loginaplicativo.php';
      break;
      
    case "anexos":
      include 'anexos.php';
      break;  
      
    case "loginestab":
      include 'loginestab.php';
      break;  

    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "PUT") {

  if ($funcao == "login" && $parametro == "empresa") {
    $funcao = "login/empresa";
    $parametro = null;
  }

  switch ($funcao) {

    case "secoes":
      include 'secoes_inserir.php';
      break;

    case "empresa":
      include 'empresa_inserir.php';
      break;

    case "aplicativo":
      include 'aplicativo_inserir.php';
      break;

    case "loginaplicativo":
      include 'loginaplicativo_inserir.php';
      break;

    case "loginestab":
      include 'loginestab_inserir.php';
      break;

    case "login":
      include 'login_inserir.php';
      break;
      
    case "anexos":
      include 'anexos_inserir.php';
      break;

    case "login/empresa":
      include 'loginempresa_inserir.php';
      break; 

    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "POST") {
  if ($funcao == "login" && $parametro == "ativar") {
    $funcao = "configuracao/ativar";
    $parametro = null;
  }

  switch ($funcao) {

    case "secoes":
      include 'secoes_alterar.php';
      break;

    case "empresa":
      include 'empresa_alterar.php';
      break;
    case "usuario/ativar":
      include 'usuario_ativar.php';
      break;
    case "aplicativo":
      include 'aplicativo_alterar.php';
      break;

    case "loginaplicativo":
      include 'loginaplicativo_alterar.php';
      break;

    case "loginestab":
      include 'loginestab_alterar.php';
      break;

    case "configuracao/ativar":
      include 'login_ativar.php';
      break;

    case "login":
      include 'login_alterar.php';
      break;
            
    case "anexos":
      include 'anexos_alterar.php';
      break;

    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "DELETE") {
  switch ($funcao) {

    case "secoes":
      include 'secoes_excluir.php';
      break;

    case "empresa":
      include 'empresa_excluir.php';
      break;

    case "aplicativo":
      include 'aplicativo_excluir.php';
      break;

    case "loginaplicativo":
      include 'loginaplicativo_excluir.php';
      break;

    case "login":
      include 'login_excluir.php';
      break;
      
      case "anexos":
        include 'anexos_excluir.php';
        break;

      case "loginestab":
        include 'loginestab_excluir.php';
        break;

    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}
