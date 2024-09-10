<?php
include_once __DIR__ . "/../config.php";
include_once "header.php";

if(!isset($_SESSION['menu'])){
    include_once ROOT . "/sistema/database/perfil.php";
    $menus = buscaPerfilMenu($_SESSION['idPerfil']);
    
    
    $menu = array();
    if (isset($menus['idMenu'])) {
        $menu[] = $menus["idMenu"];
    } else {
        foreach ($menus as $unico) {
            $menu[] = $unico["idMenu"];
        }
    }
    $_SESSION['menu'] = $menu;
} 

// helio 051023 - TODO PROGRAMA PRECISA TER DOCTYPE/HTML/HEAD no seu inicio
?>
<!doctype html>
<html lang="pt-BR">
<head>
    
    <?php include_once ROOT. "/vendor/head_css.php";?>
    <title>Sistema</title>

</head>

<body>

    <?php include_once  ROOT . "/sistema/painelmobile.php"; ?>

    <div class="d-flex">

        <?php include_once  ROOT . "/sistema/painel.php"; ?>

        <div class="container-fluid">

            <div class="row ">
                <div class="col-lg-10 d-none d-md-none d-lg-block pr-0 pl-0 ts-bgAplicativos">
                    <ul class="nav a" id="myTabs">

                        <?php
                        $tab = '';

                        if (isset($_GET['tab'])) {
                            $tab = $_GET['tab'];
                        }
                        ?>
                        <?php if (in_array("Empresa", $_SESSION['menu'])) {
                            if ($tab == '') {
                                $tab = 'empresa';
                            } ?>
                            <li class="nav-item mr-1 ">
                                <a class="nav-link 
                                <?php if ($tab == "empresa") {echo " active ";} ?>" 
                                href="?tab=empresa" role="tab">Empresa</a>
                            </li>
                        <?php }
                        if (in_array("Login", $_SESSION['menu'])) { ?>
                            <li class="nav-item mr-1 ">
                                <a class="nav-link 
                                <?php if ($tab == "login") {echo " active ";} ?>" 
                                href="?tab=login" role="tab">Login</a>
                            </li>
                        <?php }
                        if (in_array("Aplicativos", $_SESSION['menu'])) { ?>
                            <li class="nav-item mr-1 ">
                                <a class="nav-link 
                                <?php if ($tab == "aplicativo") {echo " active ";} ?>" 
                                href="?tab=aplicativo" role="tab">Aplicativos</a>
                            </li>
                        <?php }
                         if (in_array("Aplicativo Padrao", $_SESSION['menu'])) { ?>
                            <li class="nav-item mr-1 ">
                                <a class="nav-link 
                                <?php if ($tab == "aplicativo_padrao") {echo " active ";} ?>" 
                                href="?tab=aplicativo_padrao" role="tab">Aplicativo padrão</a>
                            </li>
                        <?php }
                        if (in_array("Anexos", $_SESSION['menu'])) { ?>
                            <li class="nav-item mr-1 ">
                                <a class="nav-link 
                                <?php if ($tab == "anexos") {echo " active ";} ?>" 
                                href="?tab=anexos" role="tab">Anexos</a>
                            </li>
                        <?php } 
                        if (in_array("Perfil", $_SESSION['menu'])) { ?>
                            <li class="nav-item mr-1 ">
                                <a class="nav-link 
                                <?php if ($tab == "perfil") {echo " active ";} ?>" 
                                href="?tab=perfil" role="tab">Perfil</a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
                <!--Essa coluna só vai aparecer em dispositivo mobile-->
                <div class="col-7 col-md-9 d-md-block d-lg-none ts-bgAplicativos">
                <!--atraves do GET testa o valor para selecionar um option no select-->
                <?php if(isset($_GET['tab'])){
                    $getTab = $_GET['tab'];
                }else{
                    $getTab = '';
                }?>
                    <select class="form-select mt-2 ts-selectSubMenuAplicativos" id="subtabSistema">

                        <?php if (in_array("Empresa", $_SESSION['menu'])) { ?>
                        <option value="<?php echo URLROOT ?>/sistema/?tab=empresa"
                        <?php if ($getTab == "empresa") {echo " selected ";} ?>>Empresa</option>
                        <?php }

                        if (in_array("Login", $_SESSION['menu'])) { ?>
                        <option value="<?php echo URLROOT ?>/sistema/?tab=login" 
                        <?php if ($getTab == "login") {echo " selected ";} ?>>Login</option>
                        <?php }

                        if (in_array("Aplicativos", $_SESSION['menu'])) { ?>
                        <option value="<?php echo URLROOT ?>/sistema/?tab=aplicativo" 
                        <?php if ($getTab == "aplicativo") {echo " selected ";} ?>>Aplicativos</option>
                        <?php }

                        if (in_array("Aplicativo Padrao", $_SESSION['menu'])) { ?>
                        <option value="<?php echo URLROOT ?>/sistema/?tab=aplicativo_padrao" 
                        <?php if ($getTab == "aplicativo_padrao") {echo " selected ";} ?>>Aplicativo padrão</option>
                        <?php }

                        if (in_array("Anexos", $_SESSION['menu'])) { ?>
                        <option value="<?php echo URLROOT ?>/sistema/?tab=anexos" 
                        <?php if ($getTab == "anexos") {echo " selected ";} ?>>Anexos</option>
                        <?php } 

                        if (in_array("Perfil", $_SESSION['menu'])) { ?>
                        <option value="<?php echo URLROOT ?>/sistema/?tab=perfil" 
                        <?php if ($getTab == "perfil") {echo " selected ";} ?>>Perfil</option>
                        <?php } ?>

                    </select>
                </div>
                
                <?php include_once  ROOT . "/sistema/novoperfil.php"; ?>

            </div><!--row-->
         
            <?php

            $src = "";
            $title = "Sistema";

            if ($tab == "empresa") {
                $src = "configuracao/empresa.php";
                $title = "Sistema/Empresa";
            }
            if ($tab == "login") {
                $src = "configuracao/login.php";
                $title = "Sistema/Login";
            }
            if ($tab == "aplicativo") {
                $src = "configuracao/aplicativo.php";
                $title = "Sistema/Aplicativo";
            }
            if ($tab == "anexos") {
                $src = "configuracao/anexos.php";
                $title = "Sistema/Anexos";
            }
            if ($tab == "perfil") {
                $src = "configuracao/perfil.php";
                $title = "Sistema/Perfil";
            }
            if ($tab == "aplicativo_padrao") {
                $src = "configuracao/aplicativo_padrao.php";
                $title = "Sistema/Aplicativo_padrao";
            }
            if ($tab == "configuracao") {
                $src = "configuracao/";
                $title = "Sistema/Configuração";
                if (isset($_GET['stab'])) {
                    $src = $src . "?stab=" . $_GET['stab'];
                }
            }
            if ($src !== "") { ?>
                <div class="container-fluid p-0 m-0">
                    <iframe class="row p-0 m-0 ts-iframe"  src="<?php echo URLROOT ?>/sistema/<?php echo $src ?>"></iframe>
                </div>
            <?php } ?>

        </div><!-- div container -->
    </div><!-- div class="d-flex" -->


    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT. "/vendor/footer_js.php";?>

    <script src="js/mobileSelectTabs.js"></script>


    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>