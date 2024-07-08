<?php
//Gabriel 28042023

/* include_once('../conexao.php'); */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . "/../conexao.php";

function buscaLoginEstab($idLogin = null, $etbcod = null, $idEmpresa = null)
{

	$loginestab = array();
	$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idLogin' => $idLogin,
					'etbcod' => $etbcod,
					'idEmpresa' => $idEmpresa
				)
			)
		);
	$loginestab = chamaAPI(null, '/sistema/loginestab', json_encode($apiEntrada), 'GET');
	return $loginestab;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idLogin' => $_POST['idLogin'],
					'etbcod' => $_POST['etbcod'],
					'idEmpresa' => $_POST['idEmpresa']
				)
			)
		);

		$loginestab = chamaAPI(null, '/sistema/loginestab', json_encode($apiEntrada), 'PUT');

	}

	if ($operacao == "alterar") {
		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idLogin' => $_POST['idLogin'],
					'etbcod' => $_POST['etbcod'],
					'vetbcod' => $_POST['vetbcod'],
					'idEmpresa' => $_POST['idEmpresa']
				)
			)
		);

		$loginestab = chamaAPI(null, '/sistema/loginestab', json_encode($apiEntrada), 'POST');

	}

	if ($operacao == "excluir") {
		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idLogin' => $_POST['idLogin'],
					'etbcod' => $_POST['etbcod'],
					'idEmpresa' => $_POST['idEmpresa']
				)
			)
		);

		$loginestab = chamaAPI(null, '/sistema/loginestab', json_encode($apiEntrada), 'DELETE');

	}


	if ($operacao == "buscar") {

		$idLogin = isset($_POST["idLogin"])  && $_POST["idLogin"] !== "" && $_POST["idLogin"] !== "null" ? $_POST["idLogin"]  : null;
		$etbcod = isset($_POST["etbcod"])  && $_POST["etbcod"] !== "" && $_POST["etbcod"] !== "null" ? $_POST["etbcod"]  : null;
		$idEmpresa = isset($_POST["idEmpresa"])  && $_POST["idEmpresa"] !== "" && $_POST["idEmpresa"] !== "null" ? $_POST["idEmpresa"]  : null;

		$apiEntrada =
			array(
				"dadosEntrada" => array(
					array(
						'idLogin' => $idLogin,
						'etbcod' => $etbcod,
						'idEmpresa' => $idEmpresa
					)
				)
			);
		$loginestab = chamaAPI(null, '/sistema/loginestab', json_encode($apiEntrada), 'GET');
		echo json_encode($loginestab);
		return $loginestab;

	}

	header('Location: ../configuracao/login_alterar.php?id=estab&&idLogin=' . $_POST['idLogin']);

}