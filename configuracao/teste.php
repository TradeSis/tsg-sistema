<?php
// lucas 120320204 id884 bootstrap local - alterado head
// gabriel 27022023 13:51 ajustado action ?parametros
// gabriel 22022023 16:00

include_once '../header.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <BR> <!-- MENSAGENS/ALERTAS -->
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6 card p-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3><?php echo isset($_GET['posicao']) ? 'Posição do Cliente' : 'Histórico do Cliente'; ?></h3>
                        </div>
                        <div class="col-sm-4" style="text-align:right">
                            <a href="clientes.php" role="button" class="btn btn-primary btn-sm">Voltar</a>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <h5>
                    <?php echo isset($_GET['posicao']) ? 'TESTE POSICAO OK' : 'TESTE HISTORICO OK'; ?>
                    </h5>
                </div>
            </div>
        </div>
    </div>

<!-- LOCAL PARA COLOCAR OS JS -->

<!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>