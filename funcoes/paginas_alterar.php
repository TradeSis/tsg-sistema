<?php

include_once('../head.php');
include_once('../database/paginas.php');
include_once('../database/secaoPagina.php');


$idPagina = $_GET['idPagina'];
$pagina = buscaPaginas($idPagina);
$secoesPaginas = buscaSecaoPagina($idPagina);
?>

<body class="bg-transparent">

    <div class="container" style="margin-top:20px">

        <div class="row mt-4">

            <div class="col-sm-8">
                <h4 class="tituloTabela">Paginas</h4>
            </div>

            <div class="col-sm-4" style="text-align:right">
                <a href="paginas.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
            </div>

        </div>
        <div class="container" style="margin-top: 10px">

            <form action="../database/paginas.php?operacao=alterar" method="post">

                <div class="row">
                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class="labelForm">Slug</label>
                            <input type="text" name="slug" class="form-control" value="<?php echo $pagina['slug'] ?>" disabled>
                            <input type="text" class="form-control" name="idPagina" value="<?php echo $pagina['idPagina'] ?>" style="display: none">
                        </div>
                    </div>
                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class="labelForm">Titulo</label>
                            <input type="text" name="tituloPagina" class="form-control" value="<?php echo $pagina['tituloPagina'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class="labelForm">Arquivo Fonte</label>
                            <input type="text" name="arquivoFonte" class="form-control" value="<?php echo $pagina['arquivoFonte'] ?>">
                        </div>
                    </div>

                    <div class="col-sm-3" style="margin-top: 10px">
                        <div class="form-group">
                            <label class="labelForm">Arquivo Single</label>
                            <input type="text" name="arquivoSingle" class="form-control" value="<?php echo $pagina['arquivoSingle'] ?>">
                        </div>
                    </div>
                </div>

                <div style="text-align:right; margin-right:-10px">
                    <button type="submit" class="btn btn-sm btn-success">Salvar</button>
                </div>
                <div class="card-footer bg-transparent" style=" margin-top: 40px">
                </div>
            </form>

            <div class="card shadow mt-2">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Pagina</th>
                            <th>Secão</th>
                            <th>Ordem</th>
                            <th>Ação</th>

                        </tr>
                    </thead>
                    <?php
                    foreach ($secoesPaginas as $secoesPagina) { ?>

                        <tr>

                            <td><?php echo $pagina['tituloPagina'] ?></td>
                            <td><?php echo $secoesPagina['tituloSecao'] ?></td>
                            <td><?php echo $secoesPagina['ordem'] ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="secoesPaginas_alterar.php?idSecaoPagina=<?php echo $secoesPagina['idSecaoPagina'] ?>" role="button">Editar</a>
                                <a class="btn btn-warning btn-sm" href="secoesPaginas_excluir.php?idSecaoPagina=<?php echo $secoesPagina['idSecaoPagina'] ?>" role="button">Remover</a>
                            </td>
                        </tr>
                    <?php } ?>

                </table>
                <div class="py-3 px-3" style="text-align:right">
                    <a href="secoesPaginas_inserir.php?idPagina=<?php echo $idPagina ?>" role="button" class="btn btn-primary">Adicionar</a>
                </div>
            </div>




        </div>

    </div>



</body>

</html>