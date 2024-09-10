<?php
//Lucas 05042023 criado
//echo "sistema/aplicativo.php<hr>";
include_once __DIR__ . "/../conexao.php";

function buscaPerfil($idPerfil=null)
{

	$perfil = array();

	$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idPerfil' => $idPerfil
				)
			)
		);
	$perfil = chamaAPI(null, '/sistema/perfil', json_encode($apiEntrada), 'GET');
	return $perfil;
}
function buscaPerfilMenu($idPerfil=null,$idAplicativo=null,$idMenu=null)
{

	$perfilmenu = array();

	$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idPerfil' => $idPerfil,
					'idAplicativo' => $idAplicativo,
					'idMenu' => $idMenu
				)
			)
		);
	$perfilmenu = chamaAPI(null, '/sistema/perfilmenu', json_encode($apiEntrada), 'GET');
	return $perfilmenu;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

    if ($operacao == "inserir") {

		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idPerfil' => $_POST['idPerfil'],
					'aplicativos' => $_POST['aplicativos']
				)
			)
		);

		$perfil = chamaAPI(null, '/sistema/perfil', json_encode($apiEntrada), 'PUT');
		echo json_encode($perfil);
		return $perfil;
	}

	if ($operacao == "buscar") {

		$idPerfil = isset($_POST["idPerfil"]) && $_POST["idPerfil"] !== "" ? $_POST["idPerfil"] : null;
		
		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idPerfil' => $idPerfil
				)
			)
		);
				
		$perfil = chamaAPI(null, '/sistema/perfil', json_encode($apiEntrada), 'GET');
		echo json_encode($perfil);
		return $perfil;
	}

	if ($operacao == "inserirPerfilMenu") {
		
		$apiEntrada =
		array(
			"dadosEntrada" => $_POST['apiEntrada']
		);
				
		$perfilmenu = chamaAPI(null, '/sistema/perfilmenu', json_encode($apiEntrada), 'PUT');
		echo json_encode($perfilmenu);
		return $perfilmenu;
	} 

	if ($operacao == "buscarPerfilMenu") {

		$idPerfil = isset($_POST["idPerfil"]) && $_POST["idPerfil"] !== "" ? $_POST["idPerfil"] : null;
		$idAplicativo = isset($_POST["idAplicativo"]) && $_POST["idAplicativo"] !== "" ? $_POST["idAplicativo"] : null;
		$idMenu = isset($_POST["idMenu"]) && $_POST["idMenu"] !== "" ? $_POST["idMenu"] : null;
		
		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idPerfil' => $idPerfil,
					'idAplicativo' => $idAplicativo,
					'idMenu' => $idMenu
				)
			)
		);
				
		$perfilmenu = chamaAPI(null, '/sistema/perfilmenu', json_encode($apiEntrada), 'GET');
		echo json_encode($perfilmenu);
		return $perfilmenu;
	}


	header('Location: ../configuracao/perfil.php');
}

