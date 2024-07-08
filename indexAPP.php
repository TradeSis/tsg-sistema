<?php
//Lucas 05042023 - adicionado foreach para menuLateral.
//gabriel 220323 11:19 - adicionado IF para usuario cliente
//Lucas 13032023 - criado versão 2 do menu.

include_once 'head.php';
include_once 'database/aplicativo.php';
$aplicativos = buscaAplicativosMenu($_SESSION['idUsuario']);
?>

<link rel="stylesheet" href="css/painel.css">

<body>


    <nav class="Menu navbar navbar-expand topbar static-top shadow">


        <a href="<?php echo URLROOT ?>/sistema" class="logo" style="margin-left:109px"><img src="../img/brand/white.png"
                width="150"></a>

        <div class=" col-md navbar navbar-expand navbar1">
            <ul class="navbar-nav mx-auto ml-4" id="novoMenu2">
                <?php if (isset($aplicativos['idAplicativo'])) { ?>
                    <li>
                        <a href="<?php echo $aplicativos['appLink'] ?>" href="#" class="nav-link" role="button">
                            <span class="fs-5 text">
                                <?php echo $aplicativos['nomeAplicativo'] ?>
                            </span>
                        </a>
                    </li>
                <?php } else {
                    foreach ($aplicativos as $aplicativo) {
                        ?>
                        <li>
                            <a href="<?php echo $aplicativo['appLink'] ?>" href="#" class="nav-link" role="button">
                                <span class="fs-5 text">
                                    <?php echo $aplicativo['nomeAplicativo'] ?>
                                </span>
                            </a>
                        </li>
                    <?php }
                } ?>
            </ul>

        </div>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ">

            <!-- Email -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-envelope-exclamation-fill"></i>

                    <span class="badge badge-danger badge-counter"></span>
                </a>

                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        Emails Recebidos
                    </h6>

                    <a class="dropdown-item text-center small text-gray-500" href="#">Ver todas as mensagens</a>
                </div>
            </li>

            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="fs-1 text">
                        <?php echo $logado ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item"
                        href="<?php echo URLROOT ?>/sistema/configuracao/usuario_alterar.php?idUsuario=<?php echo $_SESSION['idUsuario'] ?>">
                        <i class="bi bi-person-circle"></i>&#32;
                        Perfil
                    </a>
                    <a class="dropdown-item" href="<?php echo URLROOT ?>/sistema/">
                        <i class="bi bi-display"></i>&#32;
                        Painel
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="bi bi-box-arrow-right"></i>&#32;
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>


    <!-- Modal sair -->
    <div class="modal fade" id="logoutModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Logout" abaixo se você deseja encerrar sua sessão.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary logout" href="<?php echo URLROOT ?>/sistema/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid mt-5">
        <h1 class="heading"><a href="#"><img src="../img/brand/logo.png" width="400"></a></h1>
    </div>

</body>

</html>