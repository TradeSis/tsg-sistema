<?php
//Lucas 05042023 criado
//echo "sistema/aplicativo.php<hr>";
include_once __DIR__ . "/../conexao.php";

function buscaAplicativos($idAplicativo = null)
{

	$app = array();

	$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idAplicativo' => $idAplicativo
				)
			)
		);
	$app = chamaAPI(null, '/sistema/aplicativo', json_encode($apiEntrada), 'GET');
	return $app;
}

function buscaAplicativosMenu($idLogin)
{

	$app = array();

	$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idLogin' => $idLogin
				)
			)
		);
	$app = chamaAPI(null, '/sistema/aplicativo', json_encode($apiEntrada), 'GET');
	return $app;
}
function buscaMenus($nomeAplicativo=null, $idMenu=null)
{

	$menu = array();

	$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'nomeAplicativo' => $nomeAplicativo,
					'idMenu' => $idMenu
				)
			)
		);
	$menu = chamaAPI(null, '/sistema/aplicativo/menu', json_encode($apiEntrada), 'GET');
	return $menu;
} 


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'nomeAplicativo' => $_POST['nomeAplicativo'],
					'appLink' => $_POST['appLink'],
				)
			)
		);

		$app = chamaAPI(null, '/sistema/aplicativo', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao == "alterar") {


		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idAplicativo' => $_POST['idAplicativo'],
					'nomeAplicativo' => $_POST['nomeAplicativo'],
					'appLink' => $_POST['appLink'],
				)
			)
		);

		$app = chamaAPI(null, '/sistema/aplicativo', json_encode($apiEntrada), 'POST');
	}


	//BUSCA PRINCIPAL DA TABELA DE APLICATIVOS
	if ($operacao == "filtrar") {

		$buscaaplicativo = $_POST["buscaaplicativo"];

		if ($buscaaplicativo == "") {
			$buscaaplicativo = null;
		}

		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idAplicativo' => null,
					'buscaaplicativo' => $buscaaplicativo,
				)
			)
		);

		$app = chamaAPI(null, '/sistema/aplicativo', json_encode($apiEntrada), 'GET');

		echo json_encode($app);
		return $app;
	}

	//BUSCA PARA O MODAL DE ALTERAR 
	if ($operacao == "buscar") {
		$idAplicativo = $_POST['idAplicativo'];
		if ($idAplicativo == "") {
			$idAplicativo = null;
		}
		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idAplicativo' => $idAplicativo,
				)
			)
		);
		$app = chamaAPI(null, '/sistema/aplicativo', json_encode($apiEntrada), 'GET');

		echo json_encode($app);
		return $app;
	}

	if ($operacao == "inserirMenu") {

		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'nomeMenu' => $_POST['nomeMenu'],
					'idAplicativo' => $_POST['idAplicativo'],
					'idMenuSuperior' => $_POST['idMenuSuperior']
				)
			)
		);

		$menu = chamaAPI(null, '/sistema/aplicativo/menu', json_encode($apiEntrada), 'PUT');
		header('Location: ../configuracao/aplicativo_alterar.php?idAplicativo='.$_POST['idAplicativo']);
	}
	
	if ($operacao == "alterarMenu") {
		
		
		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idMenu' => $_POST['idMenu'],
					'nomeMenu' => $_POST['nomeMenu'],
					'idAplicativo' => $_POST['idAplicativo'],
					'idMenuSuperior' => $_POST['idMenuSuperior']
				)
			)
		);
				
		$menu = chamaAPI(null, '/sistema/aplicativo/menu', json_encode($apiEntrada), 'POST');
		header('Location: ../configuracao/aplicativo_alterar.php?idAplicativo='.$_POST['idAplicativo']);
	}
	if ($operacao == "buscarMenu") {

		$nomeAplicativo = isset($_POST["nomeAplicativo"]) && $_POST["nomeAplicativo"] !== "" ? $_POST["nomeAplicativo"] : null;
		$idMenu = isset($_POST["idMenu"]) && $_POST["idMenu"] !== "" ? $_POST["idMenu"] : null;
		
		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'nomeAplicativo' => $nomeAplicativo,
					'idMenu' => $idMenu
				)
			)
		);
				
		$menu = chamaAPI(null, '/sistema/aplicativo/menu', json_encode($apiEntrada), 'GET');
		echo json_encode($menu);
		return $menu;
	}


	header('Location: ../configuracao/aplicativo.php');
}
