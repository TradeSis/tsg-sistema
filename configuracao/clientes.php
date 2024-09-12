<?php
include_once(__DIR__ . '/../header.php');

?>

<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>


<body>
    <div class="container-fluid pt-4">
        <div class="row">
            <!-- Coluna 1 -->
            <?php if (menuDisponivel("Posicao Cliente")) { ?>
            <div class="col">
                <div class="list-group">
                    <a href="teste.php?posicao" class="list-group-item">
                        <div class="row g-0">
                            <div class="col-1 text-center " style="width: 50px;">
                                <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                            </div>
                            <div class="col ms-2 me-auto">
                                <div class="fw-bold">Posição do Cliente</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php if (menuDisponivel("Historico Cliente")) { ?>
            <!-- Coluna 2 -->
            <div class="col">
                <div class="list-group">
                    <a href="teste.php?historico" class="list-group-item">
                        <div class="row g-0">
                            <div class="col-1 text-center " style="width: 50px;">
                                <i class="bi bi-file-earmark-text" style="font-size: 35px;"></i>
                            </div>
                            <div class="col ms-2 me-auto">
                                <div class="fw-bold">Histórico do Cliente</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>



    </div>

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>