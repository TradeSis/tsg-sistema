<?php
// Lucas 06102023 padrao novo
//Lucas 09032023 - adicionado um segundo parametro no buscaUsuario 
// helio 01022023 altereado para include_once
// helio 26012023 16:16
include_once(__DIR__ . '/../header.php');
include_once(__DIR__ . '/../database/login.php');
include_once(__DIR__ . '/../database/empresa.php');
$logins = buscaLogins();
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
                <h2 class="ts-tituloPrincipal">Login</h2>
            </div>
            <div class="col-7">
                <!-- FILTROS -->
            </div>

            <div class="col-2 text-end">
                <a href="login_inserir.php" role="button" class="btn btn-success"><i class="bi bi-plus-square"></i>&nbsp Novo</a>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela">
            <table class="table table-hover table-sm align-middle">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Empresa</th>
                        <th>Cpf/Cnpj</th>
                        <th>Token</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <?php
                foreach ($logins as $login) {
                ?>
                    <tr>
                        <td><?php echo $login['loginNome'] ?></td>
                        <td><?php echo $login['email'] ?></td>
                        <td><?php echo $login['nomeEmpresa'] ?></td>
                        <td><?php echo $login['cpfCnpj'] ?></td>
                        <td><?php echo $login['pedeToken'] == 1 ? 'Sim' : 'Não'; ?></td>
                        <td>
                            <a class=" btn btn-warning btn-sm" href="login_alterar.php?idLogin=<?php echo $login['idLogin'] ?>" role="button"><i class="bi bi-pencil-square"></i></a>

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