<?php
// helio 21032023 - compatibilidade chamada chamaApi
// Lucas 08032023 alterado buscaUsuarios(nomeUsuario=null) para buscaUsuarios($idUsuario=null)
// gabriel 06022023 adicionado função busca atendente
// helio 01022023 consertado operacao inserir
// helio 01022023 altereado para include_once, usando funcao conectaMysql
// helio 26012023 16:16

//include_once('../conexao.php');
include_once __DIR__ . "/../conexao.php";

function buscaLogins($idLogin=null)
{

	$login = array();	
	
	$apiEntrada = array(
		'idLogin' => $idLogin,
	);	
	$login = chamaAPI(null, '/sistema/login', json_encode($apiEntrada), 'GET');
	return $login;
}

function buscaAtendente($idUsuario=null)
{
	$atendente = array();
	$apiEntrada = array(
		'idUsuario' => $idUsuario,
	);
	$atendente = chamaAPI(null, '/sistema/atendente', json_encode($apiEntrada), 'GET');
	return $atendente;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {
		$apiEntrada = array(
			'loginNome' => $_POST['loginNome'],
			'email' => $_POST['email'],
			'cpfCnpj' => $_POST['cpfCnpj'],
			'idEmpresa' => $_POST['idEmpresa'],
			'pedeToken' => $_POST['pedeToken'],
			'password' => $_POST['password']
			
		);
		$login = chamaAPI(null, '/sistema/login', json_encode($apiEntrada), 'PUT');
		header('Location: ../configuracao/login.php');
	}

	if ($operacao == "alterar") {
	
		$apiEntrada = array(
			'acao' => "login",
			'idLogin' => $_POST['idLogin'],
			'loginNome' => $_POST['loginNome'],
			'email' => $_POST['email'],
			'cpfCnpj' => $_POST['cpfCnpj'],
			'pedeToken' => $_POST['pedeToken']
		);
		
		$login = chamaAPI(null, '/sistema/login', json_encode($apiEntrada), 'POST');
		header('Location: ../configuracao/login.php');
	}

	if ($operacao == "loginalterar") {
		
		$apiEntrada = array(
			'acao' => "login",
			'idLogin' => $_POST['idLogin'],
			'loginNome' => $_POST['loginNome'],
			'email' => $_POST['email'],
			'cpfCnpj' => $_POST['cpfCnpj'],
			'pedeToken' => $_POST['pedeToken']
		);
		
		$login = chamaAPI(null, '/sistema/login', json_encode($apiEntrada), 'POST');
		header('Location:' . $_POST['ultimaulr']);
	}

	if ($operacao == "senha") {
		
		$apiEntrada = array(
			'acao' => "senha",
			'idLogin' => $_POST['idLogin'],
			'password' => $_POST['password']
		);
		
		$login = chamaAPI(null, '/sistema/login', json_encode($apiEntrada), 'POST');
		header('Location:' . $_POST['ultimaulr']);
	}


	if ($operacao == "excluir") {
		$apiEntrada = array(
			'idLogin' => $_POST['idLogin']
		);
		$login = chamaAPI(null, '/sistema/login', json_encode($apiEntrada), 'DELETE');

		header('Location: ../configuracao/login.php');
	}
	
	if ($operacao == "verificaSenha") {
		$senhaAtual = $_POST['senhaAtual'];
		$senhaAtualMD5 = md5($senhaAtual);
		echo $senhaAtualMD5;
	}
	
	if ($operacao == "ativar") {
		$apiEntrada = array(
			'idLogin' => $_POST['idLogin'],
			'secret_key' => $_POST['secret_key'] // no ativar, guarda a secret
		);


		$login = chamaAPI(null, '/sistema/login/ativar', json_encode($apiEntrada), 'POST');
	
		header('Location: ../login.php');
	}


}
