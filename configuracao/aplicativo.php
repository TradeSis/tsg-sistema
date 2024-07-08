<?php
//Helio 05102023 padrao novo
//Lucas 04042023 criado
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/aplicativo.php');

$aplicativos = buscaAplicativos();
//echo json_encode($aplicativos);
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <BR> <!-- BOTOES AUXILIARES -->
        </div>
        
        <div class="row align-items-center"> <!-- LINHA SUPERIOR A TABLE -->
            <div class="col-3 text-start">
                <!-- TITULO -->
                <h2 class="ts-tituloPrincipal">Aplicativos</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="aplicativo_inserir.php" role="button" class="btn btn-success"><i
                        class="bi bi-plus-square"></i>&nbsp Novo</a>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Aplicativo</th>
                        <th>Caminho</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <?php
                foreach ($aplicativos as $aplicativo) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $aplicativo['nomeAplicativo'] ?>
                        </td>
                        <td>
                            <?php echo $aplicativo['appLink'] ?>
                        </td>


                        <td><img height="30" width="100" src="<?php echo $aplicativo['pathImg']; ?>" alt=""></td>

                        <td>
                            <a class="btn btn-warning btn-sm"
                                href="aplicativo_alterar.php?idAplicativo=<?php echo $aplicativo['idAplicativo'] ?>"
                                role="button"><i class="bi bi-pencil-square"></i></a>
                            <a class="btn btn-danger btn-sm"
                                href="aplicativo_excluir.php?idAplicativo=<?php echo $aplicativo['idAplicativo'] ?>"
                                role="button"><i class="bi bi-trash3"></i></a>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </div>


    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>