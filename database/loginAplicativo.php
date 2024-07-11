<?php
//Gabriel 28042023

/* include_once('../conexao.php'); */
include_once __DIR__ . "/../conexao.php";

function buscaLoginAplicativo($idLogin = null, $nomeAplicativo = null)
{

	$loginaplicativo = array();
	$apiEntrada = array(
		'idLogin' => $idLogin,
		'nomeAplicativo' => $nomeAplicativo
	);
	$loginaplicativo = chamaAPI(null, '/sistema/loginaplicativo', json_encode($apiEntrada), 'GET');
	return $loginaplicativo;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada = array(
			'idLogin' => $_POST['idLogin'],
			'idAplicativo' => $_POST['idAplicativo'],
			'nivelMenu' => $_POST['nivelMenu']

		);

		$loginaplicativo = chamaAPI(null, '/sistema/loginaplicativo', json_encode($apiEntrada), 'PUT');

	}

	if ($operacao == "alterar") {

		$apiEntrada = array(
			'idLogin' => $_POST['idLogin'],
			'idAplicativo' => $_POST['idAplicativo'],
			'nivelMenu' => $_POST['nivelMenu']
		);

		$loginaplicativo = chamaAPI(null, '/sistema/loginaplicativo', json_encode($apiEntrada), 'POST');

	}

	if ($operacao == "excluir") {
		$apiEntrada = array(
			'idLogin' => $_POST['idLogin'],
			'idAplicativo' => $_POST['idAplicativo']
		);

		$loginaplicativo = chamaAPI(null, '/sistema/loginaplicativo', json_encode($apiEntrada), 'DELETE');

	}

	header('Location: ../configuracao/login_alterar.php?idLogin=' . $_POST['idLogin']);

}