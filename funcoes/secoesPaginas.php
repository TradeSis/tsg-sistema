<?php
include_once('../head.php');
include_once('../database/secaoPagina.php');

$secoesPaginas = buscaSecaoPaginas();


?>

<body class="bg-transparent">
    <div class="container text-center" style="margin-top:30px">

        <div class="row mt-4">
            <div class="col-sm-8">
                <h4 class="tituloTabela">Seções das Paginas</h4>

            </div>

            <div class="col-sm-4" style="text-align:right">
                <a href="secoesPaginas_inserir.php" role="button" class="btn btn-primary">Adicionar</a>
            </div>

        </div>
        <div class="card shadow mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pagina</th>
                        <th>Secão</th>
                        <th>Ordem</th>
                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($secoesPaginas as $secoesPagina) {
                ?>
                    <tr>

                        <td><?php echo $secoesPagina['tituloPagina'] ?></td>
                        <td><?php echo $secoesPagina['tituloSecao'] ?></td>
                        <td><?php echo $secoesPagina['ordem'] ?></td>

                        <td>
                            <a class="btn btn-primary btn-sm" href="secoesPaginas_alterar.php?idSecaoPagina=<?php echo $secoesPagina['idSecaoPagina'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="secoesPaginas_excluir.php?idSecaoPagina=<?php echo $secoesPagina['idSecaoPagina'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>


</body>

</html>