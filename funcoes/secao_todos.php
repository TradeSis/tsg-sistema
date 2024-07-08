<?php

include_once('../head.php');
include_once('../database/secao.php');

$secoes = buscaSecao();
/* echo json_encode($secoes); */

?>

<body class="bg-transparent">
    <div class="container text-center" style="margin-top:30px"> 
        
            <div class="row mt-4">
                <div class="col-sm-8">
                        <h4 class="tituloTabela">Todas</h4>
                        
                    </div>

                <!-- <div class="col-sm-4" style="text-align:right">
                        <a href="secao_inserir.php" role="button" class="btn btn-primary">Adicionar</a>
                    </div> -->
          
            </div>
        <div class="card shadow mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo Seção</th>
                        <th>Titulo</th>
                        <th>Arquivo Fonte</th>

                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($secoes as $secao) {
                ?>
                    <tr>
                        <td><?php echo $secao['tipoSecao'] ?></td>
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