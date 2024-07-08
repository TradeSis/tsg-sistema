<?php

include_once('../head.php');
include_once('../database/secao.php');
//echo json_encode($_GET['tipoSecao']);
$secoes = buscaTipoSecao($_GET['tipoSecao']);


?>

<body class="bg-transparent">
    <div class="container text-center" style="margin-top:30px"> 
        
            <div class="row mt-4">
                <div class="col-sm-8">
                        <h4 class="tituloTabela"><?php echo $_GET['tipoSecao'] ?></h4>
                        
                    </div>

                <!-- <div class="col-sm-4" style="text-align:right">
                        <a href="secao_inserir.php" role="button" class="btn btn-primary">Adicionar</a>
                    </div> -->
          
            </div>
        <div class="card shadow mt-2">
            <table class="table">
                <thead>
                    <tr>

                        <th>Titulo</th>
                        <th>Arquivo Fonte</th>

                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($secoes as $secao) {
                ?>
                    <tr>
                        <td><?php echo $secao['tituloSecao'] ?></td>
                        <td><?php echo $secao['arquivoFonte'] ?></td>
                        
                        <td>
                            <a class="btn btn-primary btn-sm" href="secao_alterar.php?idSecao=<?php echo $secao['idSecao'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="secao_excluir.php?idSecao=<?php echo $secao['idSecao'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>


</body>

</html>