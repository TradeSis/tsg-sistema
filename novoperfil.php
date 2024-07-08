
<!-- PERFIL -->

        <div class="col-5 col-md-3 col-lg-2 text-end ts-bgAplicativos">
            <button class="btn text-white  dropdown-toggle position-relative mt-2 mr-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-fill"></i>&#32;<?php echo $logado ?>
                    <!-- <span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger">
                        0+
                    <span class="visually-hidden">unread messages</span> -->
            </button>
            <ul class="dropdown-menu" id="menu">
                <li style="text-align: center;">Empresa: <?php echo $_SESSION['nomeEmpresa'] ?></li>
                <hr>
                <a class="dropdown-item" href="#" id="chatTodos">Mensagens</a>
                <a class="dropdown-item" href="#" id="chatUnico">Chat Pessoal</a>
                <a class="dropdown-item" href="<?php echo URLROOT ?>/sistema/configuracao/loginPerfil_alterar.php?idLogin=<?php echo $_SESSION['idLogin'] ?>">Perfil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo URLROOT ?>/sistema/logout.php">Logout</a>
            </ul>
        </div>

<!-- PERFIL -->        