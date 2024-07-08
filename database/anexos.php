<?php
include_once __DIR__ . "/../conexao.php";

function buscaAnexos($idAnexo=null)
{
	
	$anexos = array();
	
	$apiEntrada = array(
		'idAnexo' => $idAnexo,
	);
	
	$anexos = chamaAPI(null, '/sistema/anexos', json_encode($apiEntrada), 'GET');
	
	return $anexos;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {

		$base64 = $_FILES['base64'];

		if($base64 !== null) {
			preg_match("/\.(png|jpg|jpeg|svg){1}$/i", $base64["name"],$ext);
		
			if($ext == true) {
				$pasta = ROOT . "/img/";
				$novoNome = $_POST['nomeAnexo']. "_" .$base64["name"];
				$path= 'http://' . $_SERVER["HTTP_HOST"] .'/img/' . $novoNome;
				move_uploaded_file($base64['tmp_name'], $pasta.$novoNome);
		
				$img = file_get_contents($path);
				$base64 = base64_encode($img);
			}else{
				$novoNome = "Sem_imagem";
			}
	
		}
		$apiEntrada = array(
			'nomeAnexo' => $_POST['nomeAnexo'],
			'base64' => $base64
		);

		/* echo json_encode($apiEntrada);
		return; */
		$anexos = chamaAPI(null, '/sistema/anexos', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao=="alterar") {

		$base64 = $_FILES['base64'];

		if($base64 !== null) {
			preg_match("/\.(png|jpg|jpeg|svg){1}$/i", $base64["name"],$ext);
		
			if($ext == true) {
				$pasta = ROOT . "/img/";
				$novoNome = $_POST['nomeAnexo']. "_" .$base64["name"];
				$path= 'http://' . $_SERVER["HTTP_HOST"] .'/img/' . $novoNome;
				move_uploaded_file($base64['tmp_name'], $pasta.$novoNome);
		
			}else{
				$novoNome = "Sem_imagem";
			}
	
		}
		
		$apiEntrada = array(
			'idAnexo' => $_POST['idAnexo'],
			'nomeAnexo' => $_POST['nomeAnexo'],
			'base64' => $path
		);
	
		$anexos = chamaAPI(null, '/sistema/anexos', json_encode($apiEntrada), 'POST');
	}
	
	if ($operacao=="excluir") {
		$apiEntrada = array(
			'idAnexo' => $_POST['idAnexo'],
			
		);
		$anexos = chamaAPI(null, '/sistema/anexos', json_encode($apiEntrada), 'DELETE');
	}


	header('Location: ../configuracao/anexos.php');	
	
}

?>

