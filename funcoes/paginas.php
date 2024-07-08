<?php
// helio 01022023 altereado para include_once
// helio 26012023 16:16

include_once('../head.php');
include_once('../database/paginas.php');
include_once('../database/temas.php');

if (isset($_GET['idTema'])) {
    $idTema = $_GET['idTema'];
} else {
    $idTema = null;
}

/* 
echo json_encode($tema);
return; */
//$idTema = 2;
$paginas = buscaPaginas(null, $idTema);
$temas = buscaTemas();

//echo json_encode($temas);
//return;
?>

<body class="bg-transparent">
    <div class="container " style="margin-top:30px">

        <div class="row mt-4">
            <div class="col-sm-8">
                <h4 class="tituloTabela">Paginas</h4>
            </div>

            <div class="col-sm-4" style="text-align:right">
                <a href="paginas_inserir.php" role="button" class="btn btn-primary">Adicionar</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3" style="margin-top: 10px">
                <div class="select-form-group">
                    <label class="labelForm">Selecionar Tema</label>
                    <select class="select form-control" name="idTema" id="idTema">
                        <option onclick="limparSearch()" value="5">Todos</option>
                        <?php
                        foreach ($temas as $tema) {
                        ?>
                            <option onclick="searchData()" value="<?php echo $tema['idTema'] ?>"><?php echo $tema['nomeTema']  ?></option>
                        <?php  } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-3" style="margin-top: 35px; margin-left:-20px; text-align:left">
                <button type="submit" class="btn btn-sm btn-secondary" onclick="limparSearch()"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>


        <div class="card shadow mt-2 text-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>Slug</th>
                        <th>Titulo</th>
                        <th>Arquivo Fonte</th>
                        <th>ID Tema</th>
                        <th>Nome Tema</th>
                        <th>Ação</th>

                    </tr>
                </thead>

                <?php
                foreach ($paginas as $pagina) {
                ?>
                    <tr>
                        <td><?php echo $pagina['slug'] ?></td>
                        <td><?php echo $pagina['tituloPagina'] ?></td>
                        <td><?php echo $pagina['arquivoFonte'] ?></td>
                        <td><?php echo $pagina['idTema'] ?></td>
                        <td><?php echo $pagina['nomeTema'] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="paginas_alterar.php?idPagina=<?php echo $pagina['idPagina'] ?>" role="button">Editar</a>
                            <a class="btn btn-danger btn-sm" href="paginas_excluir.php?idPagina=<?php echo $pagina['idPagina'] ?>" role="button">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>


    <script>
        var select = document.getElementById('idTema')

        select.addEventListener('change', function() {
            /* console.log(select.value) */
            window.location = '?idTema=' + select.value;
        })

        function searchData() {
            window.location = 'paginas';
        }

        function limparSearch() {
            window.location = 'paginas.php';
        }
    </script>
</body>

</html>