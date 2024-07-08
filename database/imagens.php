<?php
// Helio 22/11/2023 - Tratamento de Imagens

function salvaimagemurl($FILES) // recebe $_FILES - Grava em ROOT/img/ , e Devolve array com URL
{
   
		$arquivos = array();

		foreach($_FILES as $key => $imagens){
       
			if(is_array($imagens)) {
				//	echo '<p>key: '.$key.' | value: '. json_encode($imagens).'</p>'  . "<HR>";
					
					if ($imagens["name"] != "") {
					//	echo json_encode($imagens) . "\n";
						
		
							preg_match("/\.(png|jpg|jpeg|svg){1}$/i", $imagens["name"], $imagensext);
		
							if ($imagensext == true) {
								$pasta =    ROOT . "/img/" . $imagens["name"];
								$url   = URLROOT . "/img/" . $imagens["name"];
								$arquivos [] = array($key => $url);
								
		
								move_uploaded_file($imagens['tmp_name'], $pasta);
							} 
		
					}
			}

		}
		//echo json_encode($arquivos) . "<HR>";
        
        return $arquivos;

}


?>