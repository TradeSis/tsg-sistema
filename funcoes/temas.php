<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../head.php');
include_once('../database/temas.php');

$temas = buscaTemas();


?>

<body class="bg-transparent">
    <div class="container text-center" style="margin-top:30px">

        <div class="row mt-4">
            <div class="col-sm-8">
                <h4 class="tituloTabela">Temas</h4>
            </div>

            <div class="col-sm-4" style="text-align:right">
                <a href="temas_inserir.php" role="button" class="btn btn-primary">Adicionar</a>
            </div>

        </div>
        <div class="card shadow mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tema</th>
                        <th>Css</th>
                        <th>Ativo</th>
                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($temas as $tema) {
                ?>
                    <tr>

                        <td><?php echo $tema['nomeTema'] ?></td>
                        <td><?php echo $tema['css'] ?></td>
                        <td><?php echo $tema['ativo'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="temas_alterar.php?idTema=<?php echo $tema['idTema'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="temas_excluir.php?idTema=<?php echo $tema['idTema'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>


</body>

</html>