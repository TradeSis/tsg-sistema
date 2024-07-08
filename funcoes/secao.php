<?php

include_once('../head.php');
include_once('../database/secao.php');

$secoes = buscaSecao();
/* echo json_encode($secoes); */

?>
<style>
    .nav-item{
        cursor: pointer;
    }
 
</style>
<body class="bg-transparent">
    <div class="container text-center" style="margin-top:30px"> 
        
            <div class="row mt-4">
                <div class="col-sm-8">
                        <h4 class="tituloTabela">Seções</h4>
                        
                    </div>

                <div class="col-sm-4" style="text-align:right">
                        <a href="secao_inserir.php" role="button" class="btn btn-primary">Adicionar</a>
                    </div>
          
            </div>
<!--=== Conteudo ===-->
            <ul class="nav nav-tabs" id="iframeMenu">
                <li class="nav-item">
                    <a class="nav-link" style="color: #000;" src="secao_todos.php">Todas</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" id="tab1" src="secao_tipoSecao.php?tipoSecao=header" style="color: #000;">Header</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" id="tab2" src="secao_tipoSecao.php?tipoSecao=footer" style="color: #000;">Footer</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" src="secao_tipoSecao.php?tipoSecao=principal" style="color: #000;">Principal</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" src="secao_tipoSecao.php?tipoSecao=card" style="color: #000;">Card</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" src="secao_tipoSecao.php?tipoSecao=lista" style="color: #000;">Lista</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" src="secao_tipoSecao.php?tipoSecao=form" style="color: #000;">Form</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" src="secao_tipoSecao.php?tipoSecao=divisorPagina" style="color: #000;">Divisor</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" src="secao_tipoSecao.php?tipoSecao=quemSomos" style="color: #000;">Quem Somos</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" src="secao_tipoSecao.php?tipoSecao=slides" style="color: #000;">Slides</a>
                </li>
                <li class="nav-item" >
                    <a class="nav-link" src="secao_tipoSecao.php?tipoSecao=blog" style="color: #000;">Blog</a>
                </li>
            </ul>



            <div class="diviFrame" style="overflow:hidden; height:850px" >
                <iframe class="iFrame container-fluid " id="myIframe" src="secao_todos.php" height="850px"></iframe>
            </div>

    </div>



<script>

    $(document).ready(function() {

	// IFRAMA
	$("#iframeMenu a").click(function() {

		var value = $(this).text();
		value = $(this).attr('src');
		/* alert (value); */

		//IFRAME TAG
		if (value) {
			$("#myIframe").attr('src', value);

		}
		})

	});


</script>
</body>

</html>