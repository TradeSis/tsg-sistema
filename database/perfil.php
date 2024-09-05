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


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

    if ($operacao == "inserir") {

		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'nomePerfil' => $_POST['nomePerfil'],
					'aplicativos' => $_POST['aplicativos'],
					'menus' => $_POST['menus'],
					'pEXC' => $_POST['pEXC'],
					'pALT' => $_POST['pALT'],
					'pINS' => $_POST['pINS']
				)
			)
		);

		$perfil = chamaAPI(null, '/sistema/perfil', json_encode($apiEntrada), 'PUT');
		//header('Location: ../configuracao/aplicativo_alterar.php?idAplicativo='.$_POST['idAplicativo']);
	}

	/*if ($operacao == "alterar") {
		
		
		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idPerfil' => $_POST['idPerfil'],
					'nomePerfil' => $_POST['nomePerfil'],
					'aplicativos' => $_POST['aplicativos'],
					'menus' => $_POST['menus'],
					'pEXC' => $_POST['pEXC'],
					'pALT' => $_POST['pALT'],
					'pINS' => $_POST['pINS']
				)
			)
		);
				
		$perfil = chamaAPI(null, '/sistema/perfil', json_encode($apiEntrada), 'POST');
		//header('Location: ../configuracao/aplicativo_alterar.php?idAplicativo='.$_POST['idAplicativo']);
	} */
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


	header('Location: ../configuracao/perfil.php');
}
