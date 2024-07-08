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


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {


		$img = $_FILES['imgAplicativo'];

		$pasta = "/img/brand/";
		$imgAplicativo = $img['name'];
		$novoNomeImg = uniqid(); //gerar nome aleatorio para ser guardado na pasta 
		$extensao = strtolower(pathinfo($imgAplicativo, PATHINFO_EXTENSION)); //extensao do arquivo

		if ($extensao != "" && $extensao != "jpg" && $extensao != "png")
			die("Tipo de aquivo não aceito");

		$pathImgFisico = ROOT . $pasta . $novoNomeImg . "." . $extensao;
		$pathImgURL = "/ts" . $pasta . $novoNomeImg . "." . $extensao;
		move_uploaded_file($img["tmp_name"], $pathImgFisico);


		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'nomeAplicativo' => $_POST['nomeAplicativo'],
					'appLink' => $_POST['appLink'],
					'imgAplicativo' => $_POST['imgAplicativo'],
					'pathImg' => $pathImg,
				)
			)
		);

		/*  echo json_encode($_POST);
		echo "\n";
		echo json_encode($apiEntrada);
		return;  */
		$app = chamaAPI(null, '/sistema/aplicativo', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao == "alterar") {

		$img = $_FILES['imgAplicativo'];

		$pasta = "../img/imgAplicativo/";
		$imgAplicativo = $img['name'];
		$novoNomeImg = uniqid(); //gerar nome aleatorio para ser guardado na pasta 
		$extensao = strtolower(pathinfo($imgAplicativo, PATHINFO_EXTENSION)); //extensao do arquivo

		if ($extensao != "" && $extensao != "jpg" && $extensao != "png")
			die("Tipo de aquivo não aceito");

		$pathImg = $pasta . $novoNomeImg . "." . $extensao;
		move_uploaded_file($img["tmp_name"], $pathImg);

		$apiEntrada =
		array(
			"dadosEntrada" => array(
				array(
					'idAplicativo' => $_POST['idAplicativo'],
					'nomeAplicativo' => $_POST['nomeAplicativo'],
					'appLink' => $_POST['appLink'],
					'imgAplicativo' => $_POST['imgAplicativo'],
					'pathImg' => $pathImg,
				)
			)
		);

		/* echo json_encode($apiEntrada);
		return; */
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


	header('Location: ../configuracao/aplicativo.php');
}
